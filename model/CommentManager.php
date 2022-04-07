<?php

declare(strict_types=1);

namespace CommentManager;

use Manager\Manager;

class CommentManager extends Manager
{
    public function createComment($username, $comment, $postId, $userId): ?bool
    {
        $enabled = 0;
        $createdAt = date("Y-m-d H:i:s");

        try {
            $req = $this->db->prepare('INSERT INTO commentary (enabled, user_name, content, created_at, publication_id, user_id) 
            VALUES (:enabled, :userName, :content, :createdAt, :publicationId, :userId )');
            $req->execute(array(
                'enabled' => $enabled,
                'userName' => $username,
                'content' => $comment,
                'createdAt' => $createdAt,
                'publicationId' => $postId,
                'userId' => empty($userId) ? null : $userId,
            ));

            $data = $req->fetch();

            if (isset($data)) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception) {
            return false;
        }
    }

    public function getComments($publication_id)
    {
        $req = $this->db->prepare('SELECT enabled, user_name, content, created_at, user_id FROM commentary WHERE publication_id = ?');
        $req->execute(array($publication_id));
        return $req;
    }

    public function updateComment($publication_id, $enabled, $user_name, $content)
    {
        $req = $this->db->prepare('UPDATE commentary SET enabled= :enabled, user_name= :user_name, content= :content WHERE publication_id= :publication_id');
        $req->execute(array(
            'enabled' => $enabled,
            'user_name' => $user_name,
            'content' => $content,
            'publication_id' => $publication_id,
        ));
    }
}

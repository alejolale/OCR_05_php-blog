<?php

declare(strict_types=1);

namespace CommentManager;

use Manager\Manager;
use Commentary\Commentary;

require_once('Manager.php');
require_once('Commentary.php');

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

            return isset($data);
        } catch (\Exception) {
            return false;
        }
    }

    public function getDisabledComments($publicationId): array
    {
        $commentaries = [];
        $req = $this->db->prepare('SELECT id, enabled, user_name, content, created_at, user_id, publication_id FROM commentary WHERE publication_id = ? && enabled = 0');
        $req->execute(array($publicationId));
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $data = $req->fetchAll();

        foreach ($data as $commentary) {
            $commentaries[] = new Commentary($commentary);
        }

        return $commentaries;
    }

    public function deleteComment($commentId)
    {
        $req = $this->db->prepare('DELETE FROM commentary WHERE id= :id');
        $req->execute(array(
            'id' => $commentId,
        ));
    }

    public function getComments($publicationId): array
    {
        $commentaries = [];
        $req = $this->db->prepare('SELECT id, enabled, user_name, content, created_at, user_id, publication_id FROM commentary WHERE publication_id = ? && enabled = 1');
        $req->execute(array($publicationId));
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $data = $req->fetchAll();

        foreach ($data as $commentary) {
            $commentaries[] = new Commentary($commentary);
        }

        return $commentaries;
    }

    public function updateComment($publicationId)
    {
        $enabled = 1;
        $req = $this->db->prepare('UPDATE commentary SET enabled= :enabled WHERE id= :publication_id');
        $req->execute(array(
            'enabled' => $enabled,
            'publication_id' => $publicationId,
        ));
    }
}

<?php

class CommentManager extends Manager{

    public function getComments($publication_id) {
        $req= $this->db->prepare('SELECT enabled, user_name, content, created_at, user_id FROM commentary WHERE publication_id = ?');
        $req->execute(array($publication_id));
        return $req;
    }

    public function updateComment($publication_id, $enabled, $user_name, $content) {
        $req= $this->db->prepare('UPDATE commentary SET enabled= :enabled, user_name= :user_name, content= :content WHERE publication_id= :publication_id');
        $req->execute(array(
            'enabled' => $enabled,
            'user_name' => $user_name,
            'content' => $content,
            'publication_id' => $publication_id,
        ));
    }
}
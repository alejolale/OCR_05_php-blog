<?php
require_once('Manager.php');

class PublicationManager extends Manager {

    public function getPublications() {
        $req= $this->db->query('SELECT title, created_at, header, content, user_id FROM publication');
        return $req;
    }

    public function getPublication($id) {
        $req= $this->db->prepare('SELECT title, created_at, header, content, user_id FROM publication WHERE id = ?');
        $req->execute(array($id));
        return $req;
    }

    public function updatePublication($id, $title, $header, $content, $edited_at) {
        $req= $this->db->prepare('UPDATE publication SET title= :title, header= :header, content= :content, edited_at= :edited_at WHERE id= :id');
        $req->execute(array(
            'title' => $title,
            'header' => $header,
            'content' => $content,
            'edited_at' => $edited_at,
            'id' => $id,
        ));
    }
}
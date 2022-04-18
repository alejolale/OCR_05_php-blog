<?php

namespace PublicationManager;

use Manager\Manager;
use Publication\Publication;

require_once('Manager.php');
require_once('Publication.php');

class PublicationManager extends Manager
{
    public function getPublications($limit = null): array
    {
        $publications = [];
        $statement =  is_null($limit) ? 'SELECT p.id, p.title, p.created_at, p.edited_at, p.header, p.content, p.user_id, CONCAT(u.firstname," ",u.lastname) AS fullname FROM publication AS p INNER JOIN user AS u ON u.id = p.user_id 
                ORDER BY p.created_at DESC' : 'SELECT p.id, p.title, p.created_at, p.edited_at, p.header, p.content, p.user_id, CONCAT(u.firstname," ",u.lastname) AS fullname FROM publication AS p INNER JOIN user AS u ON u.id = p.user_id 
                ORDER BY p.created_at DESC LIMIT '.$limit;

        $req = $this->db->query($statement);
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $data = $req->fetchAll();

        /*echo('<pre>');
       print_r($data);
       echo('</pre>');*/

        foreach ($data as $publication) {
            $publications[] = new Publication($publication);
        }
        return $publications;
    }

    public function getPublicationsByUserId($userId): array
    {
        $publications = [];

        $req = $this->db->prepare('SELECT id, title, created_at, header, content, user_id FROM publication WHERE user_id = ? ORDER BY created_at DESC');
        $req->execute(array($userId));
        $req->setFetchMode(\PDO::FETCH_ASSOC);

        $data = $req->fetchAll();

        foreach ($data as $publication) {
            $publications[] = new Publication($publication);
        }

        return $publications;
    }

    public function getPublication($id)
    {
        $publicationId = (int) $id;

        $req = $this->db->prepare('SELECT p.id, p.title, p.created_at, p.edited_at, p.header, p.content, p.user_id, CONCAT(u.firstname," ",u.lastname) AS fullname FROM publication AS p 
            INNER JOIN user AS u ON u.id = p.user_id WHERE p.id = ?');
        $req->execute(array($publicationId));
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $data = $req->fetch();

        if ($data) {
            return new Publication($data);
        } else {
            return false;
        }
    }

    public function createPublication($userId, $title, $header, $content)
    {
        //TODO verify if date now works
        $createdAt = date("Y-m-d H:i:s");

        try {
            $req = $this->db->prepare('INSERT INTO publication (title, header, content, created_at, user_id) VALUES (:title, :header, :content, :created_at, :user_id)');

            $req->execute(array(
                'title' => $title,
                'header' => $header,
                'content' => $content,
                'created_at' => $createdAt,
                'user_id' => $userId,
            ));
            $data = $req->fetch();

            if (isset($data)) {
                return $data;
            }
        } catch (\Exception) {
            return null;
        }
    }

    public function updatePublication($id, $title, $header, $content)
    {
        $edited_at = date("Y-m-d H:i:s");

        $req = $this->db->prepare('UPDATE publication SET title= :title, header= :header, content= :content, edited_at= :edited_at WHERE id= :id');
        $req->execute(array(
            'title' => $title,
            'header' => $header,
            'content' => $content,
            'edited_at' => $edited_at,
            'id' => $id,
        ));
    }

    public function deletePublication($id)
    {
        $req = $this->db->prepare('DELETE FROM publication WHERE id= :id');
        $req->execute(array(
            'id' => $id,
        ));
    }
}
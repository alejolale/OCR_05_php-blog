<?php

namespace UserManager;

use Manager\Manager;
use User\User;

require_once('model/Manager.php');
require_once('model/User.php');


class UserManager extends Manager
{
    public function getUsers(): array
    {
        $users = [];

        $req = $this->db->query('SELECT id, firstname, lastname, email, confirmed FROM user ORDER BY confirmed DESC');
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $data = $req->fetchAll();

        foreach ($data as $user) {
            $users[] = new User($user);
        }

        return $users;
    }

    public function getUser($userId): User
    {
        $userId = (int)$userId;
        $req = $this->db->prepare('SELECT id, firstname, lastname, email, password FROM user WHERE id = ?');
        $req->execute(array($userId));
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $data = $req->fetch();

        return new User($data);
    }

    public function login($email): ?User
    {
        $req = $this->db->prepare('SELECT * FROM user WHERE email = :email');
        $req->execute(array(
            'email' => $email
        ));
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $data = $req->fetchAll();

        if ($data) {
            return new User($data[0]);
        }
        return null;
    }

    public function createUser($firstname, $lastname, $email, $password): ?User
    {
        try {
            $userType = 'user';
            $confirmed = 0;
            $req = $this->db->prepare('INSERT INTO user (firstname, lastname, email, password, type, confirmed) VALUES (:firstname, :lastname, :email, :password, :type, :confirmed )');
            $req->execute(array(
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'password' => $password,
                'type' => $userType,
                'confirmed' => $confirmed
            ));
            $data = $req->fetch();
            if (isset($data)) {
                return $this->login($email);
            }
            return null;
        } catch (\Exception) {
            return null;
        }
    }

    public function updateUser($id, $firstname, $lastname)
    {
        $req = $this->db->prepare('UPDATE user SET firstname= :firstname, lastname= :lastname WHERE id= :id');
        $req->execute(array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'id' => $id,
        ));
    }

    public function userValidation($id)
    {
        $req = $this->db->prepare('UPDATE user SET confirmed= :confirmed WHERE id= :id');
        $req->execute(array(
            'confirmed' => 1,
            'id' => $id,
        ));
    }

    public function updatePassword($id, $password)
    {
        $req = $this->db->prepare('UPDATE user SET password= :password WHERE id= :id');
        $req->execute(array(
            'password' => $password,
            'id' => $id
        ));
    }

    public function deleteUser($id)
    {
        $req = $this->db->prepare('DELETE FROM user WHERE id= :id');
        $req->execute(array(
            'id' => $id
        ));
    }
}

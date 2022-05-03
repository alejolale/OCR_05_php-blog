<?php

declare(strict_types=1);

namespace UserManager;

use Manager\Manager;
use User\User;

require_once('model/Manager.php');
require_once('model/User.php');


class UserManager extends Manager
{
    //TODO remove
    //print("<pre>".print_r($users,true)."</pre>");

    public function getUsers()
    {
        $users = [];

        $req = $this->db->query('SELECT id, firstname, lastname, email FROM user');

        while ($data = $req->fetch()) {
            $users[] = new User($data);
        }

        return $users;
    }

    public function getUser($userId): User
    {
        $userId = (int)$userId;
        $req = $this->db->prepare('SELECT id, firstname, lastname, email FROM user WHERE id = ?');
        $req->execute(array($userId));
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $data = $req->fetch();

        return new User($data);
    }

    public function login($email, $password)
    {
        $req = $this->db->prepare('SELECT * FROM user WHERE email = :email AND password = :password');
        $req->execute(array(
            'email' => $email,
            'password' => $password
        ));
        $result = $req->setFetchMode(\PDO::FETCH_ASSOC);
        $data = $req->fetchAll( );

        /*echo('<pre>');
        print_r($data);
        echo('</pre>');*/

        if ($data) {
            $user = new User($data[0]);

            /*echo('test');

            echo('<pre>');
            var_dump($user);
            echo('</pre>');*/

            return $user;
        }

        //var_dump(isset($data['id']));
        //print("<pre>".print_r($data,true)."</pre>");


        //return null;
    }

    public function createUser($firstname, $lastname, $email, $password)
    {
        try {
            $req = $this->db->prepare('INSERT INTO user (firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password )');
            $req->execute(array(
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'password' => $password,
            ));
            $data = $req->fetch();
            if (isset($data)) {
                return $this->login($email, $password);
            }
            return null;
        } catch (\Exception) {
            return null;
        }
    }

    public function updateUser($id, $firstname, $lastname, $email)
    {
        $req = $this->db->prepare('UPDATE user SET firstname= :firstname, lastname= :lastname, email= :email WHERE id= :id');
        $req->execute(array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'id' => $id,
        ));
    }

    public function deleteUser($id)
    {
        $req = $this->db->prepare('DELETE FROM user WHERE id= :id');
        $req->execute(array(
            'id' => $id
        ));
    }

    public function updatePassword($id, $newPassword)
    {
        $req = $this->db->prepare('UPDATE user SET password= :newPassword WHERE id= :id');
        $req->execute(array(
            'password' => $newPassword,
            'id' => $id
        ));
    }

    public function verifyEmail($email)
    {
        $req = $this->db->prepare('SELECT email FROM user WHERE email= :email');
        $req->execute(array(
            'email' => $email
        ));
    }

}
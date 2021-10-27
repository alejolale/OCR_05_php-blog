<?php
require_once('model/Manager.php');
require_once('model/User.php');

class UserManager extends Manager {

    //TODO remove
    //print("<pre>".print_r($users,true)."</pre>");

    public function getUsers(){
        $users = [];

        $req = $this->db->query('SELECT id, firstname, lastname, email FROM user');

        while ($data = $req->fetch())
        {
            $users[] = new User($data);
        }

        return $users;
    }

    public function getUser($id) {
        $id = (int) $id;

        $req = $this->db->prepare('SELECT id, firstname, lastname, email FROM user WHERE id = ?');
        $req->execute(array($id));
        $data = $req->fetch();

        $user= new User($data);

        return $user;
    }

    public function login($email, $password) {
        $req = $this->db->prepare('SELECT id, email, password FROM user WHERE email = :email AND password = :password');
        $req->execute(array(
            'email' => $email,
            'password' => $password
        ));
    }

    public function createUser($firstname, $lastname, $email, $password) {
        $req = $this->db->prepare('INSERT INTO user (id, firstname, lastname, email, password) VALUES (NULL, :firstname, :lastname, :email, :password )');
        $req->execute(array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'password' => $password,
        ));
    }

    public function updateUser($id, $firstname, $lastname, $email) {
        $req = $this->db->prepare('UPDATE user SET firstname= :firstname, lastname= :lastname, email= :email WHERE id= :id');
        $req->execute(array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'id' => $id,
        ));
    }

    public function deleteUser($id) {
        $req = $this->db->prepare ('DELETE FROM user WHERE id= :id');
        $req->execute(array(
            'id' => $id
        ));
    }

    public function updatePassword($id, $newPassword) {
        $req = $this->db->prepare('UPDATE user SET password= :newPassword WHERE id= :id');
        $req->execute(array(
            'password' => $newPassword
        ));
    }

    public function verifyEmail($email) {
        $req = $this->db->prepare('SELECT email FROM user WHERE email= :email');
        $req->execute(array(
            'email' => $email
        ));
    }

}
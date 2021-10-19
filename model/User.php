<?php

/**
 * Class User
 */
class User {
    /**
     * @var number used to identify user
     */
    private $_id;
    private $_firstname;
    private $_lastname;
    private $_email;
    private $_password;
    private $_avatar;
    private $_type;
    private $_confirmed;
    private $_enabled;

    public function __construct(array $data = array()) {
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }

    public function hydrate(array $data)
    {
        foreach ($data as $key => $value)
        {
            $method = 'set'.ucfirst($key);

            if (method_exists($this, $method))
            {
                // call setter
                $this->$method($value);
            }
        }

    }

    public function id() {
        return $this->_id;
    }

    public function firstname() {
        return $this->_firstname;
    }
    public function lastname() {
        return $this->_lastname;
    }

    public function email() {
        return $this->_email;
    }

    public function password() {
        return $this->_password;
    }

    public function avatar() {
        return $this->_avatar;
    }

    public function type() {
        return $this->_type;
    }

    public function confirmed() {
        return $this->_confirmed;
    }

    public function enabled() {
        return $this->_enabled;
    }

    public function setId($id) {
        if (is_string($id)) {
            $this->_id = $id;
        }
    }

    public function setFirstname($firstname) {
        if (is_string($firstname)) {
            $this->_firstname = $firstname;
        }
    }

    public function setLastname($lastname) {
        if (is_string($lastname)) {
            $this->_lastname = $lastname;
        }
    }

    public function setEmail($email) {
        if (is_string($email)) {
            $this->_email = $email;
        }
    }

    public function setPassword($password) {
        if (is_string($password)) {
            $this->_password = $password;
        }
    }

    public function setAvatar($avatar) {
        if (is_string($avatar)) {
            $this->_avatar = $avatar;
        }
    }

    public function setType($type) {
        if (is_int($type)) {
            $this->_type = $type;
        }
    }

    public function setEnabled($enabled) {
        if (is_int($enabled)) {
            $this->_enabled = $enabled;
        }
    }
}
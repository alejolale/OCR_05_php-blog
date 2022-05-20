<?php

declare(strict_types=1);

namespace User;

/**
 * Class User
 */
class User
{
    private int $_id;
    private string $_firstname;
    private string $_lastname;
    private string $_email;
    private string $_password;
    private string $_avatar;
    private string $_type;
    private int $_confirmed;
    private int $_enabled;

    public function __construct(array $data = array())
    {
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }

    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);

            /*echo ('method :' . $method . $key . $value);
            echo('</br>');*/

            if (method_exists($this, $method)) {
                // call setter
                $this->$method($value);
            }
        }
    }

    public function id()
    {
        return $this->_id;
    }

    public function firstname()
    {
        return $this->_firstname;
    }
    public function lastname()
    {
        return $this->_lastname;
    }

    public function email()
    {
        return $this->_email;
    }

    public function password()
    {
        return $this->_password;
    }

    public function avatar()
    {
        return $this->_avatar;
    }

    public function type()
    {
        return $this->_type;
    }

    public function confirmed()
    {
        return $this->_confirmed;
    }

    public function enabled()
    {
        return $this->_enabled;
    }

    public function setId($id)
    {
        if ($id) {
            $this->_id = $id;
        }
    }

    public function setFirstname($firstname)
    {
        if (is_string($firstname)) {
            $this->_firstname = $firstname;
        }
    }

    public function setLastname($lastname)
    {
        if (is_string($lastname)) {
            $this->_lastname = $lastname;
        }
    }

    public function setEmail($email)
    {
        if (is_string($email)) {
            $this->_email = $email;
        }
    }

    public function setPassword($password)
    {
        if (is_string($password)) {
            $this->_password = $password;
        }
    }

    public function setAvatar($avatar)
    {
        if (is_string($avatar)) {
            $this->_avatar = $avatar;
        }
    }

    public function setType($type)
    {
        if (is_string($type)) {
            $this->_type = $type;
        }
    }

    public function setConfirmed($confirmed)
    {
        if (is_int($confirmed)) {
            $this->_confirmed = $confirmed;
        }
    }

    public function setEnabled($enabled)
    {
        if (is_int($enabled)) {
            $this->_enabled = $enabled;
        }
    }
}
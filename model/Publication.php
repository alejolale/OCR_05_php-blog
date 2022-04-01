<?php

declare(strict_types=1);

namespace Publication;

class Publication
{
    private int $_id;
    private string $_title;
    private string $_created_at;
    private ?string $_edited_at;
    private string $_header;
    private string $_content;
    private int $_user_id;
    private string $_fullname;

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

            /*echo ('method :' . $method . " -----" . $key . "  -----" . $value);

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

    public function title()
    {
        return $this->_title;
    }

    public function createdAt()
    {
        return $this->_created_at;
    }

    public function editedAt()
    {
        return $this->_edited_at;
    }

    public function header()
    {
        return $this->_header;
    }

    public function content()
    {
        return $this->_content;
    }

    public function userId()
    {
        return $this->_user_id;
    }

    public function fullname()
    {
        return $this->_fullname;
    }

    public function setId($id)
    {
        if ($id) {
            $this->_id = $id;
        }
    }

    public function setTitle(string $title)
    {
        if ($title) {
            $this->_title = $title;
        }
    }

    public function setCreated_at(string $createdAt)
    {
        if ($createdAt) {
            $this->_created_at = $createdAt;
        }
    }


    public function setEdited_at(?string $editedAt)
    {
        if ($editedAt) {
            $this->_edited_at = $editedAt;
        } else {
            $this->_edited_at = null;
        }
    }

    public function setHeader(string $header)
    {
        if ($header) {
            $this->_header = $header;
        }
    }

    public function setContent(string $content)
    {
        if ($content) {
            $this->_content = $content;
        }
    }

    public function setUser_id(int $userId)
    {
        if ($userId) {
            $this->_user_id = $userId;
        }
    }

    public function setFullname(string $fullname): void
    {
        if ($fullname) {
            $this->_fullname = $fullname;
        }
    }
}
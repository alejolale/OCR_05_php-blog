<?php

namespace Commentary;

class Commentary
{
    private int $_id;
    private int $_enabled;
    private string $_user_name;
    private string $_content;
    private string $_created_at;
    private int $_publication_id;
    private ?int $_user_id;

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

            if (method_exists($this, $method)) {
                // call setter
                $this->$method($value);
            }
        }
    }

    public function id(): int
    {
        return $this->_id;
    }

    public function enabled(): int
    {
        return $this->_enabled;
    }

    public function userName(): string
    {
        return $this->_user_name;
    }

    public function content(): string
    {
        return $this->_content;
    }

    public function createdAt(): string
    {
        return $this->_created_at;
    }

    public function publicationId(): int
    {
        return $this->_publication_id;
    }

    public function userId(): ?int
    {
        return $this->_user_id;
    }

    public function setId($id)
    {
        if ($id) {
            $this->_id = $id;
        }
    }

    public function setEnabled($enabled)
    {
        if ($enabled) {
            $this->_enabled = $enabled;
        }
    }

    public function setUser_name($userName)
    {
        if ($userName) {
            $this->_user_name = $userName;
        }
    }

    public function setContent($content)
    {
        if ($content) {
            $this->_content = $content;
        }
    }

    public function setCreated_at($createdAt)
    {
        if ($createdAt) {
            $this->_created_at = $createdAt;
        }
    }

    public function setPublication_id($publicationId)
    {
        if ($publicationId) {
            $this->_publication_id = $publicationId;
        }
    }

    public function setUser_id(?string $userId)
    {
        $this->_user_id = $userId ? $userId : null;
    }
}

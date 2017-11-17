<?php

namespace Blog\Domain;

class User
{
    private $user_id;
    private $firstname;
    private $surname;
    private $email;
    
    public function getId()
    {
        return $this->user_id;
    }
    
    public function getFirstname()
    {
        return $this->firstname;
    }
    
    public function getSurname()
    {
        return $this->surname;
    }

    public function getFullName()  
    {
        return $this->firstname . ' ' . $this->surname;
    }
    
    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
}

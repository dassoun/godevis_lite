<?php

namespace GoDevis\Domain;

use Symfony\Component\Security\Core\User\UserInterface;

class Utilisateur implements UserInterface
{
    /*
     * User Id
     * @var integer
     */
    private $id;
    /*
     * User Login
     * @var string
     */
    private $login;
    /*
     * User Password
     * @var string
     */
    private $password;
    /*
     * Salt that was originally used to encode the password
     * @var string
     */
    private $salt;
    /*
     * User Email
     * @var string
     */
    private $email;
    /*
     * Role.
     * Values : ROLE_USER or ROLE_ADMIN.
     * @var string
     */
    private $role;
    
    public function getId() {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getUserName() {
        return $this->login;
    }
    /**
     * @inheritDoc
     */
    public function getPassword() {
        return $this->password;
    }
    /**
     * @inheritDoc
     */
    public function getSalt() {
        return $this->salt;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getRole() {
        return $this->role;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setUserName($login) {
        $this->login = $login;
        return $this;
    }

    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    public function setSalt($salt) {
        $this->salt = $salt;
        return $this;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function setRole($role) {
        $this->role = $role;
        return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array($this->getRole());
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials() {
        // Nothing to do here
    }
}
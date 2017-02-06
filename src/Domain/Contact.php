<?php

namespace godevis\Domain;

class Contact
{
    /*
     * Contact Id
     * @var integer
     */
    private $id;
    
    /*
     * Contact Last Name
     * @var string
     */
    private $nom;
    
    /*
     * Contact First Name
     * @var string
     */
    private $prenom;
    
    /*
     * Contact First Name
     * @var godevis\Domain\Client
     */
    private $client;
    
    public function getId() {
        return $this->id;
    }
    
    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }
    
    public function getClient() {
        return $this->client;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setNom($nom) {
        $this->nom = $nom;
        return $this;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
        return $this;
    }

    public function setClient($client) {
        $this->client = $client;
        return $this;
    }


}
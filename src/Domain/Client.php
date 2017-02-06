<?php

namespace godevis\Domain;

class Client
{
    /*
     * Customer Id
     * @var integer
     */
    private $id;
    
    /*
     * Customer Name
     * @var string
     */
    private $raisonSociale;
    
    /*
     * Customer Address 1
     * @var string
     */
    private $adresse1;
    
    /*
     * Customer Address 2
     * @var string
     */
    private $adresse2;
    
    /*
     * Customer Address 3
     * @var string
     */
    private $adresse3;
    
    /*
     * Customer Zip code
     * @var string
     */
    private $codePostal;
    
    /*
     * Customer City
     * @var string
     */
    private $ville;
    
    /*
     * Customer Phone
     * @var string
     */
    private $telephone;
    
    /*
     * Customer Fax
     * @var string
     */
    private $fax;
    
    public function getId() {
        return $this->id;
    }

    public function getRaisonSociale() {
        return $this->raisonSociale;
    }

    public function getAdresse1() {
        return $this->adresse1;
    }

    public function getAdresse2() {
        return $this->adresse2;
    }

    public function getAdresse3() {
        return $this->adresse3;
    }

    public function getCodePostal() {
        return $this->codePostal;
    }

    public function getVille() {
        return $this->ville;
    }

    public function getTelephone() {
        return $this->telephone;
    }

    public function getFax() {
        return $this->fax;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setRaisonSociale($raisonSociale) {
        $this->raisonSociale = $raisonSociale;
        return $this;
    }

    public function setAdresse1($adresse1) {
        $this->adresse1 = $adresse1;
        return $this;
    }

    public function setAdresse2($adresse2) {
        $this->adresse2 = $adresse2;
        return $this;
    }

    public function setAdresse3($adresse3) {
        $this->adresse3 = $adresse3;
        return $this;
    }

    public function setCodePostal($codePostal) {
        $this->codePostal = $codePostal;
        return $this;
    }

    public function setVille($ville) {
        $this->ville = $ville;
        return $this;
    }

    public function setTelephone($telephone) {
        $this->telephone = $telephone;
        return $this;
    }

    public function setFax($fax) {
        $this->fax = $fax;
        return $this;
    }


}
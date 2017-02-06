<?php

namespace GoDevis\DAO;

use GoDevis\Domain\Client;

class ClientDAO extends DAO
{
    /**
     * Return a list of all customers, sorted by raison_sociale (most recent first).
     *
     * @return array A list of all customers.
     */
    public function findAll() {
        $sql = "select * from go_client order by raison_sociale asc";
        $result = $this->getDb()->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $clients = array();
        foreach ($result as $row) {
            $clientId = $row['id'];
            $clients[$clientId] = $this->buildDomainObject($row);
        }
        return $clients;
    }

    /**
     * Creates a Customer object based on a DB row.
     *
     * @param array $row The DB row containing Client data.
     * @return \GoDevis\Domain\Client
     */
    protected function buildDomainObject(array $row) {
        $client = new Client();
        $client->setId($row['id']);
        $client->setRaisonSociale($row['raison_sociale']);
        $client->setAdresse1($row['adresse1']);
        $client->setAdresse2($row['adresse2']);
        $client->setAdresse3($row['adresse3']);
        $client->setCodePostal($row['code_postal']);
        $client->setVille($row['ville']);
        $client->setTelephone($row['telephone']);
        $client->setFax($row['fax']);
        
        return $client;
    }
    
    /**
     * Returns an customer matching the supplied id.
     *
     * @param integer $go_client_id
     *
     * @return \GoDevis\Domain\Client|throws an exception if no matching customer is found
     */
    public function find($id) {
        $sql = "select * from go_client where id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No customer matching id " . $id);
    }
    
    /**
     * Saves a customer into the database.
     *
     * @param \GoDevis\Domain\Client $client The customer to save
     */
    public function save(Client $client) {
        $clientData = array(
            'raison_sociale' => $client->getRaisonSociale(),
            'adresse1' => $client->getAdresse1(),
            'adresse2' => $client->getAdresse2(),
            'adresse3' => $client->getAdresse3(),
            'code_postal' => $client->getCodePostal(),
            'ville' => $client->getVille(),
            'telephone' => $client->getTelephone(),
            'fax' => $client->getFax()
        );

        if ($client->getId()) {
            // The customer has already been saved : update it
            $this->getDb()->update('go_client', $clientData, array('id' => $client->getId()));
        } else {
            // The customer has never been saved : insert it
            $this->getDb()->insert('go_client', $clientData);
            // Get the id of the newly created customer and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $client->setId($id);
        }
    }

    /**
     * Removes an customer from the database.
     *
     * @param integer $id The customer id.
     */
    public function delete($id) {
        // Delete the article
        $this->getDb()->delete('go_client', array('id' => $id));
    }
}
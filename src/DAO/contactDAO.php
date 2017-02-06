<?php

namespace GoDevis\DAO;

use GoDevis\Domain\Contact;

class ContactDAO extends DAO 
{
    /**
     * @var \GoDevis\DAO\ClientDAO
     */
    private $clientDAO;

    public function setClientDAO(ClientDAO $clientDAO) {
        $this->clientDAO = $clientDAO;
    }
    
    /**
     * Return a list of all contacts, sorted by nom, prenom.
     *
     * @return array A list of all contacts.
     */
    public function findAll() {
        $sql = "select * from go_contact order by nom, prenom asc";
        $result = $this->getDb()->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $contacts = array();
        foreach ($result as $row) {
            $contactId = $row['id'];
            $contacts[$contactId] = $this->buildDomainObject($row);
        }
        return $contacts;
    }

    /**
     * Return a list of all conatcts for a customer, sorted by last name asc, first name asc.
     *
     * @param integer $go_client_Id The customer id.
     *
     * @return array A list of all contacts for the customer.
     */
    public function findAllByClient($client_id) {
        // The associated customer is retrieved only once
        $client = $this->clientDAO->find($client_id);

        // go_client_id is not selected by the SQL query
        // The customer won't be retrieved during domain objet construction
        $sql = "select id, nom, prenom from go_contact where go_client_id=? order by nom asc, prenom asc";
        $result = $this->getDb()->fetchAll($sql, array($client_id));

        // Convert query result to an array of domain objects
        $contacts = array();
        foreach ($result as $row) {
            $id = $row['id'];
            $contact = $this->buildDomainObject($row);
            // The associated customer is defined for the constructed comment
            $contact->setClient($client);
            $contacts[$id] = $contact;
        }
        return $contacts;
    }

    /**
     * Creates a contact object based on a DB row.
     *
     * @param array $row The DB row containing Contact data.
     * @return \GoDevis\Domain\Contact
     */
    protected function buildDomainObject(array $row) {
        $contact = new Contact();
        $contact->setId($row['id']);
        $contact->setNom($row['nom']);
        $contact->setPrenom($row['prenom']);

        if (array_key_exists('go_client_id', $row)) {
            // Find and set the associated customer
            $client_id = $row['go_client_id'];
            $client = $this->clientDAO->find($client_id);
            $contact->setClient($client);
        }
        
        return $contact;
    }
    
    /**
     * Saves a contact into the database.
     *
     * @param \GoDevis\Domain\Contact $contact The contact to save
     */
    public function save(Contact $contact) {
        $contactData = array(
            'nom' => $contact->getNom(),
            'prenom' => $contact->getPrenom(),
            'go_client_id' => $contact->getClient()->getId()
        );

        if ($contact->getId()) {
            // The contact has already been saved : update it
            $this->getDb()->update('go_contact', $contactData, array('id' => $contact->getId()));
        } else {
            // The contact has never been saved : insert it
            $this->getDb()->insert('go_contact', $contactData);
            // Get the id of the newly created contact and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $contact->setId($id);
        }
    }
    
    /**
     * Removes all comtacts for an customer
     *
     * @param $customerId The id of the customer
     */
    public function deleteAllByClient($customerId) {
        $this->getDb()->delete('go_contact', array('go_client_id' => $customerId));
    }

    /**
     * Removes a contact from the database.
     *
     * @param integer $id The contact id.
     */
    public function delete($id) {
        // Delete the contact
        $this->getDb()->delete('go_contact', array('id' => $id));
    }
    
    /**
     * Returns a contact matching the supplied id.
     *
     * @param integer $id
     *
     * @return \GoDevis\Domain\Contact|throws an exception if no matching contact is found
     */
    public function find($id) {
        $sql = "select * from go_contact where id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No contact matching id " . $id);
    }
}
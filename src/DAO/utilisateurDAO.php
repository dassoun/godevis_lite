<?php

namespace GoDevis\DAO;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use GoDevis\Domain\Utilisateur;

class UtilisateurDAO extends DAO implements UserProviderInterface
{
    /**
     * Return a list of all users, sorted by Login.
     *
     * @return array A list of all users.
     */
    public function findAll() {
        $sql = "select * from go_utilisateur order by login asc";
        $result = $this->getDb()->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $users = array();
        foreach ($result as $row) {
            $userId = $row['id'];
            $users[$userId] = $this->buildDomainObject($row);
        }
        return $users;
    }
    
    /**
     * Returns a user matching the supplied id.
     *
     * @param integer $id The user id.
     *
     * @return \GoDevis\Domain\Utilisateur|throws an exception if no matching user is found
     */
    public function find($id) {
        $sql = "select * from go_utilisateur where id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No user matching id " . $id);
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($username)
    {
        $sql = "select * from go_utilisateur where login=?";
        $row = $this->getDb()->fetchAssoc($sql, array($username));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new UsernameNotFoundException(sprintf('User "%s" not found.', $username));
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }
        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return 'GoDevis\Domain\Utilisateur' === $class;
    }

    /**
     * Creates a User object based on a DB row.
     *
     * @param array $row The DB row containing User data.
     * @return \GoDevis\Domain\Utilisateur
     */
    protected function buildDomainObject(array $row) {
        $user = new Utilisateur();
        $user->setId($row['id']);
        $user->setUserName($row['login']);
        $user->setPassword($row['password']);
        $user->setSalt($row['salt']);
        $user->setEmail($row['email']);
        $user->setRole($row['role']);
        return $user;
    }
    
    /**
     * Saves a user into the database.
     *
     * @param \GoDevis\Domain\Utilisateur $utilisateur The user to save
     */
    public function save(Utilisateur $utilisateur) {
        $utilisateurData = array(
            'login' => $utilisateur->getUserName(),
            'password' => $utilisateur->getPassword(),
            'salt' => $utilisateur->getSalt(),
            'email' => $utilisateur->getEmail(),
            'role' => $utilisateur->getRole()
        );

        if ($utilisateur->getId()) {
            // The user has already been saved : update it
            $this->getDb()->update('go_utilisateur', $utilisateurData, array('id' => $utilisateur->getId()));
        } else {
            // The user has never been saved : insert it
            $this->getDb()->insert('go_utilisateur', $utilisateurData);
            // Get the id of the newly created user and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $utilisateur->setId($id);
        }
    }

    /**
     * Removes a user from the database.
     *
     * @param integer $id The user id.
     */
    public function delete($id) {
        // Delete the user
        $this->getDb()->delete('go_utilisateur', array('id' => $id));
    }
}
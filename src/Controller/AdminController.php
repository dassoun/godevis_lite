<?php

namespace GoDevis\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use GoDevis\Domain\Client;
use GoDevis\Domain\Utilisateur;
use GoDevis\Form\Type\ClientType;
use GoDevis\Form\Type\ContactType;
use GoDevis\Form\Type\UtilisateurType;

class AdminController {

    /**
     * Admin home page controller.
     *
     * @param Application $app Silex application
     */
    public function indexAction(Application $app) {
        $clients = $app['dao.client']->findAll();
        $contacts = $app['dao.contact']->findAll();
        $users = $app['dao.utilisateur']->findAll();
        return $app['twig']->render('admin.html.twig', array(
            'clients' => $clients,
            'contacts' => $contacts,
            'users' => $users));
    }

    /**
     * Add client controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function addClientAction(Request $request, Application $app) {
        $client = new Client();
        $clientForm = $app['form.factory']->create(ClientType::class, $client);
        $clientForm->handleRequest($request);
        if ($clientForm->isSubmitted() && $clientForm->isValid()) {
            $app['dao.client']->save($client);
            $app['session']->getFlashBag()->add('success', 'The customer was successfully created.');
        }
        return $app['twig']->render('client_form.html.twig', array(
            'title' => 'New customer',
            'clientForm' => $clientForm->createView()));
    }

    /**
     * Edit customer controller.
     *
     * @param integer $id Customer id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function editClientAction($id, Request $request, Application $app) {
        $client = $app['dao.client']->find($id);
        $clientForm = $app['form.factory']->create(ClientType::class, $client);
        $clientForm->handleRequest($request);
        if ($clientForm->isSubmitted() && $clientForm->isValid()) {
            $app['dao.client']->save($client);
            $app['session']->getFlashBag()->add('success', 'The customer was successfully updated.');
        }
        return $app['twig']->render('client_form.html.twig', array(
            'title' => 'Edit customer',
            'clientForm' => $clientForm->createView()));
    }

    /**
     * Delete customer controller.
     *
     * @param integer $id Customer id
     * @param Application $app Silex application
     */
    public function deleteClientAction($id, Application $app) {
        // Delete all associated contacts
        $app['dao.contacts']->deleteAllByClient($id);
        // Delete the article
        $app['dao.client']->delete($id);
        $app['session']->getFlashBag()->add('success', 'The client was successfully removed.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
    }

    /**
     * Edit contact controller.
     *
     * @param integer $id Contact id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function editContactAction($id, Request $request, Application $app) {
        $contact = $app['dao.contact']->find($id);
        $contactForm = $app['form.factory']->create(ContactType::class, $contact);
        $contactForm->handleRequest($request);
        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $app['dao.contact']->save($contact);
            $app['session']->getFlashBag()->add('success', 'The contact was successfully updated.');
        }
        return $app['twig']->render('contact_form.html.twig', array(
            'title' => 'Edit contact',
            'contactForm' => $contactForm->createView()));
    }

    /**
     * Delete contact controller.
     *
     * @param integer $id Contact id
     * @param Application $app Silex application
     */
    public function deleteContactAction($id, Application $app) {
        $app['dao.contact']->delete($id);
        $app['session']->getFlashBag()->add('success', 'The contact was successfully removed.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
    }

    /**
     * Add user controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function addUserAction(Request $request, Application $app) {
        $user = new Utilisateur();
        $userForm = $app['form.factory']->create(UtilisateurType::class, $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            // generate a random salt value
            $salt = substr(md5(time()), 0, 23);
            $user->setSalt($salt);
            $plainPassword = $user->getPassword();
            // find the default encoder
            $encoder = $app['security.encoder.bcrypt'];
            // compute the encoded password
            $password = $encoder->encodePassword($plainPassword, $user->getSalt());
            $user->setPassword($password); 
            $app['dao.utilisateur']->save($user);
            $app['session']->getFlashBag()->add('success', 'The user was successfully created.');
        }
        return $app['twig']->render('utilisateur_form.html.twig', array(
            'title' => 'New user',
            'utilisateurForm' => $userForm->createView()));
    }

    /**
     * Edit user controller.
     *
     * @param integer $id User id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function editUserAction($id, Request $request, Application $app) {
        $user = $app['dao.utilisateur']->find($id);
        $userForm = $app['form.factory']->create(UtilisateurType::class, $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $plainPassword = $user->getPassword();
            // find the encoder for the user
            $encoder = $app['security.encoder_factory']->getEncoder($user);
            // compute the encoded password
            $password = $encoder->encodePassword($plainPassword, $user->getSalt());
            $user->setPassword($password); 
            $app['dao.utilisateur']->save($user);
            $app['session']->getFlashBag()->add('success', 'The user was successfully updated.');
        }
        return $app['twig']->render('utilisateur_form.html.twig', array(
            'title' => 'Edit user',
            'utilisateurForm' => $userForm->createView()));
    }

    /**
     * Delete user controller.
     *
     * @param integer $id User id
     * @param Application $app Silex application
     */
    public function deleteUserAction($id, Application $app) {
        // Delete the user
        $app['dao.utilisateur']->delete($id);
        $app['session']->getFlashBag()->add('success', 'The user was successfully removed.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
    }
}

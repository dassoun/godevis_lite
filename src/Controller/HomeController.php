<?php

namespace GoDevis\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use GoDevis\Domain\Contact;
use GoDevis\Form\Type\ContactType;

class HomeController {

    /**
     * Home page controller.
     *
     * @param Application $app Silex application
     */
    public function indexAction(Application $app) {
        $clients = $app['dao.client']->findAll();
        return $app['twig']->render('index.html.twig', array('clients' => $clients));
    }
    
    /**
     * Customer details controller.
     *
     * @param integer $id Customer id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function clientAction($id, Request $request, Application $app) {
        $client = $app['dao.client']->find($id);
        $contactFormView = null;
        if ($app['security.authorization_checker']->isGranted('IS_AUTHENTICATED_FULLY')) {
            // A user is fully authenticated : he can add contacts
            $contact = new Contact();
            $contact->setClient($client);
            $contactForm = $app['form.factory']->create(ContactType::class, $contact);
            $contactForm->handleRequest($request);
            if ($contactForm->isSubmitted() && $contactForm->isValid()) {
                $app['dao.contact']->save($contact);
                $app['session']->getFlashBag()->add('success', 'The contact was successfully added.');
            }
            $contactFormView = $contactForm->createView();
        }
        $contacts = $app['dao.contact']->findAllByClient($id);
        
        return $app['twig']->render('contact.html.twig', array(
            'client' => $client,
            'contacts' => $contacts,
            'contactForm' => $contactFormView));
    }
    
    /**
     * User login controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function loginAction(Request $request, Application $app) {
        return $app['twig']->render('login.html.twig', array(
            'error'         => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
        ));
    }
}

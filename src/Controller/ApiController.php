<?php

namespace GoDevis\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use GoDevis\Domain\Client;


class ApiController {

    /**
     * API customer controller.
     *
     * @param Application $app Silex application
     *
     * @return All articles in JSON format
     */
    public function getClientsAction(Application $app) {
        $clients = $app['dao.client']->findAll();
        // Convert an array of objects ($clients) into an array of associative arrays ($responseData)
        $responseData = array();
        foreach ($clients as $client) {
            $responseData[] = $this->buildClientArray($client);
        }
        // Create and return a JSON response
        return $app->json($responseData);
    }
    
    /**
     * API customer details controller.
     *
     * @param integer $id Customer id
     * @param Application $app Silex application
     *
     * @return Article details in JSON format
     */
    public function getClientAction($id, Application $app) {
        $client = $app['dao.client']->find($id);
        $responseData = $this->buildClientArray($client);
        // Create and return a JSON response
        return $app->json($responseData);
    }

    /**
     * API create customer controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     *
     * @return Article details in JSON format
     */
    public function addClientAction(Request $request, Application $app) {
        // Check request parameters
        if (!$request->request->has('raisonSociale')) {
            return $app->json('Missing required parameter: raisonSociale', 400);
        }
        // Build and save the new customer
        $client = new Client();
        $client->setRaisonSociale($request->request->get('raisonSociale'));
        $client->setAdresse1($request->request->get('adresse1'));
        $client->setAdresse2($request->request->get('adresse2'));
        $client->setAdresse3($request->request->get('adresse2'));
        $client->setCodePostal($request->request->get('codePostal'));
        $client->setVille($request->request->get('ville'));
        $client->setTelephone($request->request->get('telephone'));
        $client->setFax($request->request->get('fax'));
        $app['dao.client']->save($client);
        $responseData = $this->buildClientArray($client);
        return $app->json($responseData, 201);  // 201 = Created
    }

    /**
     * API delete customer controller.
     *
     * @param integer $id Customer id
     * @param Application $app Silex application
     */
    public function deleteCustomerAction($id, Application $app) {
        // Delete all associated contacts
        $app['dao.contact']->deleteAllByClient($id);
        // Delete the customer
        $app['dao.client']->delete($id);
        return $app->json('No Content', 204);  // 204 = No content
    }

    /**
     * Converts a Customer object into an associative array for JSON encoding
     *
     * @param Customer $client Client object
     *
     * @return array Associative array whose fields are the client properties.
     */
    private function buildClientArray(Client $client) {
        $data  = array(
            'id' => $client->getId(),
            'raisonSociale' => $client->getRaisonSociale(),
            'adresse1' => $client->getAdresse1(),
            'adresse2' => $client->getAdresse2(),
            'adresse3' => $client->getadresse3(),
            'codePostal' => $client->getCodePostal(),
            'ville' => $client->getVille(),
            'telephone' => $client->getTelephone(),
            'fax' => $client->getFax()
        );
        return $data;
    }
}

<?php 

// Home page
$app->get('/', "GoDevis\Controller\HomeController::indexAction")
->bind('home');

// Detailed info about a customer
$app->match('/client/{id}', "GoDevis\Controller\HomeController::clientAction")
->bind('client');

// Login form
$app->get('/login', "GoDevis\Controller\HomeController::loginAction")
->bind('login');

// Admin zone
$app->get('/admin', "GoDevis\Controller\AdminController::indexAction")
->bind('admin');

// Add a new customer
$app->match('/admin/client/add', "GoDevis\Controller\AdminController::addClientAction")
->bind('admin_client_add');

// Edit an existing customer
$app->match('/admin/client/{id}/edit', "GoDevis\Controller\AdminController::editClientAction")
->bind('admin_client_edit');

// Remove a customer
$app->get('/admin/client/{id}/delete', "GoDevis\Controller\AdminController::deleteClientAction")
->bind('admin_client_delete');

// Edit an existing contact
$app->match('/admin/contact/{id}/edit', "GoDevis\Controller\AdminController::editContactAction")
->bind('admin_contact_edit');

// Remove a contact
$app->get('/admin/contact/{id}/delete', "GoDevis\Controller\AdminController::deleteContactAction")
->bind('admin_contact_delete');

// Add a user
$app->match('/admin/user/add', "GoDevis\Controller\AdminController::addUserAction")
->bind('admin_user_add');

// Edit an existing user
$app->match('/admin/user/{id}/edit', "GoDevis\Controller\AdminController::editUserAction")
->bind('admin_user_edit');

// Remove a user
$app->get('/admin/user/{id}/delete', "MicroCMS\Controller\AdminController::deleteUserAction")
->bind('admin_user_delete');

// API : get all customers
$app->get('/api/clients', "GoDevis\Controller\ApiController::getClientsAction")
->bind('api_clients');

// API : get a customer
$app->get('/api/client/{id}', "GoDevis\Controller\ApiController::getClientAction")
->bind('api_client');

// API : create a customer
$app->post('/api/client', "GoDevis\Controller\ApiController::addClientAction")
->bind('api_client_add');

// API : remove a customer
$app->delete('/api/client/{id}', "GoDevis\Controller\ApiController::deleteClientAction")
->bind('api_client_delete');

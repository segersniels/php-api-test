<?php

use Slim\Http\Request;
use Slim\Http\Response;

require __DIR__ . '/../includes/api.php';

$app->get('/customers', function (Request $request, Response $response, array $args) {
    $api = new API($this->db);
    $response = $api->getCustomers();
    return $response;
});

$app->get('/customer/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $api = new API($this->db);
    $response = $api->getCustomer($id);
    return $response;
});

$app->get('/products', function (Request $request, Response $response, array $args) {
    $api = new API($this->db);
    $response = $api->getProducts();
    return $response;
});

$app->get('/product/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $api = new API($this->db);
    $response = $api->getProduct($id);
    return $response;
});

$app->post('/order', function (Request $request, Response $response, array $args) {
    $data = $request->getParsedBody();
    $api = new API($this->db);
    $response = $api->calculateDiscount($data);
    return $response;
});
<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/customers', function (Request $request, Response $response, array $args) {
    $response = $this->api->getCustomers();
    return $response;
});

$app->get('/customer/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $response = $this->api->getCustomer($id);
    return $response;
});

$app->get('/products', function (Request $request, Response $response, array $args) {
    $response = $this->api->getProducts();
    return $response;
});

$app->get('/product/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $response = $this->api->getProduct($id);
    return $response;
});

$app->post('/order', function (Request $request, Response $response, array $args) {
    $data = $request->getParsedBody();
    $response = $this->api->calculateDiscount($data);
    return $response;
});
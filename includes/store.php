<?php

class Store
{
    private $settings;
    private $db;

    public function __construct($settings)
    {
        $this->settings = $settings['db'];
        $this->db = new PDO("mysql:host=" . $this->settings['host'] . ";port=" . $this->settings['port'] . ";dbname=" . $this->settings['dbname'],
            $this->settings['user'], $this->settings['pass']);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public function query($query)
    {
        try {
            $stmt = $this->db->query($query);
            $response = $stmt->fetchAll(PDO::FETCH_OBJ);
            return json_encode($response);
        } catch (PDOException $e) {
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    public function queryById($query, $id)
    {
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            $response = $stmt->fetch();
            return json_encode($response);
        } catch (PDOException $e) {
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    public function getProducts()
    {
        $products = $this->query('SELECT * FROM products');
        return $products;
    }

    public function getProduct($id)
    {
        $product = $this->queryById("SELECT * FROM products WHERE id=?", $id);
        return $product;
    }

    public function getCustomers()
    {
        $customers = $this->query('SELECT * FROM customers');
        return $customers;
    }

    public function getCustomer($id)
    {
        $customer = $this->queryById("SELECT * FROM customers WHERE id=?", $id);
        return $customer;
    }
}

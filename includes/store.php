<?php

class Store
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
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

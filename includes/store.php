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
}

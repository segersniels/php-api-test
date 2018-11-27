<?php

function connect()
{
    $settings = [
        "host" => "127.0.0.1",
        "port" => "3306",
        "dbname" => "teamleader",
        "user" => "root",
        "pass" => "example",
    ];
    $pdo = new PDO("mysql:host=" . $settings['host'] . ";port=" . $settings['port'] . ";dbname=" . $settings['dbname'],
        $settings['user'], $settings['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
}

function execute($sql)
{
    $pdo = connect();
    $pdo->exec($sql);
}

// Customers
try {
    // Create customers table
    $table = "customers";
    $sql = "CREATE TABLE IF NOT EXISTS $table (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(13) CHARACTER SET utf8,
        `since` DATETIME,
        `revenue` NUMERIC
    );";
    execute($sql);

    // Insert basic data into customers table
    $sql = "INSERT INTO $table VALUES
    (1,'Coca Cola','2014-06-28 00:00:00',492.12),
    (2,'Teamleader','2015-01-15 00:00:00',1505.95),
    (3,'Jeroen De Wit','2016-02-11 00:00:00',0.00);";
    execute($sql);

} catch (PDOException $e) {
    echo $e->getMessage(); //Remove or change message in production code
}

// Products
try {
    // Create products table
    $table = "products";
    $sql = "CREATE TABLE IF NOT EXISTS $table (
        `id` VARCHAR(4) CHARACTER SET utf8 PRIMARY KEY,
        `description` VARCHAR(27) CHARACTER SET utf8,
        `category` INT,
        `price` NUMERIC
    );";
    execute($sql);

    // Insert basic data into products table
    $sql = "INSERT INTO $table VALUES
    ('A101','Screwdriver',1,9.75),
    ('A102','Electric screwdriver',1,49.50),
    ('B101','Basic on-off switch',2,4.99),
    ('B102','Press button',2,4.99),
    ('B103','Switch with motion detector',2,12.95);";
    execute($sql);

} catch (PDOException $e) {
    echo $e->getMessage(); //Remove or change message in production code
}

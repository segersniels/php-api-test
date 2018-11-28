<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'db' => [
            "host" => "127.0.0.1",
            "port" => "3306",
            "dbname" => "teamleader",
            "user" => "root",
            "pass" => "example",
        ],
    ],
];

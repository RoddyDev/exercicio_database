<?php
    header('Access-Control-Allow-Origin: *');
    header("charset: utf-8");
    date_default_timezone_set('America/Sao_Paulo');

    $action = $_GET["type"];
    $area = $_GET["area"];
    $em = $_GET["id"];

    # Connect to database
    try {
        $handler = new mysqli("localhost", "root", base64_decode($st), "empresa");
    } catch (Exception $e) {
        echo "ERROR: Could not connect to user database.";
        exit();
    }

    switch ($action) {
        case "delete":
            $query = "delete from `funcionarios` where `id` = " . $em;
            $res = $handler->query($query);
        break;
    }
?>
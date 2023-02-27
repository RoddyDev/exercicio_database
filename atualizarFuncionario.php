<?php
    header('Access-Control-Allow-Origin: *');
    header("charset: utf-8");
    date_default_timezone_set('America/Sao_Paulo');

    $st = "cm9kZHlkZXYyMDAxQA==";
    $name = $_GET["name"];
    $cpf = $_GET["cpf"];
    $proj = $_GET["id_proj"];
    $dept = $_GET["id_dept"];

    # Connect to database
    try {
        $handler = new mysqli("localhost", "root", base64_decode($st), "empresa");
    } catch (Exception $e) {
        echo "ERROR: Could not connect to user database.";
        exit();
    }
?>
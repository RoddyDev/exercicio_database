<?php
    header('Access-Control-Allow-Origin: *');
    header("charset: utf-8");
    date_default_timezone_set('America/Sao_Paulo');

    $st = "cm9kZHlkZXYyMDAxQA==";
    $action = $_GET["action"];
    $f_id = $_GET["func_id"];
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

    if ($action == "update") {
        $query = "UPDATE `funcionarios` set `nome`='" . $name . "', `cpf`='" . $cpf . "', `id_projeto`=" . $proj . ", `id_departamento`=" . $dept . " where id = " . $f_id;
        $handler->query($query);
    }
    if ($action == "remove") {
        $query = "delete from `funcionarios` where id=" . $f_id;
        $handler->query($query);
    }

    header("Location: https://roddydev.com/projeto");
?>
<?php
    header('Access-Control-Allow-Origin: *');
    header("charset: utf-8");
    date_default_timezone_set('America/Sao_Paulo');

    $user = $_GET["id"];

    $st = "cm9kZHlkZXYyMDAxQA==";

    # Connect to database
    try {
        $handler = new mysqli("localhost", "root", base64_decode($st), "empresa");
    } catch (Exception $e) {
        echo "ERROR: Could not connect to user database.";
        exit();
    }

    $query = "SELECT * FROM `funcionarios` where id = " . $user;
    $result = $handler->query($query);

    if ($result->num_rows != 0) {
        $row = $result->fetch_assoc();

        $output = array("name" => $row["nome"], "cpf" => $row["cpf"], "id_proj" => $row["id_projeto"], "id_dept" => $row["id_departamento"]);
        echo json_encode($output);
    }
?>
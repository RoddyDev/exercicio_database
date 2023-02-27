<?php
    header('Access-Control-Allow-Origin: *');
    header("charset: utf-8");
    date_default_timezone_set('America/Sao_Paulo');

    $st = "cm9kZHlkZXYyMDAxQA==";

    # Connect to database
    try {
        $handler = new mysqli("localhost", "root", base64_decode($st), "empresa");
    } catch (Exception $e) {
        echo "ERROR: Could not connect to user database.";
        exit();
    }

    $selectedArea = $_GET["area"];
    if ($selectedArea == 0) {
        // Funcionários
        $query = "SELECT * FROM `funcionarios`";
        $results = $handler->query($query);

        $func = array();

        // There are no employers
        if ($results->num_rows == 0) {
            echo json_encode(array("type" => "error_message", "message" => "Nenhum funcionário cadastrado."));
        } else {
            while($row = $results->fetch_assoc()) {
                $projeto = $row["id_departamento"];
                $query = "SELECT * FROM `departamentos` where id = " . $projeto;
                $result = $handler->query($query);
                $res = $result->fetch_assoc();

                array_push($func, array("id" => $row["id"], "nome" => $row["nome"], "cpf" => $row["cpf"], "proj" => $res["nome"], "dept" => $row["id_departamento"]));
            }
            echo json_encode($func);
        }
    }

    if ($selectedArea == 1) {
        $query = "SELECT * FROM `projetos`";
        $results = $handler->query($query);
        $proj = array();

        if ($results->num_rows == 0) {
            echo json_encode(array("type" => "error_message", "message" => "Nenhum projeto existente."));
        } else {
            while($row = $results->fetch_assoc()) {
                array_push($proj, array("id" => $row["id"], "nome" => $row["nome"], "c_date" => $row["creation_date"], "f_date" => $row["finish_date"]));
            }
            echo json_encode($proj);
        }
    }

    if ($selectedArea == 2) {
        $query = "SELECT * FROM `departamentos`";
        $results = $handler->query($query);
        $dept = array();

        if ($results->num_rows == 0) {
            echo json_encode(array("type" => "error_message", "message" => "Nenhum projeto existente."));
        } else {
            while($row = $results->fetch_assoc()) {
                array_push($dept, array("id" => $row["id"], "nome" => $row["nome"]));
            }
            echo json_encode($dept);
        }
    }
?>
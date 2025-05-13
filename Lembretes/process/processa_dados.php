<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "euro_consultoria";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // Proteção básica contra SQL Injection
    function sanitize($conn, $value) {
        return mysqli_real_escape_string($conn, trim($value));
    }

    switch ($action) {
        case 'lembrete':
            $familia = sanitize($conn, $_POST['familia']);
            $requerentes = $_POST['requerente'];
            $data_lembrete = sanitize($conn, $_POST['data_lembrete']);
            $data_pagamento = sanitize($conn, $_POST['data_pagamento']);

            foreach ($requerentes as $requerente) {
                $requerente = sanitize($conn, $requerente);
                $sql = "INSERT INTO lembretes (familia, requerente, data_lembrete, data_pagamento)
                        VALUES ('$familia', '$requerente', '$data_lembrete', '$data_pagamento')";
                if (!$conn->query($sql)) {
                    echo "Erro ao cadastrar lembrete para $requerente: " . $conn->error;
                }
            }

            header("Location: ../index.php");
            exit;

        case 'apresentacao':
            $familia = sanitize($conn, $_POST['familia']);
            $data_apresentacao = sanitize($conn, $_POST['data_apresentacao']);

            $sql = "INSERT INTO apresentacoes (familia, data_apresentacao)
                    VALUES ('$familia', '$data_apresentacao')";

            if ($conn->query($sql) === TRUE) {
                header("Location: ../index.php");
                exit;
            } else {
                echo "Erro ao cadastrar apresentação: " . $conn->error;
            }
            break;

        case 'negociacao':
            $familia = sanitize($conn, $_POST['familia']);
            $valor_acordado = sanitize($conn, $_POST['valor_acordado']);
            $data_negociacao = sanitize($conn, $_POST['data_negociacao']);
            $tipo_negociacao = sanitize($conn, $_POST['tipo_negociacao']);
            $descricao = sanitize($conn, $_POST['descricao']);

            $sql = "INSERT INTO negociacoes (familia, valor_acordado, data_negociacao, tipo_negociacao, descricao)
                    VALUES ('$familia', '$valor_acordado', '$data_negociacao', '$tipo_negociacao', '$descricao')";

            if ($conn->query($sql) === TRUE) {
                header("Location: ../index.php");
                exit;
            } else {
                echo "Erro ao cadastrar negociação: " . $conn->error;
            }
            break;

        case 'aditivo':
            $familia = sanitize($conn, $_POST['familia']);
            $data_negociacao = sanitize($conn, $_POST['data_negociacao']);
            $descricao = sanitize($conn, $_POST['descricao']);
            $valor_acordado = sanitize($conn, $_POST['valor_acordado']);

            $sql = "INSERT INTO aditivos (familia, data_negociacao, descricao, valor_acordado)
                    VALUES ('$familia', '$data_negociacao', '$descricao', '$valor_acordado')";

            if ($conn->query($sql) === TRUE) {
                header("Location: ../index.php");
                exit;
            } else {
                echo "Erro ao cadastrar aditivo: " . $conn->error;
            }
            break;

        default:
            echo "Ação inválida!";
            break;
    }
}

$conn->close();
?>

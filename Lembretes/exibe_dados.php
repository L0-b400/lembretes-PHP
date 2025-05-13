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

$show = isset($_GET['show']) ? $_GET['show'] : '';

// Exibir Lembretes
if ($show == 'lembretes') {
    $sql = "SELECT * FROM lembretes";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h3>Lembretes Cadastrados</h3>";
        while($row = $result->fetch_assoc()) {
            echo "<p><strong>Família:</strong> " . $row['familia'] . " | <strong>Requerente:</strong> " . $row['requerente'] . " | <strong>Data Lembrete:</strong> " . $row['data_lembrete'] . " | <strong>Data Pagamento:</strong> " . $row['data_pagamento'] . "</p>";
        }
    } else {
        echo "<p>Nenhum lembrete encontrado.</p>";
    }
}

// Exibir Apresentações
if ($show == 'apresentacoes') {
    $sql = "SELECT * FROM apresentacoes";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h3>Apresentações Cadastradas</h3>";
        while($row = $result->fetch_assoc()) {
            echo "<p><strong>Família:</strong> " . $row['familia'] . " | <strong>Data Apresentação:</strong> " . $row['data_apresentacao'] . "</p>";
        }
    } else {
        echo "<p>Nenhuma apresentação encontrada.</p>";
    }
}

// Exibir Negociações
if ($show == 'negociacoes') {
    $sql = "SELECT * FROM negociacoes";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h3>Negociações Cadastradas</h3>";
        while($row = $result->fetch_assoc()) {
            echo "<p><strong>Família:</strong> " . $row['familia'] . " | <strong>Valor Acordado:</strong> " . $row['valor_acordado'] . " | <strong>Data Negociação:</strong> " . $row['data_negociacao'] . " | <strong>Tipo Negociação:</strong> " . $row['tipo_negociacao'] . "</p>";
        }
    } else {
        echo "<p>Nenhuma negociação encontrada.</p>";
    }
}

// Exibir Aditivos
if ($show == 'aditivos') {
    $sql = "SELECT * FROM aditivos";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h3>Aditivos Cadastrados</h3>";
        while($row = $result->fetch_assoc()) {
            echo "<p><strong>Família:</strong> " . $row['familia'] . " | <strong>Valor Acordado:</strong> " . $row['valor_acordado'] . " | <strong>Data Negociação:</strong> " . $row['data_negociacao'] . "</p>";
        }
    } else {
        echo "<p>Nenhum aditivo encontrado.</p>";
    }
}

$conn->close();
?>
<?php
$servername = "sql211.infinityfree.com";
$username = "if0_36488093";
$password = "HJvH2wkGT3";
$dbname = "if0_36488093_db";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verifica se o ID foi passado na URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Deletar o registro
    $delete_sql = "DELETE FROM lembretes WHERE id = $id"; // Altere para a tabela necessária

    if ($conn->query($delete_sql) === TRUE) {
        echo "Registro excluído com sucesso.";
        header("Location: consulta.php"); // Redireciona para a página de consulta
        exit;
    } else {
        echo "Erro ao excluir o registro: " . $conn->error;
    }
} else {
    echo "ID não fornecido.";
    exit;
}

$conn->close();
?>

<?php
require '../config/db.php';

// Verifica se o ID foi passado na URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Deletar o registro
    $delete_sql = "DELETE FROM lembretes WHERE id = :id"; // Usando prepared statements para evitar SQL injection

    // Preparar a consulta
    $stmt = $pdo->prepare($delete_sql);

    // Bind do parâmetro :id
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Registro excluído com sucesso.";
        header("Location: ../consulta.php"); // Redireciona para a página de consulta
        exit;
    } else {
        echo "Erro ao excluir o registro.";
    }
} else {
    echo "ID não fornecido.";
    exit;
}

$pdo = null; // Fechar a conexão PDO
?>

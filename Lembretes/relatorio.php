<?php
require 'config/db.php';
// Tabelas e colunas permitidas
$allowedTables = ['lembretes'];
$allowedColumns = ['titulo', 'descricao', 'data'];

// Receber os dados do formulário
$table = $_POST['table'] ?? 'lembretes';
$filterColumn = $_POST['filterColumn'] ?? '';
$filterValue = $_POST['filterValue'] ?? '';

// Validar tabela
if (!in_array($table, $allowedTables)) {
    die("Tabela inválida.");
}

// Validar coluna se fornecida
if ($filterColumn && !in_array($filterColumn, $allowedColumns)) {
    die("Coluna de filtro inválida.");
}

// Montar consulta SQL
if ($filterColumn && $filterValue) {
    $stmt = $conn->prepare("SELECT * FROM $table WHERE $filterColumn LIKE ?");
    $likeValue = "%$filterValue%";
    $stmt->bind_param("s", $likeValue);
    $stmt->execute();
    $dataResult = $stmt->get_result();
} else {
    $dataResult = $conn->query("SELECT * FROM $table");
}

// Verificar se há dados
if ($dataResult && $dataResult->num_rows > 0) {
    // Nome do arquivo CSV
    $filename = ucfirst($table) . '_relatorio.csv';

    // Cabeçalhos para download
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    // Abrir a saída
    $output = fopen('php://output', 'w');

    // Adicionar BOM para compatibilidade com Excel
    fwrite($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

    // Escrever cabeçalhos das colunas
    $fields = $dataResult->fetch_fields();
    $header = [];
    foreach ($fields as $field) {
        $header[] = $field->name;
    }
    fputcsv($output, $header, ';');

    // Escrever dados linha por linha
    while ($row = $dataResult->fetch_assoc()) {
        fputcsv($output, $row, ';');
    }

    fclose($output);
    exit; // IMPORTANTE: encerra o script após envio do arquivo
} else {
    echo "Nenhum dado encontrado para exportar.";
}

$conn->close();
?>

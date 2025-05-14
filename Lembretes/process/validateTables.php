<?php
declare(strict_types=1);
require_once __DIR__ . '/../config/db.php'; // ajuste conforme o caminho da sua conexão

// Listas seguras
$allowedTables = ['lembretes', 'apresentacoes', 'negociacoes', 'aditivos'];
$allowedColumns = ['familia', 'requerente', 'data_lembrete', 'data_apresentacao', 'data_negociacao', 'descricao'];

// Inicializa variáveis do POST
$table = $_POST['table'] ?? 'lembretes';
$filterColumn = $_POST['filterColumn'] ?? '';
$filterValue = $_POST['filterValue'] ?? '';
$export = isset($_POST['export']);

// Validação
if (!in_array($table, $allowedTables)) {
    die("Tabela inválida.");
}
if ($filterColumn && !in_array($filterColumn, $allowedColumns)) {
    die("Coluna de filtro inválida.");
}

// Consulta
try {
    if ($filterColumn && $filterValue) {
        $stmt = $pdo->prepare("SELECT * FROM $table WHERE $filterColumn LIKE :value");
        $stmt->execute(['value' => "%$filterValue%"]);
        $dataResult = $stmt->fetchAll();
    } else {
        $stmt = $pdo->query("SELECT * FROM $table");
        $dataResult = $stmt->fetchAll();
    }
} catch (PDOException $e) {
    error_log("Erro na consulta: " . $e->getMessage());
    die("Erro ao buscar dados.");
}

// Exportação CSV
if ($export && !empty($dataResult)) {
    $filename = ucfirst($table) . '_relatorio.csv';

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    $output = fopen('php://output', 'w');
    fwrite($output, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM para UTF-8

    // Cabeçalhos
    $headers = array_keys($dataResult[0]);
    fputcsv($output, $headers, ';');

    // Dados
    foreach ($dataResult as $row) {
        fputcsv($output, $row, ';');
    }

    fclose($output);
    exit;
}

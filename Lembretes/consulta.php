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

// Listas seguras
$allowedTables = ['lembretes', 'apresentacoes', 'negociacoes', 'aditivos'];
$allowedColumns = ['familia', 'requerente', 'data_lembrete', 'data_apresentacao', 'data_negociacao', 'descricao'];

// Inicializa variáveis
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

// Consulta com ou sem filtro
if ($filterColumn && $filterValue) {
    $stmt = $conn->prepare("SELECT * FROM $table WHERE $filterColumn LIKE ?");
    $likeValue = "%$filterValue%";
    $stmt->bind_param("s", $likeValue);
    $stmt->execute();
    $dataResult = $stmt->get_result();
} else {
    $dataResult = $conn->query("SELECT * FROM $table");
}

// Se for exportação
if ($export && $dataResult && $dataResult->num_rows > 0) {
    $filename = ucfirst($table) . '_relatorio.csv';

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    $output = fopen('php://output', 'w');
    fwrite($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

    $fields = $dataResult->fetch_fields();
    $header = [];
    foreach ($fields as $field) {
        $header[] = $field->name;
    }
    fputcsv($output, $header, ';');

    while ($row = $dataResult->fetch_assoc()) {
        fputcsv($output, $row, ';');
    }

    fclose($output);
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Dados</title>
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="style.css">
</head>
<?php include "assets/navbar.php" ?>
<body>


    
    <div class="container">
        <h1>Consulta de Dados</h1>
        <form method="POST">
            <label for="table">Tipo de dado:</label>
            <select name="table" id="table" onchange="this.form.submit()">
                <?php foreach ($allowedTables as $t): ?>
                    <option value="<?= $t ?>" <?= $table == $t ? 'selected' : '' ?>><?= ucfirst($t) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="filterColumn">Filtrar por:</label>
            <select name="filterColumn" id="filterColumn">
                <?php foreach ($allowedColumns as $col): ?>
                    <option value="<?= $col ?>" <?= $filterColumn == $col ? 'selected' : '' ?>><?= ucfirst(str_replace('_', ' ', $col)) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="filterValue">Valor:</label>
            <input type="text" name="filterValue" id="filterValue" value="<?= htmlspecialchars($filterValue) ?>" placeholder="Digite o valor">

            <button type="submit" name="filter">Filtrar</button>
            <button type="submit" name="export">Exportar CSV</button>
        </form>

        <!-- Resultados -->
        <?php if ($dataResult && $dataResult->num_rows > 0): ?>
            <div id="resultados">
                <h3>Resultados encontrados:</h3>
                <table>
                    <thead>
                        <tr>
                            <?php foreach ($dataResult->fetch_fields() as $field): ?>
                                <th><?= ucfirst(str_replace('_', ' ', $field->name)) ?></th>
                            <?php endforeach; ?>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $dataResult->data_seek(0); ?>
                        <?php while ($row = $dataResult->fetch_assoc()): ?>
                            <tr>
                                <?php foreach ($row as $value): ?>
                                    <td><?= htmlspecialchars($value) ?></td>
                                <?php endforeach; ?>
                                <td>
                                    <a href="process/editar.php?id=<?= $row['id'] ?>">Editar</a> |
                                    <a href="process/excluir.php?id=<?= $row['id'] ?>" onclick="return confirm('Deseja excluir?')">Excluir</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>Nenhum dado encontrado.</p>
        <?php endif; ?>
    </div>
    <script src="assets/js/script.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>
</html>
<?php $conn->close(); ?>

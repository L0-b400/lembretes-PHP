<?php
require 'config/db.php';
require 'process/validateTables.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Dados</title>
    <link rel="stylesheet" href="assets/css/nav.css">
    <link rel="stylesheet" href="assets/css/style.css">
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
        <?php 
        if ($dataResult) {
            if (count($dataResult) > 0): ?>
                <div id="resultados">
                    <h3>Resultados encontrados:</h3>
                    <table>
                        <thead>
                            <tr>
                                <?php foreach (array_keys($dataResult[0]) as $field): ?>
                                    <th><?= ucfirst(str_replace('_', ' ', $field)) ?></th>
                                <?php endforeach; ?>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dataResult as $row): ?>
                                <tr>
                                    <?php foreach ($row as $value): ?>
                                        <td><?= htmlspecialchars($value) ?></td>
                                    <?php endforeach; ?>
                                    <td>
                                        <a href="process/editar.php?id=<?= $row['id'] ?>">Editar</a> |
                                        <a href="process/excluir.php?id=<?= $row['id'] ?>" onclick="return confirm('Deseja excluir?')">Excluir</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>Nenhum dado encontrado.</p>
            <?php endif;
        } else { ?>
            <p>Erro na consulta.</p>
        <?php } ?>
    </div>
    <script src="assets/js/script.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>
</html>

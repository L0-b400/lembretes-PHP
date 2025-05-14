<?php
require '../config/db.php';  // Incluindo a configuração de conexão ao banco de dados com PDO

// Verifica se o ID foi passado na URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Buscar dados do registro com PDO
    $sql = "SELECT * FROM lembretes WHERE id = :id"; // Usando parâmetro preparado
    $stmt = $pdo->prepare($sql);  // Substituído $conn por $pdo
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "Registro não encontrado.";
        exit;
    }
} else {
    echo "ID não fornecido.";
    exit;
}

// Atualizar os dados se o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $familia = $_POST['familia'];
    $requerente = $_POST['requerente'];
    $data_lembrete = $_POST['data_lembrete'];
    $data_pagamento = $_POST['data_pagamento'];

    // Atualização no banco de dados usando PDO
    $update_sql = "UPDATE lembretes SET familia = :familia, requerente = :requerente, data_lembrete = :data_lembrete, data_pagamento = :data_pagamento WHERE id = :id";
    
    $stmt = $pdo->prepare($update_sql);  // Substituído $conn por $pdo
    $stmt->bindParam(':familia', $familia, PDO::PARAM_STR);
    $stmt->bindParam(':requerente', $requerente, PDO::PARAM_STR);
    $stmt->bindParam(':data_lembrete', $data_lembrete, PDO::PARAM_STR);
    $stmt->bindParam(':data_pagamento', $data_pagamento, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Registro atualizado com sucesso.";
        header("Location: ../consulta.php"); // Redireciona para a página de consulta
        exit;
    } else {
        echo "Erro ao atualizar o registro.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Lembrete</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Editar Lembrete</h1>

        <!-- Formulário de edição -->
        <form method="POST">
            <label for="familia">Família:</label>
            <input type="text" name="familia" id="familia" value="<?php echo htmlspecialchars($row['familia']); ?>" required>

            <label for="requerente">Requerente:</label>
            <input type="text" name="requerente" id="requerente" value="<?php echo htmlspecialchars($row['requerente']); ?>" required>

            <label for="data_lembrete">Data do Lembrete:</label>
            <input type="date" name="data_lembrete" id="data_lembrete" value="<?php echo htmlspecialchars($row['data_lembrete']); ?>" required>

            <label for="data_pagamento">Data do Pagamento:</label>
            <input type="date" name="data_pagamento" id="data_pagamento" value="<?php echo htmlspecialchars($row['data_pagamento']); ?>" required>

            <button type="submit">Salvar Alterações</button>
        </form>

        <a href="consulta.php">Voltar para a consulta</a>
    </div>
</body>
</html>

<?php
// Fechar a conexão PDO (opcional)
$pdo = null;
?>

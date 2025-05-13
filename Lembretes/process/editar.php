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

    // Buscar dados do registro
    $sql = "SELECT * FROM lembretes WHERE id = $id"; // Altere para a tabela necessária
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
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

    $update_sql = "UPDATE lembretes SET familia = '$familia', requerente = '$requerente', data_lembrete = '$data_lembrete', data_pagamento = '$data_pagamento' WHERE id = $id";
    
    if ($conn->query($update_sql) === TRUE) {
        echo "Registro atualizado com sucesso.";
        header("Location: consulta.php"); // Redireciona para a página de consulta
        exit;
    } else {
        echo "Erro ao atualizar o registro: " . $conn->error;
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
            <input type="text" name="familia" id="familia" value="<?php echo $row['familia']; ?>" required>

            <label for="requerente">Requerente:</label>
            <input type="text" name="requerente" id="requerente" value="<?php echo $row['requerente']; ?>" required>

            <label for="data_lembrete">Data do Lembrete:</label>
            <input type="date" name="data_lembrete" id="data_lembrete" value="<?php echo $row['data_lembrete']; ?>" required>

            <label for="data_pagamento">Data do Pagamento:</label>
            <input name="data_pagamento" id="data_pagamento" value"<?php echo $row['data_pagamento']; ?>">

            <button type="submit">Salvar Alterações</button>
        </form>

        <a href="consulta.php">Voltar para a consulta</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>

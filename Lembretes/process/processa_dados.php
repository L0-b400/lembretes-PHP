<?php
require '../config/db.php';

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // Função de sanitização
    function sanitize($value) {
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }

    switch ($action) {
        case 'lembrete':
            $familia = sanitize($_POST['familia']);
            $requerentes = $_POST['requerente'];
            $data_lembrete = sanitize($_POST['data_lembrete']);
            $data_pagamento = sanitize($_POST['data_pagamento']);

            $stmt = $pdo->prepare("INSERT INTO lembretes (familia, requerente, data_lembrete, data_pagamento)
                                   VALUES (:familia, :requerente, :data_lembrete, :data_pagamento)");

            foreach ($requerentes as $requerente) {
                $stmt->execute([
                    ':familia' => $familia,
                    ':requerente' => sanitize($requerente),
                    ':data_lembrete' => $data_lembrete,
                    ':data_pagamento' => $data_pagamento
                ]);
            }

            header("Location: ../index.php");
            exit;

        case 'apresentacao':
            $familia = sanitize($_POST['familia']);
            $data_apresentacao = sanitize($_POST['data_apresentacao']);

            $stmt = $pdo->prepare("INSERT INTO apresentacoes (familia, data_apresentacao)
                                   VALUES (:familia, :data_apresentacao)");

            $stmt->execute([
                ':familia' => $familia,
                ':data_apresentacao' => $data_apresentacao
            ]);

            header("Location: ../index.php");
            exit;

        case 'negociacao':
            $familia = sanitize($_POST['familia']);
            $valor_acordado = sanitize($_POST['valor_acordado']);
            $data_negociacao = sanitize($_POST['data_negociacao']);
            $tipo_negociacao = sanitize($_POST['tipo_negociacao']);
            $descricao = sanitize($_POST['descricao']);

            $stmt = $pdo->prepare("INSERT INTO negociacoes (familia, valor_acordado, data_negociacao, tipo_negociacao, descricao)
                                   VALUES (:familia, :valor_acordado, :data_negociacao, :tipo_negociacao, :descricao)");

            $stmt->execute([
                ':familia' => $familia,
                ':valor_acordado' => $valor_acordado,
                ':data_negociacao' => $data_negociacao,
                ':tipo_negociacao' => $tipo_negociacao,
                ':descricao' => $descricao
            ]);

            header("Location: ../index.php");
            exit;

        case 'aditivo':
            $familia = sanitize($_POST['familia']);
            $data_negociacao = sanitize($_POST['data_negociacao']);
            $descricao = sanitize($_POST['descricao']);
            $valor_acordado = sanitize($_POST['valor_acordado']);

            $stmt = $pdo->prepare("INSERT INTO aditivos (familia, data_negociacao, descricao, valor_acordado)
                                   VALUES (:familia, :data_negociacao, :descricao, :valor_acordado)");

            $stmt->execute([
                ':familia' => $familia,
                ':data_negociacao' => $data_negociacao,
                ':descricao' => $descricao,
                ':valor_acordado' => $valor_acordado
            ]);

            header("Location: ../index.php");
            exit;

        default:
            echo "Ação inválida!";
            break;
    }
}

$pdo = null; // Fechar a conexão com o banco de dados
?>

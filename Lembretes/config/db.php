<?php

declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

// Carregar variáveis de ambiente
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Defina constantes para os ambientes
define('ENV_DEV', 'dev');
define('ENV_PROD', 'prod');

// Função para obter a configuração do banco de dados com base no ambiente
function getDbConfig(string $env): array {
    if ($env === ENV_PROD) {
        return [
            'host' => $_ENV['DB_HOST_PROD'] ?? 'localhost',
            'user' => $_ENV['DB_USER_PROD'] ?? 'root',
            'pass' => $_ENV['DB_PASS_PROD'] ?? '',
            'db'   => $_ENV['DB_NAME_PROD'] ?? 'euro_consultoria',
        ];
    }
    return [
        'host' => $_ENV['DB_HOST'] ?? 'localhost',
        'user' => $_ENV['DB_USER'] ?? 'root',
        'pass' => $_ENV['DB_PASS'] ?? '',
        'db'   => $_ENV['DB_NAME'] ?? 'meubanco',
    ];
}

// Verifique se as variáveis de ambiente estão definidas
$appEnv = $_ENV['APP_ENV'] ?? ENV_DEV;
if (!in_array($appEnv, [ENV_DEV, ENV_PROD])) {
    die("Erro: Ambiente de aplicação inválido.");
}

// Obtenha a configuração do banco de dados com base no ambiente
$dbConfig = getDbConfig($appEnv);

// Configuração do DSN
$dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['db']};charset=utf8mb4";

// Opções de conexão do PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Tentativa de conexão ao banco de dados
    $pdo = new PDO($dsn, $dbConfig['user'], $dbConfig['pass'], $options);
} catch (PDOException $e) {
    // Registrar o erro de conexão sem expô-lo diretamente ao usuário
    error_log("Erro na conexão com o banco de dados: " . $e->getMessage());
    die("Erro ao conectar ao banco de dados. Por favor, tente novamente mais tarde.");
}

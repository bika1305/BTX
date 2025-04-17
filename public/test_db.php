<?php
header('Content-Type: text/plain; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);

    $dbConfig = [
        'host'     => getenv('DB_HOST'),
        'port'     => getenv('DB_PORT'),
        'dbname'   => getenv('DB_NAME'),
        'user'     => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD')
    ];

try {
    // Подключение
    $dsn = "pgsql:host={$dbConfig['host']};port={$dbConfig['port']};dbname={$dbConfig['dbname']}";
    $pdo = new PDO($dsn, $dbConfig['user'], $dbConfig['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Тестовый запрос
    $version = $pdo->query('SELECT version()')->fetchColumn();
    echo "✅ Подключение успешно!\nВерсия PostgreSQL: $version\n\n";
    
    // Пример запроса к таблице (если существует)
    $tables = $pdo->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'")->fetchAll();
    echo "Таблицы в базе:\n";
    print_r($tables);
    
} catch (PDOException $e) {
    die("❌ Ошибка подключения: " . $e->getMessage());
}

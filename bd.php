<?php
/**
 * Conexão com o Banco de Dados MySQL via PDO
 * Resenha ou Ódio - Stack Seguro com PDO e Prepared Statements
 */

require_once __DIR__ . '/config/config.php';

/**
 * Retorna a instância ativa de conexão PDO com o MySQL
 * 
 * @return PDO
 * @throws PDOException
 */
function getDBConnection(): PDO {
    static $pdo = null;

    if ($pdo !== null) {
        return $pdo;
    }

    $dsn = sprintf(
        "mysql:host=%s;port=%s;dbname=%s;charset=%s",
        DB_HOST,
        DB_PORT,
        DB_NAME,
        DB_CHARSET
    );

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_CHARSET
    ];

    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (PDOException $e) {
        // Se o erro for de banco inexistente (código 1049), tenta auto-inicializar
        if ($e->getCode() == 1049) {
            $pdo = inicializarBancoDeDados();
            if ($pdo) {
                return $pdo;
            }
        }
        
        // Em caso de erro irrecuperável, registra e lança exceção segura
        error_log("[DB ERROR] Falha na conexão com MySQL: " . $e->getMessage());
        throw new PDOException("Não foi possível conectar ao banco de dados MySQL. Verifique se o serviço está ativo e as credenciais em config/config.php.");
    }

    return $pdo;
}

/**
 * Inicializa automaticamente o banco de dados e as tabelas caso ainda não existam
 * 
 * @return PDO|null
 */
function inicializarBancoDeDados(): ?PDO {
    try {
        $dsnSemBase = sprintf("mysql:host=%s;port=%s;charset=%s", DB_HOST, DB_PORT, DB_CHARSET);
        $tempPdo = new PDO($dsnSemBase, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        $sqlPath = __DIR__ . '/database.sql';
        if (file_exists($sqlPath)) {
            $sqlContent = file_get_contents($sqlPath);
            // Executa as instruções do script SQL
            $tempPdo->exec($sqlContent);
            
            // Reconecta com o banco selecionado
            $dsnComBase = sprintf("mysql:host=%s;port=%s;dbname=%s;charset=%s", DB_HOST, DB_PORT, DB_NAME, DB_CHARSET);
            return new PDO($dsnComBase, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        }
    } catch (Exception $initErr) {
        error_log("[DB AUTO-INIT] Erro na auto-inicialização: " . $initErr->getMessage());
    }
    return null;
}

// Inicializa a variável global $pdo para compatibilidade estruturada
try {
    $pdo = getDBConnection();
} catch (PDOException $ex) {
    // Permite que páginas que tratam erro de conexão capturem adequadamente
    $pdo = null;
    $dbError = $ex->getMessage();
}

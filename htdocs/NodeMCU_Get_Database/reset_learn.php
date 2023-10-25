<?php
require 'database.php';
$pdo = Database::connect();

$sql = "UPDATE usuarios SET learn = 0";

if ($pdo->exec($sql) !== false) {
    echo "Coluna 'learn' redefinida com sucesso para 0 em todos os registros.";
} else {
    echo "Ocorreu um erro na redefinição da coluna 'learn'.";
}

Database::disconnect();
?>

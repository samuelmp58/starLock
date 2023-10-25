<?php
require '../NodeMCU_Get_Database/database.php';
$pdo = Database::connect();

// Etapa 1: Consulta SQL para selecionar registros com "learn" igual a 1 e pegar seus IDs
$sql = "SELECT id FROM usuarios WHERE learn = 1";
$result = $pdo->query($sql);
$ids = array();

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $ids[] = $row['id'];
}

// Converta os IDs em formato JSON para serem enviados de volta para o JavaScript
echo json_encode($ids);


?>

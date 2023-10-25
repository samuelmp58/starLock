<?php
require 'database.php';
$pdo = Database::connect();
if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    $sql = "UPDATE usuarios SET learn = 1 WHERE id = :userId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo "Aguardando aproximação de cartão.";
		
    } else {
        echo "Ocorreu um erro.";
    }
}


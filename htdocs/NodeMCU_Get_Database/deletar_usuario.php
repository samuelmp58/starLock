<?php
require 'database.php';
$pdo = Database::connect();
if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];
	
    $sql = "DELETE FROM usuarios WHERE id = :userId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        echo "Usuário excluído com sucesso!";
		
    } else {
        echo "Ocorreu um erro ao excluir o usuário.";
    }
}
?>

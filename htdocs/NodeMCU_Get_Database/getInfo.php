<?php
require 'database.php';
$pdo = Database::connect();
if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    $sql = "SELECT id, nome FROM usuarios WHERE id = :userId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
		$userData = array(
			'id' => $result['id'],
			'nome' => $result['nome']
		);
		echo json_encode($userData);
	} else {
		echo json_encode(array('id' => null, 'nome' => 'Usuário não encontrado'));
	}

}


?>

<?php
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nome = $_POST['nome'];

  if (!empty($nome)) {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "INSERT INTO usuarios (nome) VALUES (?)";
    $q = $pdo->prepare($sql);
    $q->execute([$nome]);

    Database::disconnect();
	
    // Redirecionando de volta
    header("Location: Main.php");
  }
}
?>

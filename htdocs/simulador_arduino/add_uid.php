<?php
require '../NodeMCU_Get_Database/database.php';
$pdo = Database::connect();

if (isset($_POST['codigoRFID'])) {
    $codigoRFID = $_POST['codigoRFID'];

    // Etapa 1: Consulta SQL para obter o ID do usuário com learn = 1
    $sql = "SELECT id FROM usuarios WHERE learn = 1";
    $result = $pdo->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $userId = $row['id'];

    if ($userId) {
        // Etapa 2: Verificar se o código RFID já está em uso e obter o ID do usuário associado
        $sqlVerificarExistencia = "SELECT usuario_id FROM chaves WHERE chave = :codigoRFID";
        $stmtVerificarExistencia = $pdo->prepare($sqlVerificarExistencia);
        $stmtVerificarExistencia->bindParam(':codigoRFID', $codigoRFID, PDO::PARAM_STR);
        $stmtVerificarExistencia->execute();

        if ($stmtVerificarExistencia->rowCount() > 0) {
            $rowExistencia = $stmtVerificarExistencia->fetch(PDO::FETCH_ASSOC);
            $usuarioIdExistente = $rowExistencia['usuario_id'];
            echo 'O codigo UID ja esta em uso pelo usuario com ID: ' . $usuarioIdExistente;
        } else {
            // O código RFID não está em uso, então insere
            $sqlInserirChave = "INSERT INTO chaves (usuario_id, chave) VALUES (:userId, :codigoRFID);";
            $stmtInserirChave = $pdo->prepare($sqlInserirChave);
            $stmtInserirChave->bindParam(':codigoRFID', $codigoRFID, PDO::PARAM_STR);
            $stmtInserirChave->bindParam(':userId', $userId, PDO::PARAM_INT);

            if ($stmtInserirChave->execute()) {
                // Etapa 3: Atualizar o valor "learn" na tabela clientes para 0
                $sqlAtualizarLearn = "UPDATE usuarios SET learn = 0 WHERE id = :userId";
                $stmtAtualizarLearn = $pdo->prepare($sqlAtualizarLearn);
                $stmtAtualizarLearn->bindParam(':userId', $userId, PDO::PARAM_INT);

                if ($stmtAtualizarLearn->execute()) {
					echo 'Codigo UID inserido com sucesso.';
                } else {
                    echo 'Ocorreu um erro ao atualizar "learn".';
                }
            } else {
                echo 'Ocorreu um erro ao inserir o código UID.';
            }
        }
    } else {
        echo 'Demorou muito para aproximar!'; // Learn voltou a ser 0 antes de aproximar
    }
} else {
    echo 'Dados ausentes.';
}
?>

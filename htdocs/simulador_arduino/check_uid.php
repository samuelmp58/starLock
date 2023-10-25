<?php
require '../NodeMCU_Get_Database/database.php';
$pdo = Database::connect();

if (isset($_POST['codigoRFID'])) {
    $codigoRFID = $_POST['codigoRFID'];

    // Código SQL para verificar a existência do código UID na tabela "chaves"
    $sqlVerificarExistencia = "SELECT usuario_id FROM chaves WHERE chave = :codigoRFID";
    $stmtVerificarExistencia = $pdo->prepare($sqlVerificarExistencia);
    $stmtVerificarExistencia->bindParam(':codigoRFID', $codigoRFID, PDO::PARAM_STR);
    $stmtVerificarExistencia->execute();

    if ($stmtVerificarExistencia->rowCount() > 0) {
        $rowExistencia = $stmtVerificarExistencia->fetch(PDO::FETCH_ASSOC);
        $usuarioIdExistente = $rowExistencia['usuario_id'];

        // Consulta SQL para atualizar o "ultimo_horario" para NOW
        $sqlAtualizarHorario = "UPDATE usuarios SET ultimo_horario = NOW() WHERE id = :usuarioIdExistente";
        $stmtAtualizarHorario = $pdo->prepare($sqlAtualizarHorario);
        $stmtAtualizarHorario->bindParam(':usuarioIdExistente', $usuarioIdExistente, PDO::PARAM_INT);
        $stmtAtualizarHorario->execute();

        // Consulta SQL para obter o nome do usuário pelo ID
        $sqlObterNomeUsuario = "SELECT nome FROM usuarios WHERE id = :usuarioIdExistente";
        $stmtObterNomeUsuario = $pdo->prepare($sqlObterNomeUsuario);
        $stmtObterNomeUsuario->bindParam(':usuarioIdExistente', $usuarioIdExistente, PDO::PARAM_INT);
        $stmtObterNomeUsuario->execute();
        $rowNomeUsuario = $stmtObterNomeUsuario->fetch(PDO::FETCH_ASSOC);
        $nomeUsuario = $rowNomeUsuario['nome'];

        //echo 'Aberto ao usuario com ID: ' . $usuarioIdExistente, ' Nome: ' . $nomeUsuario;
		echo 'Aberto ao usuario ' . $nomeUsuario, ' ID: ' . $usuarioIdExistente;
    } else {
        //echo json_encode(array('Nenhum usuario encontrado com este UID'));
		echo 'Nenhum usuario encontrado com este UID';
    }
}
?>

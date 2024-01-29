<!DOCTYPE html>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<style>
	@import url(https://fonts.googleapis.com/css?family=Roboto:400,500,300,700);
	html {
		font-family: Arial;
		display: inline-block;
		margin: 0px auto;
		/*text-align: center;*/
	}
	
	body {
		background: -webkit-linear-gradient(left, #25c481, #25b7c4);
		background: linear-gradient(to right, #202e38, #202e38);
		font-family: 'Roboto', sans-serif;
		background-image: url("images/background.jpg");
		background-size: cover;
	}
	/* ADICIONAR USUARIO */
	
	.button {
		display: inline-block;
		padding: 15px 25px;
		font-size: 24px;
		font-weight: bold;
		cursor: pointer;
		text-align: center;
		text-decoration: none;
		outline: none;
		color: #fff;
		background-color: #122331;
		border: none;
		border-radius: 15px;
		box-shadow: 0 5px #1a1a1a85;
		margin: 10px;
	}
	
	.button:hover {
		background-color: #4b908f;
	}
	
	.modal {
		display: none;
		position: fixed;
		z-index: 1;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(0, 0, 0, 0.4);
	}
	
	.modal-content {
		background-color: #171b2599;
		color: azure;
		margin: 10% auto;
		padding: 20px;
		border: 1px solid #0b112d;
		width: fit-content;
		text-align: center;
		font-size: 20px;
	}
	
	.input_nome {
		font-size: 20px;
	}
	
	.close {
		float: right;
		cursor: pointer;
	}
	
	.logotext {
		font-size: 2.0rem;
		color: #c6dcff;
		margin-top: -70px;
		padding-left: 200px;
	}
	
	#logo {
		margin-left: auto;
		margin-right: auto;
		text-align: center;
		padding-right: 150px;
	}
	/* TABELA USUARIOS */
	
	table {
		font-family: Arial, sans-serif;
		border-collapse: collapse;
		width: 95%;
		margin: 20px auto;
		/*background-color: #2C3845;*/
		background-color: #19222de3;
	}
	
	th,
	td {
		border: 1px solid #2C3845;
		text-align: left;
		padding: 24px;
		font-size: 20px;
		color: white;
	}
	
	td {
		/*background-color: #414d59;*/
		background-color: #1a2c3d9c;
	}
	
	tr:nth-child(even) {
		background-color: #93cad178;
	}
	
	.buttonEditar {
		line-height: 1;
		display: inline-block;
		font-size: 1.2rem;
		text-decoration: none;
		border-radius: 5px;
		color: #fff;
		padding: 8px;
		background-color: #4b908f;
	}
	
	.buttonEditar:hover {
		background-color: #122331;
	}
	/* EDITAR */
	
	.detail {
		background-color: #070718f2;
		width: 100%;
		height: 100%;
		padding: 40px 0;
		position: fixed;
		top: 0;
		left: 0;
		overflow: auto;
		transform: translateX(-100%);
		transition: transform 0.3s ease-out;
	}
	
	.detail.open {
		transform: translateX(0);
	}
	
	.detail-container {
		margin: 0 auto;
		max-width: 500px;
		font-size: 25px;
		line-height: 0.1;
		color: mintcream;
	}
	
	.detail-container dl {
		padding: 20px;
		background: linear-gradient(to bottom, #0074e4, #0083ff0d);
		text-align: center;
	}
	
	.closeDetail {
		background: none;
		padding: 10px;
		color: #fff;
		font-weight: 300;
		border: 1px solid rgba(255, 255, 255, 0.4);
		border-radius: 4px;
		line-height: 1;
		font-size: 1.2rem;
		position: fixed;
		right: 40px;
		top: 20px;
		transition: border 0.3s linear;
	}
	
	.closeDetail:hover,
	.closeDetail:focus {
		background-color: rgba(255, 0, 0, 0.95);
		border: 1px solid rgba(255, 0, 0, 0.95);
	}
	
	.buttonDetailContainer {
		background-color: rgb(5, 6, 45);
		padding: 16px 24px;
		border-radius: 6px;
		width: 100%;
		height: 100%;
		transition: 300ms;
		width: 130px;
		color: azure;
		font-size: 17px;
		margin-top: 30px;
	}
	
	.buttonDetailContainer:hover {
		background-color: rgb(38 41 129);
	}
	</style>
</head>

<body>
	<div id=logo> <img class="logoimg" src="images/star.png" alt="Estrela" width="150" height="130">
		<h1 class="logotext">StarLock</h1> </div> <a class="button" id="addUser">Adicionar Usuário</a>
	<!-- Formulário modal -->
	<div id="userModal" class="modal">
		<div class="modal-content"> <span class="close" id="closeModal">&times;</span>
			<h2>Adicionar Usuário</h2>
			<form id="userForm" action="adicionar_usuario.php" method="post"> Nome:
				<input type="text" name="nome" class="input_nome">
				<br>
				<br>
				<input title="INSERT INTO usuarios (nome) VALUES (var)" type="submit" value="Adicionar" class="button"> </form>
		</div>
	</div>
	<table>
		<tr>
			<th>Nome Usuário</th>
			<th>Última vez</th>
			<th>Chaves Registradas</th>
			<th></th>
		</tr>
		<?php
      require 'database.php';
      $pdo = Database::connect();

      // Cpdigo SQL
      $sql = "SELECT u.id, u.nome, GROUP_CONCAT(c.chave ORDER BY c.id) as chaves, u.ultimo_horario
              FROM usuarios u
              LEFT JOIN chaves c ON u.id = c.usuario_id
              GROUP BY u.id";

      foreach ($pdo->query($sql) as $row) {
        echo "<tr>";
        echo "<td>" . $row['nome'] . "</td>";
        echo "<td>" . ($row['ultimo_horario'] ? $row['ultimo_horario'] : "Sem Registro"). "</td>";
		echo "<td>" . ($row['chaves'] ? $row['chaves'] : "Vazio");
		echo "<td><button class='buttonEditar' data-userid='" . $row['id'] . "'>Editar</button></td>";

        echo "</tr>";
      }

      Database::disconnect();
      ?>
	</table>
	<!-- QUANDO APERTAR NO EDITAR -->
	<div class="detail">
		<div class="detail-container">
			<dl>
				<h2>Opções do Usuário</h2>
				<!-- SETADO PELO getInfo.php PEGO PELO (buttonEditar)-->
				<img class="logoimg" src="https://cdn-icons-png.flaticon.com/512/875/875610.png" alt="Estrela" width="150" height="140">
				<h4>Nome usuário</h4>
				<p id="nomeUsuario"></p>
				<h4>ID usuário</h4>
				<p id="idUsuario"></p>
				<button id="addKey" class="buttonDetailContainer">Adicionar chave</button>
				<button class="buttonDetailContainer">Remover chave</button>
				<button id="removeUser" class="buttonDetailContainer">Remover usuário</button>
			</dl>
		</div>
		<div class="detail-nav">
			<button class="closeDetail"> Fechar </button>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script>
		// Mostrando o formulário modal
		document.getElementById("addUser").addEventListener("click", function() {
			document.getElementById("userModal").style.display = "block";
		});
		// Fechando o formulário modal
		document.getElementById("closeModal").addEventListener("click", function() {
			document.getElementById("userModal").style.display = "none";
		});
		window.onclick = function(event) {
			if(event.target == document.getElementById("userModal")) {
				document.getElementById("userModal").style.display = "none";
			}
		};
		// Quando o botão "Editar" é clicado
		document.querySelectorAll('.buttonEditar').forEach(function(element) {
			element.addEventListener('click', function() {
				// Pegaando o data-userid do botão clicado
				var userId = element.getAttribute('data-userid');
				// Enviando o ID do usuário para o PHP usando AJAX
				$.ajax({
					type: "POST",
					url: "getInfo.php",
					data: {
						userId: userId
					},
					success: function(response) {
						var userData = JSON.parse(response);
						// Acesso separadamente aos dados
						var idUsuario = userData.id;
						var nomeUsuario = userData.nome;
						// Atualizando o HTML com o ID e nome do usuário
						$("#idUsuario").text(idUsuario);
						$("#nomeUsuario").text(nomeUsuario);
					}
				});
				// Mostrando o modal de detalhes
				document.querySelector('.detail').classList.add('open');
				document.documentElement.classList.add('open');
				document.body.classList.add('open');
			});
		});
		// Para fechar o modal de detalhes
		document.querySelector('.closeDetail').addEventListener('click', function() {
			document.querySelector('.detail').classList.remove('open');
			document.documentElement.classList.remove('open');
			document.body.classList.remove('open');
		});
		// Adicionado a chave
		document.getElementById("addKey").addEventListener("click", function() {
			// Pegando o ID do usuário do elemento com o ID "idUsuario"
			var userId = document.getElementById("idUsuario").textContent;
			// Enviando o ID do usuário para o PHP usando AJAX
			$.ajax({
				type: "POST",
				url: "start_learn.php",
				data: {
					userId: userId
				},
				success: function(response) {
					// Lida com a resposta do PHP, se necessário
					alert(response);
					//resetLearn(userId);
					// Voltando para 0 depois de 10s
					setTimeout(function() {
						resetLearn(userId);
					}, 10000); // volta learn=0
				}
			});
		});
		// Função para redefinir learn para 0 aqui
		function resetLearn(userId) {
			$.ajax({
				type: "POST",
				url: "reset_learn.php", // Substitua pelo arquivo PHP apropriado
				data: {
					userId: userId
				},
				success: function(response) {}
			});
		}
		// Removendo usuario
		document.getElementById("removeUser").addEventListener("click", function() {
			var confirmDelete = window.confirm("Tem certeza de que deseja excluir o usuário?");
			if(confirmDelete) {
				// Pega o ID do usuário do elemento com o ID "idUsuario"
				var userId = document.getElementById("idUsuario").textContent;
				// Enviando o ID do usuário para o PHP usando AJAX
				$.ajax({
					type: "POST",
					url: "deletar_usuario.php",
					data: {
						userId: userId
					},
					success: function(response) {
						alert(response);
					}
				});
			}
		});
	</script>
</body>

</html>

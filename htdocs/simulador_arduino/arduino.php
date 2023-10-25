<!DOCTYPE html>
<html>
    <style>
        html{
        background-image: url("images/wallpaper.jpg");
        background-size: cover; /* Isso faz a imagem cobrir 100% da largura e altura da janela do navegador */
        background-attachment: fixed; /* Isso mantém o plano de fundo fixo à medida que você rola a página */
        background-repeat: no-repeat;
        }
        #mydiv {
        position: absolute;
        z-index: 9;
        background-color: #f1f1f1;
        text-align: center;
        border: 1px solid #d3d3d3;
        height: 170px;
        }
        #mydivheader {
        padding: 10px;
        width: 100px;
        cursor: move;
        z-index: 10;
        background-color: #2196F3;
        color: #fff;
        }
        #codigoRFID{
        width: 100px;
        text-align: center;
        }
        #imgArduino {
        position: absolute;
        top: 135px;
        /*237.8*/
        left: -70px;
        }
        #sensor {
        position: absolute;
        top: 262px;
        left: 615px;
        width: 150px;
        height: 90px;
        }
        #trava {
        position: absolute;
        top: 433px;
        left: 682px;
        width: 18px;
        height: 13px;
        background-color: #505142;
        z-index: -1;
        }
        /* LED */
        .led {
        display: flex;
        flex-direction: column;
        align-items: center;
        }
        #ledBoxVermelho{
        position: absolute;
        top: 125px;
        left: 472px;
        z-index: -1;
        }
        .cabecaVermelho {
        width: 1em;
        height: 1.2em;
        border-radius: 5em 5em 0 0;
        /*background-image: linear-gradient(to top right, rgb(211, 211, 211, 0.5) 20%, rgb(211, 211, 211, 0.3) 60%, rgb(211, 211, 211, 0.2));*/
        background-image: linear-gradient(to top right, rgb(255 50 50 / 65%) 20%, rgb(255 50 50 / 65%) 60%, rgb(255 50 50 / 7%));
        }
        .baseVermelho {
        width: 1.3em;
        height: 0.2em;
        border-radius: 1em;
        /*background-image: linear-gradient(to bottom right, rgb(211, 211, 211, 0.5) 20%, rgb(211, 211, 211, 0.3) 60%, rgb(211, 211, 211, 0.2));*/
        background-image: linear-gradient(to top right, rgba(255, 50, 50, 50%) 20%, rgba(255, 50, 50, 0.3) 60%, rgba(255, 50, 50, 0.2)) !important;
        }
        #ledBoxAzul{
        position: absolute;
        top: 125px;
        left: 439.5px;
        z-index: -1;
        }
        .cabecaAzul {
        width: 1em;
        height: 1.2em;
        border-radius: 5em 5em 0 0;
        /*background-image: linear-gradient(to top right, rgb(211, 211, 211, 0.5) 20%, rgb(211, 211, 211, 0.3) 60%, rgb(211, 211, 211, 0.2));*/
        background-image: linear-gradient(to top right, rgb(50 100 255 / 65%) 20%, rgb(22 85 105 / 65%) 60%, rgb(255 50 50 / 7%));
        }
        .baseAzul {
        width: 1.3em;
        height: 0.2em;
        border-radius: 1em;
        /*background-image: linear-gradient(to bottom right, rgb(211, 211, 211, 0.5) 20%, rgb(211, 211, 211, 0.3) 60%, rgb(211, 211, 211, 0.2));*/
        background-image: linear-gradient(to top right, rgb(50 100 255 / 50%) 20%, rgb(22 85 105 / 20%) 60%, rgba(255, 50, 50, 0.2)) !important;
        }
        .pernas {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        flex-direction: row-reverse;
        }
        .perna {
        height: 1em;
        width: 0.1em;
        background-color: gray;
        /*margin: 0.2em;*/
        margin-left: 4px;
        margin-right: 4px;
        }
        .curta {
        height: 0.5em;
        }
        #responseBox{
        padding-left: 510px;
        }
    </style>
    <body>
        <div id="header">
        <h1>Simulando o Arduino</h1>
        <p>Demonstração para trabalho de Banco de dados</p>
        </header>
        <!-- Cartão -->
        <div id="mydiv">
            <div id="mydivheader">Cartão</div>
            <p>UID</p>
            <input id="codigoRFID" maxlength = "8"/>
        </div>
        <!-- Arduíno -->
        <div id="circuito">
        <div id="sensor"></div>
        <!--800px-->
        <img src="images/circuitopng.png" id="imgArduino" alt="Descrição da imagem" width="1000px;" id="myimg" />
        <div id="ledBoxVermelho">
            <div class="led">
                <div class="cabecaVermelho"></div>
                <div class="baseVermelho"></div>
                <div class="pernas">
                    <div class="perna"></div>
                    <div class="perna curta"></div>
                </div>
            </div>
        </div>
        <div id="ledBoxAzul">
            <div class="led">
                <div class="cabecaAzul"></div>
                <div class="baseAzul"></div>
                <div class="pernas">
                    <div class="perna"></div>
                    <div class="perna curta"></div>
                </div>
            </div>
        </div>
        <div id="trava"/>
            <audio id="unlock">
                <source src="sounds/unlock.mp3" type="audio/mpeg">
            </audio>
            <audio id="lock">
                <source src="sounds/lock.mp3" type="audio/mpeg">
            </audio>
        </div>
        <!-- Respostas do SQL -->
        <div id="responseBox">
            <h4 id="responseText">
            <h4>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
			var learn = false;
			codigoRFIDEnviado = true;
			var trava = false;

			function checkStatus() {
				var ledAzul = document.getElementsByClassName("cabecaAzul");
				$.ajax({
					url: 'check_status.php',
					dataType: 'json',
					success: function(data) {
						if (data.length > 0) {
							ledAzul[0].style.backgroundImage = "linear-gradient(to top right, rgb(50 400 255) 20%, rgb(52 600 255) 60%, rgb(50 82 255 / 99%))";
							ledAzul[0].style.boxShadow = "0px 0px 50px 20px #0ff";
							learn = true;
							codigoRFIDEnviado = false;
						} else {
							ledAzul[0].style.backgroundImage = "linear-gradient(to top right, rgb(50 100 255 / 65%) 20%, rgb(22 85 105 / 65%) 60%, rgb(255 50 50 / 7%))";
							ledAzul[0].style.boxShadow = "none";
							learn = false;
							codigoRFIDEnviado = true;
						}
					}
				});
			}

			setInterval(checkStatus, 1000);

			// Drag and Drop do Cartao
			dragElement(document.getElementById("mydiv"));

			function dragElement(elmnt) {
				var pos1 = 0,
					pos2 = 0,
					pos3 = 0,
					pos4 = 0;

				// Pegando elementos
				var targetElement = document.getElementById("myimg");
				var sensorElement = document.getElementById("sensor");
				var codigoRFIDInput = document.getElementById("codigoRFID");

				if (document.getElementById(elmnt.id + "header")) {
					document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
				} else {
					elmnt.onmousedown = dragMouseDown;
				}

				function dragMouseDown(e) {
					e = e || window.event;
					e.preventDefault();

					// Posicao inicial do mouse
					pos3 = e.clientX;
					pos4 = e.clientY;

					document.onmouseup = closeDragElement;

					// Chamada de função quando o mouse é movido
					document.onmousemove = elementDrag;
				}

				function elementDrag(e) {
					e = e || window.event;
					e.preventDefault();

					// Nova posição do mouse
					pos1 = pos3 - e.clientX;
					pos2 = pos4 - e.clientY;
					pos3 = e.clientX;
					pos4 = e.clientY;

					elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
					elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";

					var ledVermelho = document.getElementsByClassName("cabecaVermelho");
					var ledAzul = document.getElementsByClassName("cabecaAzul");

					if (isOverlapping(elmnt, sensorElement)) {
						// Learn ativo (ENVIAR CODIGO UID DO CARTAO)
						if (learn == 1 && !codigoRFIDEnviado && codigoRFID.value.length === 8 && !$("#responseText").text().includes("O codigo UID ja esta em uso pelo usuario com ID")) {
							var codigoRFIDValue = codigoRFID.value;

							// Evitando loop infinito
							codigoRFIDEnviado = true;

							$.ajax({
								type: "POST",
								url: "add_uid.php",
								data: {
									codigoRFID: codigoRFIDValue
								},
								success: function(response) {
									console.log(response);
									$("#responseText").text(response);
								}
							});

							// Piscar led azul
							setTimeout(function() {
								ledAzul[0].style.backgroundImage = "linear-gradient(to top right, rgb(0 4400 255) 20%, rgb(92 6040 255) 60%, rgb(50 82 255 / 99%))";
								ledAzul[0].style.boxShadow = "0px 0px 50px 20px #0ff";
							}, 1000);
						}

						// Lendo cartão para destravar porta
						if (learn !== 1 && codigoRFID.value.length === 8) {
							ledVermelho[0].style.backgroundImage = "linear-gradient(to right top, rgb(255 45 45) 20%, rgb(255 0 0 / 93%) 60%, rgb(255 0 0 / 99%))";
							ledVermelho[0].style.boxShadow = "0px 0px 50px 20px #f00";

							var codigoRFIDValue = codigoRFID.value;

							$.ajax({
								type: "POST",
								url: "check_uid.php",
								data: {
									codigoRFID: codigoRFIDValue
								},
								success: function(response) {
									console.log(response);
									if ($("#responseText").text() !== "Codigo UID inserido com sucesso." && !$("#responseText").text().includes("O codigo UID ja esta em uso pelo usuario com ID")) {
										$("#responseText").text(response);
									}
								}
							});
						}

						// Abrir trava
						if ($("#responseText").text().includes("Aberto")) {
							$("#trava").css("left", "673px");

							if (trava == false) {
								// Som abrindo
								var audio = document.getElementById("unlock");
								audio.play();
								trava = true;
							}
						}
					} else {
						ledVermelho[0].style.backgroundImage = "linear-gradient(to top right, rgb(255 50 50 / 65%) 20%, rgb(255 50 50 / 65%) 60%, rgb(255 50 50 / 7%))";
						ledVermelho[0].style.boxShadow = "none";
						$("#responseText").text("");
						$("#trava").css("left", "682px");

						if (trava == true) {
							// Som fechando
							var audio = document.getElementById("lock");
							audio.play();
						}

						trava = false;
					}
				}

				function closeDragElement() {
					// Parar na posição quando soltar 
					document.onmouseup = null;
					document.onmousemove = null;
				}

				// Função para verificar se o cartão está sobre o RFID
				function isOverlapping(element, target) {
					var rect1 = element.getBoundingClientRect();
					var rect2 = target.getBoundingClientRect();
					return (
						rect1.left < rect2.right &&
						rect1.right > rect2.left &&
						rect1.top < rect2.bottom &&
						rect1.bottom > rect2.top
					);
				}
			}
        </script>
    </body>
</html>
<?php
require "conexao.php";


$result_produtos = $conn->query("SELECT COUNT(*) AS total FROM produtos");
if ($result_produtos) {
    $row = $result_produtos->fetch_assoc();
    $totalProdutos = $row['total'];
};

$result_estoque = $conn->query("SELECT SUM(estoque) AS total_estoque FROM produtos");
if ($result_estoque) {
    $row = $result_estoque->fetch_assoc();
    $totalEstoque = $row['total_estoque'];
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/icone.png">
    <link rel="stylesheet" href="style/index.css">
    <title>Box Manager</title>
</head>
<body>
    <div class="bg-blur" id="bg-blur"><!-- Fundo borrado após abrir a barra lateral --></div>
    <nav id="nav">
        
        <ul>
            <li><h1>BoxManager</h1></li>
            <li><a href="#"><button><img src="img/home.png">Resumo</button></a></li>
            <li><a href="produtos.php"><button><img src="img/produtos.png">Produtos</button></a></li>
            <li><a href="gerenciar.php"><button><img src="img/gerenciar.png">Gerenciar Produtos</button></a></li>
        </ul>    
        <p>Feito por pedrohl-dev. | 2026</p>
    </nav>
    <header>
            <h4>Bem-Vindo, User!</h4>
            <p class="time" id="time">
                <span id="time-horas"></span>
                <span id="dois-pontos">:</span>
                <span id="time-minutos"></span>
            </p>
        <div id="user-btn" class="user-container">
            <img src="https://avatars.githubusercontent.com/u/229395840?v=4" alt="User">
            <p>username</p>
        </div>
    </header>
    
    <div class="container">
        <div class="user-info" id="user-info">
            <img src="https://avatars.githubusercontent.com/u/229395840?v=4">
            <p>username</p>
            <button id="user-close-btn">Fechar</button>
        </div>
        <main>
            <img src="img/seta.png" class="arrow" id="arrow">
            <div class="card-total">
                <h1>Estoque Total</h1>
                <div class="value">
                    <p><?= $totalEstoque ?></p>
                </div>
            </div>

            <div class="card">
                <h1>Produtos em Falta</h1>
                <div class="value">
                    <p>0</p>
                </div>
            </div>

            <div class="card">
                <h1>Produtos em Estoque</h1>
                <div class="value">
                    <p><?= $totalProdutos ?></p>
                </div>
            </div>
            </div>
        </main>
    <script>
        const main = document.querySelector("main");
        const arrow = document.getElementById("arrow");
        const nav = document.querySelector("nav");
        const bgBlur = document.getElementById("bg-blur");

        // Pop-up user
        document.getElementById("user-btn").addEventListener("click", function() {
            document.getElementById("user-info").style.display = "flex";
        });

        document.getElementById("user-close-btn").addEventListener("click", function() {
            document.getElementById("user-info").style.display = "none";
        });

        // Abre e fecha o nav com a seta
        let navVisible = true;
        arrow.addEventListener('click', function() {
            if (navVisible) {
                nav.style.left = '0px';
                arrow.style.left = '250px';
                arrow.style.transform = 'rotate(-180deg)';
                bgBlur.style.opacity = '1';
                bgBlur.style.zIndex = '1';
            } else {
                nav.style.left = '-300px';
                arrow.style.left = '25px';
                arrow.style.transform = 'rotate(0deg)';
                bgBlur.style.opacity = '0';
                bgBlur.style.zIndex = '-1';
            }
            navVisible = !navVisible;
        });

                // Tempo real do relógio no header

        const Time = document.getElementById("time");
        const timeHoras = document.getElementById("time-horas");
        const timeMinutos = document.getElementById("time-minutos");
        const doisPontos = document.getElementById("dois-pontos");

        doisPontos.classList.toggle("anim-piscar");

        function relogioAtual() {
            const agora = new Date();

            const horas = String(agora.getHours()).padStart(2, '0');
            const minutos = String(agora.getMinutes()).padStart(2, '0');

            timeHoras.textContent = horas;
            timeMinutos.textContent = minutos;
        }

        setInterval(relogioAtual, 1000);

    relogioAtual();
    </script>
</body>
</html>
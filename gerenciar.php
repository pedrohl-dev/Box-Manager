<?php
require "conexao.php";

// Buscar produtos
$produtos = $conn->query("SELECT * FROM produtos");

$valor_total = $conn->query("SELECT SUM(valor * estoque) AS total FROM produtos");
$valor_total = $valor_total->fetch_assoc()['total'] ?? 0;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/icone.png">
    <link rel="stylesheet" href="style/geren_prod.css">
    <title>Box Manager - Gerenciar</title>
</head>
<body>
    <div class="bg-blur" id="bg-blur"></div>

    <nav id="nav">
        <ul>
            <li><h1>BoxManager</h1></li>
            <li><a href="index.php"><button><img src="img/home.png">Resumo</button></a></li>
            <li><a href="produtos.php"><button><img src="img/produtos.png">Produtos</button></a></li>
            <li><a href="#"><button><img src="img/gerenciar.png">Gerenciar Produtos</button></a></li>
        </ul>
        <p>Feito por pedrohl-dev. | 2026</p>
    </nav>

    <header>
        <h4>Bem-Vindo, User!</h4>
        <p class="time" id="time">
            <span id="time-horas"></span>
            <span id="dois-pontos" class="anim-piscar">:</span>
            <span id="time-minutos"></span>
        </p>
        <div id="user-btn" class="user-container">
            <img src="https://avatars.githubusercontent.com/u/229395840?v=4">
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

            <div class="cards-container">
                <div class="card">Total Produtos<br><strong><?php echo $produtos->num_rows; ?></strong></div>
                <div class="card">Estoque Baixo<br><strong>--</strong></div>
                <div class="card">Valor Total<br><strong>R$ <?php echo number_format($valor_total, 2, ',', '.'); ?></strong></div>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Valor</th>
                            <th>Estoque</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $produtos->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id_produto'] ?></td>
                            <td><?= $row['nome_produto'] ?></td>
                            <td>R$ <?= number_format($row['valor'],2,',','.') ?></td>
                            <td><?= $row['estoque'] ?></td>
                            <td>
                                <?php
                                if($row['estoque'] > 10) echo '<span class="status ok">●</span>';
                                elseif($row['estoque'] > 0) echo '<span class="status low">●</span>';
                                else echo '<span class="status out">●</span>';
                                ?>
                            </td>
                            <td>
                                <button class="edit">✏️</button>
                                <button class="delete">🗑</button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
<script>
const arrow = document.getElementById("arrow");
const nav = document.querySelector("nav");
const bgBlur = document.getElementById("bg-blur");

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

// RELÓGIO
const timeHoras = document.getElementById("time-horas");
const timeMinutos = document.getElementById("time-minutos");

function relogioAtual() {
    const agora = new Date();
    timeHoras.textContent = String(agora.getHours()).padStart(2,'0');
    timeMinutos.textContent = String(agora.getMinutes()).padStart(2,'0');
}

setInterval(relogioAtual, 1000);
relogioAtual();
</script>

</body>
</html>

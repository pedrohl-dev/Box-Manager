<?php
require "conexao.php";

$categorias = [];
$result = $conn->query("SELECT id_categoria, nome_categoria FROM categorias ORDER BY nome_categoria ASC");
if ($result) {

    while($row = $result->fetch_assoc()) {
        $categorias[$row['id_categoria']] = $row ['nome_categoria'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/icone.png">
    <link rel="stylesheet" href="style/produtos.css">
    <title>Box Manager - Produtos</title>
</head>
<body>
    <div class="bg-blur" id="bg-blur"><!-- Fundo borrado após abrir a barra lateral --></div>
    <nav id="nav">
        
        <ul>
            <li><h1>BoxManager</h1></li>
            <li><a href="index.php"><button><img src="img/home.png">Resumo</button></a></li>
            <li><a href="#"><button><img src="img/produtos.png">Produtos</button></a></li>
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
            <button class="cadastrar">+ Cadastrar Produto</button>
            <div class="produtos-container">
                <table>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Categoria</th>
                            <th>Valor</th>
                            <th>Estoque</th>
                        </tr>
                        <?php
                        $sql = "SELECT * FROM produtos";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["id_produto"] . "</td>";
                                echo "<td>" . $row["nome_produto"] . "</td>";
                                echo "<td>" . $row["descricao"] . "</td>";
                                echo "<td>" . $row["id_categoria"] . "</td>";
                                echo "<td>R$" . number_format($row["valor"], 2, ',', '.') . "</td>";
                                echo "<td>" . $row["estoque"] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>Nenhum produto encontrado.</td></tr>";
                        }
                        ?>
                </table>
        </main>
            <!-- Área Pop-Up -->
    <div class="background" id="background"></div> <!-- Fundo da tela -->

    <div class="alert-popup">
        <p id="alert-msg"></p>
    </div>

    <form action="cadastrar_produto.php" method="post">

        <div class="popup">
                <div class="title">
                    <p>Cadastrar Produto</p>
                    <button class="close-btn" id="close-popup">X</button>
                </div>

                    <div class="box-left">
                        <div class="input-box">
                            <input type="text" id="produto" name="produto" placeholder=" " required>                            <label class="label-text">Produto</label>
                            <label for="produto" class="label-text">Produto</label>
                        </div>

                        <div class="input-box">
                            <input type="number" id="valor" name="valor" placeholder=" " required>
                            <label for="valor" class="label-text">Valor</label>
                        </div>

                        <div class="input-box">
                            <input type="number" id="estoque" name="estoque" placeholder=" " required>
                            <label for="estoque" class="label-text">Estoque</label>
                        </div>
                    
                        <label class="label-text" for="categoria">Categoria</label>
                            <select name="categoria" required>
                                <option selected disabled>Selecione...</option>
                                <?php foreach ($categorias as $id => $nome) :?>
                                    <option value="<?php echo $id; ?>">
                                        <?php echo htmlspecialchars($nome);?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                    <div class="box-right">
                            <textarea type="text" id="desc" name="descricao" placeholder=" " required></textarea>
                            <label class="label-desc" for="desc" class="label-text">Descrição</label> 
                        <button class="popup-button" type="submit">
                            Cadastrar Produto
                        </button>
                    </form>
                </div>
    <!-- Área Pop-Up -->
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

        // Abre o Pop-up
        const cadastrarBtn = document.querySelector(".cadastrar");
        cadastrarBtn.addEventListener("click", function() {
            document.querySelector(".popup").style.display = "flex";
            document.getElementById("background").style.display = "flex";
            
            // Usar setTimeout para ativar a animação após o display ser aplicado
            setTimeout(function() {
                document.querySelector(".popup").classList.add("active");
                document.getElementById("background").classList.add("active");
            }, 10);
        });

        // Fecha o Pop-up clicando no 'X' ou no background
        const xBtn = document.getElementById("close-popup");
        const popUp = document.querySelector(".popup");
        const Background = document.getElementById("background");

        function fecharPopup() {
            popUp.classList.remove("active");
            Background.classList.remove("active");
            
            // Aguardar a transição terminar antes de ocultar
            setTimeout(function() {
                popUp.style.display = "none";
                Background.style.display = "none";
            }, 500);
        }

        xBtn.addEventListener("click", fecharPopup);
        Background.addEventListener("click", fecharPopup);

        // Tempo real do relógio no header

        const Time = document.getElementById("time");
        const timeHoras = document.getElementById("time-horas");
        const timeMinutos = document.getElementById("time-minutos");
        const doisPontos = document.getElementById("dois-pontos");

        doisPontos.classList.add("anim-piscar");

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
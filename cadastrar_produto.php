<?php
    session_start();
    require_once "./conexao.php";

    if ($_SERVER ["REQUEST_METHOD"] === "POST") {
        $produto = trim($_POST['produto']);
        $descricao = trim($_POST['descricao']);
        $valor = ($_POST['valor']);
    }
    
    
    // Verifica se o produto existe no 'estoque_db'
    $verifica = $conn->prepare("SELECT id_produto FROM produtos WHERE nome_produto = ?");
    $verifica->bind_param("s", $produto);
    $verifica->execute();
    $result = $verifica->get_result();

    if ($result->num_rows > 0) {

        echo "<script>alert('Este produto já está cadastrado!')</script>";
        echo '<script>window.history.go(-1);</script>';
        exit;
    } else {
        echo "<script>Produto cadastrado!</script>";
    }

$produto = trim($_POST['produto'] ?? '');
$categoria_id = intval($_POST['categoria'] ?? 0);
$descricao = trim($_POST['descricao'] ?? '');
$valor = intval($_POST['valor'] ?? '');
$estoque = trim($_POST['estoque'] ?? '');

$enviar = $conn->prepare("INSERT INTO produtos (nome_produto, id_categoria, descricao, valor, estoque) VALUES (?, ? ,?, ?, ?)");
$enviar->bind_param("sisis", $produto, $categoria_id, $descricao, $valor, $estoque);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($enviar->execute()) {
        echo
        header("Location: produtos.php?sucesso=1");
        exit;
    } else {
        echo "Erro ao cadastrar: " . $enviar->error;
    }
}

?>
<?php
session_start();
include_once("../includes/conexao.php");

if (isset($_POST["acao"]) && $_POST["acao"] === "cadastrar_usuario") {
    $nome  = $_POST["nome"];
    $cpf   = $_POST["cpf"];
    $senha = $_POST["senha"];
    $tipo  = $_POST["tipo"];

    $stmt = $conn->prepare("INSERT INTO usuario (nome, cpf, senha, tipo) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nome, $cpf, $senha, $tipo);

    if ($stmt->execute()) {
        $_SESSION['msg'] = "<p style='color:green;'>Usuário cadastrado com sucesso!</p>";
    } else {
        $_SESSION['msg'] = "<p style='color:red;'>Erro ao cadastrar usuário: " . $conn->error . "</p>";
    }

    header("Location: ../usuario.php");
    exit;
}

?>
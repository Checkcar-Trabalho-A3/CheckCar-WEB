<?php

session_start();
include_once("../includes/conexao.php");

if (isset($_POST["acao"]) && $_POST["acao"] === "editar_usuario") {
    $id    = intval($_POST["id"]);
    $nome  = $_POST["nome"];
    $cpf   = $_POST["cpf"];
    $senha = $_POST["senha"];
    $tipo  = $_POST["tipo"];

    if (!empty($senha)) {
        $stmt = $conn->prepare("UPDATE usuario SET nome=?, cpf=?, senha=?, tipo=? WHERE id=?");
        $stmt->bind_param("ssssi", $nome, $cpf, $senha, $tipo, $id);
    } else {
        $stmt = $conn->prepare("UPDATE usuario SET nome=?, cpf=?, tipo=? WHERE id=?");
        $stmt->bind_param("sssi", $nome, $cpf, $tipo, $id);
    }

    if ($stmt->execute()) {
        $_SESSION['msg'] = "<p style='color:green;'>Usuário atualizado com sucesso!</p>";
    } else {
        $_SESSION['msg'] = "<p style='color:red;'>Erro ao atualizar usuário: " . $conn->error . "</p>";
    }

    header("Location: ../usuario.php");
    exit;
}
?>
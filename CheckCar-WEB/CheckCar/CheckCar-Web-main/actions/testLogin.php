<?php
session_start();
include_once("../includes/conexao.php");

if (!empty($_POST['cpf']) && !empty($_POST['senha'])) {

    $cpf   = $_POST['cpf'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuario WHERE cpf = ? AND senha = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $cpf, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if ($user['tipo'] !== "ADMIN") {
            $_SESSION['msg'] = "<p style='color:red;'>Acesso negado! Seu usuário não é ADMIN.</p>";
            header("Location: ../index.php");
            exit;
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nome'] = $user['nome'];

        header("Location: ../veiculo.php");
        exit;

    } else {
        $_SESSION['msg'] = "<p style='color:red;'>CPF ou senha incorretos.</p>";
        header("Location: ../index.php");
        exit;
    }
}
else {
    $_SESSION['msg'] = "<p style='color:red;'>Preencha todos os campos.</p>";
    header("Location: ../index.php");
    exit;
}

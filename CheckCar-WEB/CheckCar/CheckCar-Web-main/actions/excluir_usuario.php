<?php
session_start();
include_once("../includes/conexao.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("DELETE FROM usuario WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['msg'] = "<p style='color:green;'>Usuário excluído com sucesso!</p>";
    } else {
        $_SESSION['msg'] = "<p style='color:red;'>Erro ao excluir usuário.</p>";
    }

    header("Location: ../usuario.php");
    exit;
} else {
    $_SESSION['msg'] = "<p style='color:red;'>ID do usuário não informado.</p>";
    header("Location: ../usuario.php");
    exit;
}
?>

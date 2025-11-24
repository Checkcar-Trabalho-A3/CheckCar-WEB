<?php
session_start();
include_once("../includes/conexao.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("DELETE FROM pergunta_checklist WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['msg'] = "<p style='color:green;'>Pergunta excluída com sucesso!</p>";
    } else {
        $_SESSION['msg'] = "<p style='color:red;'>Erro ao excluir pergunta.</p>";
    }

    header("Location: ../perguntas.php");
    exit;
} else {
    $_SESSION['msg'] = "<p style='color:red;'>ID da pergunta não informado.</p>";
    header("Location: ../perguntas.php");
    exit;
}
?>

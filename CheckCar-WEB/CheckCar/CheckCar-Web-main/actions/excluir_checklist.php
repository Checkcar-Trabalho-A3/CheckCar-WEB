<?php
session_start();
include_once("../includes/conexao.php");

if (!isset($_GET['id'])) {
    $_SESSION['msg'] = "<p style='color:red;'>Checklist não informado.</p>";
    header("Location: ../checklist.php");
    exit;
}

$idLote = intval($_GET['id']);

$stmt = $conn->prepare("DELETE FROM resposta_checklist WHERE id_lote = ?");
$stmt->bind_param("i", $idLote);

if ($stmt->execute()) {
    $_SESSION['msg'] = "<p style='color:green;'>Checklist excluído com sucesso!</p>";
} else {
    $_SESSION['msg'] = "<p style='color:red;'>Erro ao excluir checklist: " . $conn->error . "</p>";
}

header("Location: ../checklist.php");
exit;
?>

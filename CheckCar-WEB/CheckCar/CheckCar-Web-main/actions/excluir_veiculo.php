<?php
session_start();
include_once("../includes/conexao.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("DELETE FROM veiculo WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['msg'] = "<p style='color:green;'>Veículo excluído com sucesso!</p>";
    } else {
        $_SESSION['msg'] = "<p style='color:red;'>Erro ao excluir veículo.</p>";
    }

    header("Location: ../veiculo.php");
    exit;
} else {
    $_SESSION['msg'] = "<p style='color:red;'>ID do veículo não informado.</p>";
    header("Location: ../veiculo.php");
    exit;
}
?>

<?php
session_start();
include_once("../includes/conexao.php");

if (isset($_POST["acao"]) && $_POST["acao"] === "cadastrar_pergunta") {
    $pergunta      = $_POST["pergunta"];
    $tipo_veiculo  = $_POST["tipo_veiculo"];
    $tipo_resposta = $_POST["tipo_resposta"];

    $stmt = $conn->prepare("INSERT INTO pergunta_checklist (texto, tipo_veiculo, tipo_resposta) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $pergunta, $tipo_veiculo, $tipo_resposta);

    if ($stmt->execute()) {
        $_SESSION['msg'] = "<p style='color:green;'>Pergunta cadastrada com sucesso!</p>";
    } else {
        $_SESSION['msg'] = "<p style='color:red;'>Erro ao cadastrar pergunta: " . $conn->error . "</p>";
    }

    header("Location: ../perguntas.php");
    exit;
}
?>

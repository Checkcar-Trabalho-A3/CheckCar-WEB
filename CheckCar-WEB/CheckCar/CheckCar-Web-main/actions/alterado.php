<?php
include_once("../includes/conexao.php");

if (isset($_POST["acao"]) && $_POST["acao"] === "editar" && $_POST["tipo"] === "veiculo") {

    $id  = $_POST["id"];
    $placa = $_POST["placa"];
    $modelo = $_POST["modelo"];
    $ano  = $_POST["ano"];
    $tipo_veiculo = $_POST["tipo_veiculo"];

    $stmt = $conn->prepare("UPDATE veiculos 
                            SET placa=?, modelo=?, ano=?, tipo=? 
                            WHERE id=?");

    $stmt->bind_param("ssssi", $placa, $modelo, $ano, $tipo_veiculo, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Veículo atualizado com sucesso!');</script>";
        echo "<script>location.href='../veiculo.php';</script>";
        exit;
    } else {
        echo "<script>alert('Erro ao atualizar o veículo.');</script>";
        echo "<script>location.href='../veiculo.php';</script>";
        exit;
    }
}

if (isset($_POST["acao"]) && $_POST["acao"] === "editar") {

    $id     = $_POST["idUsuario"];
    $nome   = $_POST["nome"];
    $cpf    = $_POST["cpf"];
    $senha  = $_POST["senha"];
    $tipo   = $_POST["tipo"];
    $email  = $_POST["email"];
    $cep    = $_POST["cep"];
    $rua    = $_POST["rua"];
    $bairro = $_POST["bairro"];
    $cidade = $_POST["cidade"];
    $estado = $_POST["estado"];

    // Se a senha não for alterada, não atualiza ela
    if (!empty($senha)) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE usuario SET nome=?, cpf=?, senha=?, tipo=?, email=?, cep=?, rua=?, bairro=?, cidade=?, estado=? WHERE idUsuario=?");
        $stmt->bind_param("ssssssssssi", $nome, $cpf, $senha_hash, $tipo, $email, $cep, $rua, $bairro, $cidade, $estado, $id);
    } else {
        $stmt = $conn->prepare("UPDATE usuario SET nome=?, cpf=?, tipo=?, email=?, cep=?, rua=?, bairro=?, cidade=?, estado=? WHERE id=?");
        $stmt->bind_param("sssssssssi", $nome, $cpf, $tipo, $email, $cep, $rua, $bairro, $cidade, $estado, $id);
    }

    if($stmt->execute()) {
        echo "<script>alert('Dados atualizados com sucesso!');</script>";
        echo "<script>location.href='../usuario.php';</script>";
        exit;
    } else {
        echo "<script>alert('Erro ao atualizar os dados.');</script>";
        echo "<script>location.href='../usuario.php';</script>";
        exit;
    }
}
?>

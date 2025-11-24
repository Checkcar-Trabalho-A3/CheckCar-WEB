<?php
session_start();
include_once("../includes/conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'editar_checklist') {
    $idLote     = intval($_POST['id_lote']);
    $idUsuario  = intval($_POST['id_usuario']);
    $tipo       = $_POST['tipo'];
    $idPergunta = intval($_POST['id_pergunta']);
    $observacao = $_POST['observacao'];
    $placaInput = trim($_POST['placa']);

    $stmtBusca = $conn->prepare("SELECT id, placa, modelo FROM veiculo WHERE placa = ?");
    $stmtBusca->bind_param("s", $placaInput);
    $stmtBusca->execute();
    $resBusca = $stmtBusca->get_result();

    if ($resBusca->num_rows === 0) {
        $_SESSION['msg'] = "<p style='color:red;'>Placa informada não encontrada. Verifique e tente novamente.</p>";
        header("Location: editar_checklist.php?id=" . $idLote);
        exit;
    }

    $veiculoNovo = $resBusca->fetch_assoc();
    $idVeiculoNovo = intval($veiculoNovo['id']);

    $stmtUp = $conn->prepare("UPDATE resposta_checklist 
                                 SET id_usuario = ?, id_veiculo = ?, tipo = ?, id_pergunta = ?, observacao = ?
                               WHERE id_lote = ?");
    $stmtUp->bind_param("iisssi", $idUsuario, $idVeiculoNovo, $tipo, $idPergunta, $observacao, $idLote);

    if ($stmtUp->execute()) {
        $_SESSION['msg'] = "<p style='color:green;'>Checklist atualizado com sucesso!</p>";
    } else {
        $_SESSION['msg'] = "<p style='color:red;'>Erro ao atualizar checklist: " . $conn->error . "</p>";
    }

    header("Location: ../checklist.php");
    exit;
}

if (!isset($_GET['id'])) {
    $_SESSION['msg'] = "<p style='color:red;'>Checklist não informado.</p>";
    header("Location: ../checklist.php");
    exit;
}

$idLote = intval($_GET['id']);
$stmt = $conn->prepare("SELECT r.*, 
                               u.nome AS usuario_nome, 
                               v.placa AS veiculo_placa, 
                               v.modelo AS veiculo_modelo, 
                               p.texto AS pergunta_texto
                          FROM resposta_checklist r
                          JOIN usuario u ON r.id_usuario = u.id
                          JOIN veiculo v ON r.id_veiculo = v.id
                          JOIN pergunta_checklist p ON r.id_pergunta = p.id
                         WHERE r.id_lote = ?
                         LIMIT 1");
$stmt->bind_param("i", $idLote);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['msg'] = "<p style='color:red;'>Checklist não encontrado.</p>";
    header("Location: ../checklist.php");
    exit;
}

$checklist = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Editar Checklist</title>
  <link rel="stylesheet" href="../assets/css/style3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <header>
    <div class="logo-esquerda">
        <img src="../assets/img/logo_novo.png" alt="logo">
    </div>
    <nav>
        <ul>
            <li><a href="../checklist.php">Checklists</a></li>
            <li><a href="../usuario.php">Usuários</a></li>
            <li><a href="../perguntas.php">Perguntas</a></li>
            <li><a href="../veiculo.php">Veículos</a></li>
        </ul>
    </nav>
    <div class="logo-direita">
        <img src="../assets/img/teste.png" alt="icone">
    </div>
  </header>

  <main>
    <h1>EDITAR CHECKLIST</h1>
    <h3>Atualize os dados do checklist</h3>

    <?php 
    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    ?>

    <form action="editar_checklist.php" method="POST" class="form-editar">
      <input type="hidden" name="acao" value="editar_checklist">
      <input type="hidden" name="id_lote" value="<?php echo $checklist['id_lote']; ?>">

      <label for="usuario">Usuário:</label>
      <input type="text" id="usuario" value="<?php echo htmlspecialchars($checklist['usuario_nome']); ?>" disabled>
      <input type="hidden" name="id_usuario" value="<?php echo $checklist['id_usuario']; ?>">

      <label for="placa">Placa:</label>
      <input type="text" name="placa" id="placa" value="<?php echo htmlspecialchars($checklist['veiculo_placa']); ?>" required>

      <label for="veiculo_info">Veículo:</label>
      <input type="text" id="veiculo_info" value="<?php echo htmlspecialchars($checklist['veiculo_modelo']); ?>" disabled>

      <label for="tipo">Tipo:</label>
      <select name="tipo" id="tipo" required>
        <option value="CARRO" <?php if($checklist['tipo']=='CARRO') echo 'selected'; ?>>Carro</option>
        <option value="MOTO" <?php if($checklist['tipo']=='MOTO') echo 'selected'; ?>>Moto</option>
        <option value="CAMINHAO" <?php if($checklist['tipo']=='CAMINHAO') echo 'selected'; ?>>Caminhão</option>
      </select>

      <label for="pergunta">Pergunta:</label>
      <input type="text" id="pergunta" value="<?php echo htmlspecialchars($checklist['pergunta_texto']); ?>" disabled>
      <input type="hidden" name="id_pergunta" value="<?php echo $checklist['id_pergunta']; ?>">

      <label for="observacao">Observação:</label>
      <textarea name="observacao" id="observacao" rows="4" required><?php echo htmlspecialchars($checklist['observacao']); ?></textarea>

      <button type="submit" class="btn-editar">
        <i class="fa fa-save"></i> Salvar Alterações
      </button>
    </form>
  </main>
</body>
</html>

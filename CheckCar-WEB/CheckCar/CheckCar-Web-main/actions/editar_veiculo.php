<?php
session_start();
include_once("../includes/conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'editar_veiculo') {
    $id     = intval($_POST['id']);
    $placa  = $_POST['placa'];
    $tipo   = $_POST['tipo'];
    $marca  = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $ano    = intval($_POST['ano']);

    $stmt = $conn->prepare("UPDATE veiculo SET placa=?, tipo=?, marca=?, modelo=?, ano=? WHERE id=?");
    $stmt->bind_param("ssssii", $placa, $tipo, $marca, $modelo, $ano, $id);

    if ($stmt->execute()) {
        $_SESSION['msg'] = "<p style='color:green;'>Veículo atualizado com sucesso!</p>";
    } else {
        $_SESSION['msg'] = "<p style='color:red;'>Erro ao atualizar veículo: " . $conn->error . "</p>";
    }

    header("Location: ../veiculo.php");
    exit;
}

if (!isset($_GET['id'])) {
    $_SESSION['msg'] = "<p style='color:red;'>Veículo não informado.</p>";
    header("Location: ../veiculo.php");
    exit;
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM veiculo WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $_SESSION['msg'] = "<p style='color:red;'>Veículo não encontrado.</p>";
    header("Location: ../veiculo.php");
    exit;
}

$veiculo = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Editar Veículo</title>
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
    <h1>EDITAR VEÍCULO</h1>
    <h3>Atualize os dados do veículo</h3>

    <?php 
    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    ?>

    <form action="editar_veiculo.php" method="POST" class="form-editar">
      <input type="hidden" name="acao" value="editar_veiculo">
      <input type="hidden" name="id" value="<?php echo $veiculo['id']; ?>">

      <label for="placa">Placa:</label>
      <input type="text" name="placa" id="placa" value="<?php echo htmlspecialchars($veiculo['placa']); ?>" required>

      <label for="tipo">Tipo:</label>
      <input type="text" name="tipo" id="tipo" value="<?php echo htmlspecialchars($veiculo['tipo']); ?>" required>

      <label for="marca">Marca:</label>
      <input type="text" name="marca" id="marca" value="<?php echo htmlspecialchars($veiculo['marca']); ?>" required>

      <label for="modelo">Modelo:</label>
      <input type="text" name="modelo" id="modelo" value="<?php echo htmlspecialchars($veiculo['modelo']); ?>" required>

      <label for="ano">Ano:</label>
      <input type="number" name="ano" id="ano" value="<?php echo htmlspecialchars($veiculo['ano']); ?>" required>

      <button type="submit" class="btn-editar">
        <i class="fa fa-save"></i> Salvar Alterações
      </button>
    </form>
  </main>
</body>
</html>

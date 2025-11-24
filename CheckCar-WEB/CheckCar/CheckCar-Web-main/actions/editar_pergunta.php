<?php
session_start();
include_once("../includes/conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'editar_pergunta') {
    $id            = intval($_POST['id']);
    $texto         = $_POST['pergunta'];
    $tipo_veiculo  = $_POST['tipo_veiculo'];
    $tipo_resposta = $_POST['tipo_resposta'];

    $stmt = $conn->prepare("UPDATE pergunta_checklist SET texto = ?, tipo_veiculo = ?, tipo_resposta = ? WHERE id = ?");
    $stmt->bind_param("sssi", $texto, $tipo_veiculo, $tipo_resposta, $id);

    if ($stmt->execute()) {
        $_SESSION['msg'] = "<p style='color:green;'>Pergunta atualizada com sucesso!</p>";
    } else {
        $_SESSION['msg'] = "<p style='color:red;'>Erro ao atualizar pergunta: " . $conn->error . "</p>";
    }

    header("Location: ../perguntas.php");
    exit;
}

if (!isset($_GET['id'])) {
    $_SESSION['msg'] = "<p style='color:red;'>Pergunta não informada.</p>";
    header("Location: ../perguntas.php");
    exit;
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM pergunta_checklist WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $_SESSION['msg'] = "<p style='color:red;'>Pergunta não encontrada.</p>";
    header("Location: ../perguntas.php");
    exit;
}

$pergunta = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Editar Pergunta</title>
  <link rel="stylesheet" href="../assets/css/style3.css">
</head>
<body>
  <main>
    <h1>Editar Pergunta</h1>
    <form action="editar_pergunta.php" method="POST">
      <input type="hidden" name="acao" value="editar_pergunta">
      <input type="hidden" name="id" value="<?php echo $pergunta['id']; ?>">

      <input type="text" name="pergunta" value="<?php echo htmlspecialchars($pergunta['texto']); ?>" required>

      <label for="tipo_veiculo">Tipo de Veículo:</label>
      <select id="tipo_veiculo" name="tipo_veiculo" required>
        <option value="CARRO" <?php if($pergunta['tipo_veiculo']=='CARRO') echo 'selected'; ?>>Carro</option>
        <option value="MOTO" <?php if($pergunta['tipo_veiculo']=='MOTO') echo 'selected'; ?>>Moto</option>
        <option value="CAMINHAO" <?php if($pergunta['tipo_veiculo']=='CAMINHAO') echo 'selected'; ?>>Caminhão</option>
      </select>

      <label for="tipo_resposta">Tipo de Resposta:</label>
      <select id="tipo_resposta" name="tipo_resposta" required>
        <option value="SELECAO" <?php if($pergunta['tipo_resposta']=='SELECAO') echo 'selected'; ?>>Seleção</option>
        <option value="DESCRITIVA" <?php if($pergunta['tipo_resposta']=='DESCRITIVA') echo 'selected'; ?>>Descritiva</option>
      </select>

      <input type="submit" value="Salvar Alterações">
    </form>
  </main>
</body>
</html>

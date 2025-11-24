<?php
session_start();
include_once("../includes/conexao.php");

// Verifica se recebeu o ID
if (!isset($_GET['id'])) {
    $_SESSION['msg'] = "<p style='color:red;'>Usuário não informado.</p>";
    header("Location: ../usuario.php");
    exit;
}

$id = intval($_GET['id']);

// Busca dados do usuário
$stmt = $conn->prepare("SELECT * FROM usuario WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $_SESSION['msg'] = "<p style='color:red;'>Usuário não encontrado.</p>";
    header("Location: ../usuario.php");
    exit;
}

$usuario = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Editar Usuário</title>
  <link rel="stylesheet" href="../assets/css/style3.css">
</head>
<body>
  <main>
    <h1>Editar Usuário</h1>
    <form action="editar_usuarioSQL.php" method="POST">
      <input type="hidden" name="acao" value="editar_usuario">
      <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">

      <input type="text" name="nome" value="<?php echo $usuario['nome']; ?>" required>
      <input type="text" name="cpf" value="<?php echo $usuario['cpf']; ?>" required>
      <input type="password" name="senha" placeholder="Nova senha (opcional)">
      
      <label for="tipo">Tipo:</label>
      <select id="tipo" name="tipo" required>
        <option value="admin" <?php if($usuario['tipo']=='admin') echo 'selected'; ?>>Admin</option>
        <option value="mecanico" <?php if($usuario['tipo']=='mecanico') echo 'selected'; ?>>Mecânico</option>
      </select>

      <input type="submit" value="Salvar Alterações">
    </form>
  </main>
</body>
</html>

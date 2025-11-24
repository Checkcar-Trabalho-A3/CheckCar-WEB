<?php 
session_start();
include_once('./includes/conexao.php');

$sql = "SELECT * FROM usuario";
$result = $conn->query($sql);

$totalUsuarios = $result->num_rows;
$admins = $conn->query("SELECT COUNT(*) AS total FROM usuario WHERE tipo='admin'")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Usuários</title>
  <link rel="stylesheet" href="./assets/css/style3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <header>
    <div class="logo-esquerda">
      <img src="./assets/img/logo_novo.png" alt="logo">
    </div>

    <nav>
      <ul>
        <li><a href="checklist.php">Checklists</a></li>
        <li><a href="usuario.php">Usuários</a></li>
        <li><a href="perguntas.php">Perguntas</a></li>
        <li><a href="veiculo.php">Veículos</a></li>
      </ul>
    </nav>

    <div class="logo-direita">
      <img src="./assets/img/teste.png" alt="icone">
    </div>
  </header>

  <main>
    <h1>USUÁRIOS</h1>
    <h3>CADASTRE E EDITE PERMISSÕES</h3>
    
    <!-- Cards resumo -->
    <div class="container1">
      <div class="card">
        <img src="./assets/img/perfil.png" alt="Ícone">
        <p>Total de usuários</p>
        <span><?php echo $totalUsuarios; ?></span>
      </div>
      <div class="card">
        <img src="./assets/img/perfil.png" alt="Ícone">
        <p>Administradores</p>
        <span><?php echo $admins; ?></span>
      </div>
    </div>

    <!-- Lista de usuários -->
    <h2 id="lista">Lista de Usuários Cadastrados</h2>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>CPF</th>
          <th>Tipo</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<tr>
              <td>{$row['id']}</td>
              <td>{$row['nome']}</td>
              <td>{$row['cpf']}</td>
              <td>{$row['tipo']}</td>
              <td>
                <a href='./actions/editar_veiculo.php?id={$row['id']}' class='btn-editar'>Editar</a>
                <a href='./actions/excluir_veiculo.php?id={$row['id']}' class='btn-excluir' onclick=\"return confirm('Deseja realmente excluir este usuário?');\"><i class='fa fa-trash'></i></a>
              </td>
            </tr>";
          }
        } else {
          echo "<tr><td colspan='5'>Nenhum usuário cadastrado.</td></tr>";
        }
        ?>
      </tbody>
    </table>

    <!-- Cadastro de usuários -->
    <h2 id="cadastro">Cadastro de Usuários</h2>
    <form action="./actions/salvar_usuario.php" method="POST">
      <input type="hidden" name="acao" value="cadastrar_usuario">
      <input type="text" placeholder="Digite o seu Nome" name="nome" required>
      <input type="text" placeholder="Digite o seu CPF" name="cpf" required>
      <input type="password" placeholder="Digite a sua Senha" name="senha" required>
      
      <label for="tipo">Escolha um Tipo:</label>
      <select id="tipo" name="tipo" required>
        <option value="">Selecione...</option>
        <option value="admin">Admin</option>
        <option value="mecanico">Mecânico</option>
      </select>

      <input type="submit" name="submit" id="submit" value="Cadastrar">
    </form>
  </main>
</body>
</html>

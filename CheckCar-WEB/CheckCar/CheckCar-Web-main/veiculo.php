<?php 
    session_start();
    include_once('./includes/conexao.php');

    $sql = "SELECT * FROM veiculo";
    $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veículos</title>
    <link rel="stylesheet" href="./assets/css/style3.css">
    <!-- Font Awesome para ícones -->
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
        <h1>VEÍCULOS</h1>
        <h3>VEJA OS VEÍCULOS CADASTRADOS EM NOSSO SISTEMA</h3>
        
        <div class="container1">
            <div class="card">
                <img src="./assets/img/perfil.png" alt="Ícone">
                <p>Veículos cadastrados</p>
                <span><?php echo $result->num_rows; ?></span>
            </div>
        </div>

        <h2 id="lista">Lista de Veículos Cadastrados</h2>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Placa</th>
                    <th>Tipo</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Ano</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>".$row['id']."</td>
                                <td>".$row['placa']."</td>
                                <td>".$row['tipo']."</td>
                                <td>".$row['marca']."</td>
                                <td>".$row['modelo']."</td>
                                <td>".$row['ano']."</td>
                                <td>
                                    <a href='./actions/editar_veiculo.php?tipo=veiculo&id=".$row['id']."' class='btn-editar'>
                                        <i class='fa fa-pencil-alt'></i> Editar
                                    </a>
                                    <a href='./actions/excluir_veiculo.php?tipo=veiculo&id=".$row['id']."' class='btn-excluir' 
                                       onclick=\"return confirm('Deseja realmente excluir este veículo?');\">
                                        <i class='fa fa-trash'></i>
                                    </a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Nenhum veículo cadastrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h2 id="cadastro">Cadastro de Veículos</h2>
        <form action="./actions/salvarVeiculo.php" method="POST">
            <input type="hidden" name="acao" value="cadastrar">
            <input type="text" name="placa" id="placa" placeholder="Digite a placa" required>
            <input type="text" name="tipo" id="tipo" placeholder="Digite o tipo" required>
            <input type="text" name="marca" id="marca" placeholder="Digite a marca" required>
            <input type="text" name="modelo" id="modelo" placeholder="Digite o modelo" required>
            <input type="number" name="ano" id="ano" placeholder="Digite o ano" required>
            <input type="submit" name="submit" id="submit" value="Cadastrar">
        </form>
    </main>
</body>
</html>

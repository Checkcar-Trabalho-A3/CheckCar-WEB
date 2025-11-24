<?php 
session_start();
include_once('./includes/conexao.php');

$sql = "SELECT * FROM pergunta_checklist";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perguntas</title>
    <link rel="stylesheet" href="./assets/css/style3.css">
    <!-- Inclusão do Font Awesome para ícones -->
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
        <h1>PERGUNTAS</h1>

        <?php 
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>

        <h3>CADASTRE SUAS PERGUNTAS</h3>

        <div class="container1">
            <div class="card">
                <img src="./assets/img/perfil.png" alt="Ícone">
                <p>Perguntas cadastradas</p>
                <span><?php echo $result->num_rows; ?></span>
            </div>
        </div>

        <h2 id="cadastro">Cadastro de Perguntas</h2>
        <form action="./actions/salvar_pergunta.php" method="POST">
            <input type="hidden" name="acao" value="cadastrar_pergunta">
            <input type="text" name="pergunta" placeholder="Digite a sua pergunta" required>
            
            <select name="tipo_veiculo" required>
                <option value="">Selecione o tipo de veículo</option>
                <option value="CARRO">Carro</option>
                <option value="MOTO">Moto</option>
                <option value="CAMINHAO">Caminhão</option>
            </select>
            
            <select name="tipo_resposta" required>
                <option value="">Selecione o tipo de resposta</option>
                <option value="SELECAO">Seleção</option>
                <option value="DESCRITIVA">Descritiva</option>
            </select>

            <input type="submit" value="Salvar">
        </form>

        <h2 id="lista">Lista de Perguntas Cadastradas</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pergunta</th>
                    <th>Tipo Veículo</th>
                    <th>Tipo Resposta</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>".htmlspecialchars($row['texto'])."</td>
                                <td>{$row['tipo_veiculo']}</td>
                                <td>{$row['tipo_resposta']}</td>
                                <td>
                                    <a href='./actions/editar_pergunta.php?id={$row['id']}' class='btn-editar'>
                                        Editar</a>
                                    </a>
                                    <a href='./actions/excluir_pergunta.php?id={$row['id']}' class='btn-excluir' 
                                       onclick=\"return confirm('Deseja realmente excluir esta pergunta?');\">
                                        <i class='fa fa-trash'></i>
                                    </a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhuma pergunta cadastrada.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>

    <footer>
        <h1></h1>
    </footer>
</body>
</html>

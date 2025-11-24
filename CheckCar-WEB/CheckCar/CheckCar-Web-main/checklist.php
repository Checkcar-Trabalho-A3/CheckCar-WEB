<?php
session_start();
include_once('./includes/conexao.php');

$sql = "SELECT r.id_lote,
               r.id AS resposta_id,
               r.tipo,
               r.observacao,
               u.nome AS usuario_nome,
               v.placa AS veiculo_placa,
               v.modelo AS veiculo_modelo,
               p.texto AS pergunta_texto
        FROM resposta_checklist r
        JOIN usuario u ON r.id_usuario = u.id
        JOIN veiculo v ON r.id_veiculo = v.id
        JOIN pergunta_checklist p ON r.id_pergunta = p.id
        ORDER BY r.id_lote DESC, r.id ASC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checklists</title>
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
        <h1>CHECKLISTS</h1>
        <h3>VISUALIZE OS FORMULÁRIOS REALIZADOS</h3>

        <!-- Mensagens de sessão -->
        <?php 
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>

        <table>
            <thead>
                <tr>
                    <th>Lote</th>
                    <th>ID Resposta</th>
                    <th>Usuário</th>
                    <th>Veículo</th>
                    <th>Placa</th>
                    <th>Tipo</th>
                    <th>Pergunta</th>
                    <th>Observação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id_lote']}</td>
                                <td>{$row['resposta_id']}</td>
                                <td>{$row['usuario_nome']}</td>
                                <td>{$row['veiculo_modelo']}</td>
                                <td>{$row['veiculo_placa']}</td>
                                <td>{$row['tipo']}</td>
                                <td>".htmlspecialchars($row['pergunta_texto'])."</td>
                                <td>".htmlspecialchars($row['observacao'])."</td>
                                <td>
                                    
                                    <a href='./actions/editar_checklist.php?id={$row['id_lote']}' class='btn-editar'>
                                    Editar</a>
                                    </a>
                                    <a href='./actions/excluir_checklist.php?id={$row['id_lote']}' class='btn-excluir' 
                                       onclick=\"return confirm('Deseja realmente excluir este checklist?');\">
                                        <i class='fa fa-trash'></i>
                                    </a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>Nenhum checklist realizado.</td></tr>";
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

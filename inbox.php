<?php
session_start();

if (!isset($_SESSION["usuario_id"]) && !isset($_SESSION["funcionario_id"])) {
    header('location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Foldit:wght@300&family=Oswald:wght@200&family=Quicksand:wght@500&family=Space+Grotesk:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="icon" href=" ./img/logo.png">
    <title>Help Me</title>
</head>

<body>
    <header>
        <div class="head">
            <div class="logo">
                <a href="index.php">
                    <img src="img/logo.png" alt="Logo Help Me">
                </a>
            </div>
            <div class='logout'>
                <a href='#' onclick='confirmLogout()'>Sair</a>
            </div>
            <div class="avatar">
                <img src="img/avatar.png" alt="Avatar">
                <?php

                if (isset($_SESSION['nome_user'])) {
                    echo $_SESSION['nome_user'];
                } else {
                    include 'conexao.php'; // Certifique-se de incluir o arquivo de conexão

                    // Faça uma consulta para obter o nome de usuário com base no usuário logado
                    $usuario_id = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : (isset($_SESSION['funcionario_id']) ? $_SESSION['funcionario_id'] : null);

                    if ($usuario_id) {
                        // Consulta para verificar se o usuário está na tabela funcionario
                        $sql_funcionario = "SELECT nome_user FROM funcionario WHERE id_user = $usuario_id";

                        // Consulta para verificar se o usuário está na tabela usuario
                        $sql_usuario = "SELECT nome_user FROM usuario WHERE id_user = $usuario_id";

                        // Executar a consulta para funcionário
                        $resultado_funcionario = $mysqli->query($sql_funcionario);

                        if ($resultado_funcionario && $resultado_funcionario->num_rows > 0) {
                            $row_funcionario = $resultado_funcionario->fetch_assoc();
                            echo "<p class='name'>" . $row_funcionario['nome_user'] . "</p>";
                        } else {
                            // Executar a consulta para usuário
                            $resultado_usuario = $mysqli->query($sql_usuario);

                            if ($resultado_usuario && $resultado_usuario->num_rows > 0) {
                                $row_usuario = $resultado_usuario->fetch_assoc();
                                echo "<p class='name'>" . $row_usuario['nome_user'] . "</p>";
                            } else {
                                echo "Nome de usuário não encontrado";
                            }
                        }
                    } else {
                        echo "ID de usuário não encontrado na sessão";
                    }
                }
                ?>

            </div>
        </div>
        <div class="navigation">
            <div class="items-bar">
                <div class="item">
                    <a href="contratacoes50.php">Contratações +50</a>
                </div>
                <div class="item">
                    <a href="servicos.php">Serviços</a>
                </div>
            </div>
            <div class="search">
                <form class="formss" action="pesquisa.php" method="post">
                    <input type="image" id="lupa" src="img/lupa.png" alt="lupa">
                    <input name='termo' type="text" placeholder=" O que você precisa?" class="ask">
                </form>
            </div>
            <div class="inbox">
                <a href="inbox.php">
                    <img src="img/inbox.png" alt="">
                </a>
            </div>
        </div>
    </header>
    <main>
        <div class="container" id="solicitacoes-container">
            <?php
            include 'conexao.php';

            // Verificar se o usuário está logado e tem um ID definido
            if (isset($_SESSION['usuario_id']) || isset($_SESSION['funcionario_id'])) {
                $usuario_id = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : $_SESSION['funcionario_id'];

                // Consulta para buscar o email do usuário com base no ID
                $sql_email = "SELECT email_user FROM usuario WHERE id_user = '$usuario_id'";
                $result_email = $mysqli->query($sql_email);

                if ($result_email && $result_email->num_rows > 0) {
                    $row_email = $result_email->fetch_assoc();
                    $email = $row_email['email_user'];

                    // Consulta para buscar as solicitações relacionadas ao email do usuário logado
                    $sql_solicitacoes = "SELECT solicitacao_resposta, solicitacao_mensagem, solicitacao_assunto FROM solicitacao WHERE solicitacao_email = '$email'";
                    $result_solicitacoes = $mysqli->query($sql_solicitacoes);

                    if ($result_solicitacoes->num_rows > 0) {
                        // Exibir as solicitações
                        while ($row = $result_solicitacoes->fetch_assoc()) {
                            echo '<table border="1">';
                            echo '<tr>';
                            echo '<th>Assunto</th>';
                            echo '<th>Mensagem</th>';
                            echo '<th>Resposta</th>';
                            echo '</tr>';

                            echo '<tr>';
                            echo '<td>' . $row["solicitacao_assunto"] . '</td>';
                            echo '<td>' . $row["solicitacao_mensagem"] . '</td>';
                            echo '<td>';
                            if (empty($row["solicitacao_resposta"])) {
                                echo 'Não respondida';
                            } else {
                                echo $row["solicitacao_resposta"];
                            }
                            echo '</td>';
                            echo '</tr>';

                            echo '</table>';
                        }
                    } else {
                        echo "Nenhuma solicitação encontrada para este email.";
                    }
                } else {
                    echo "Email não encontrado para este ID de usuário.";
                }
            } else {
                echo "Usuário não está logado.";
            }

            // Fechar a conexão com o banco de dados
            $mysqli->close();
            ?>

        </div>
    </main>

    <div class="space-footer-inbox">
        <footer>
            <p>&copy; 2024 Help Me. Todos os direitos reservados.</p>
        </footer>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#cac1fe" fill-opacity="1" d="M0,128L80,138.7C160,149,320,171,480,165.3C640,160,800,128,960,117.3C1120,107,1280,117,1360,122.7L1440,128L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
        </svg>
    </div>
    <script>
        function confirmLogout() {
            // Mostra um alerta perguntando se tem certeza que deseja deslogar
            var confirmLogout = confirm("Tem certeza que deseja deslogar da conta?");

            // Se confirmar, redireciona para logout.php
            if (confirmLogout) {
                window.location.href = 'logout.php';
            }
        }
    </script>
</body>

</html>
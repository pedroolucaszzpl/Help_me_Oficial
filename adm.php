<?php
session_start();
include 'conexao.php';
if (!isset($_SESSION["moderador_id"]) && !isset($_SESSION["chefe"])) {
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
    <link rel="stylesheet" href="./css/admain.css">
    <link rel="icon" href=" ./img/logo.png">
    <title>Help Me</title>
</head>

<body>
    <header>
        <div class="head">
            <div class="logo">
                <a href="adm.php">
                    <img src="img/logo.png" alt="Logo Help Me">
                </a>
            </div>
            <div class="avatar">
                <img src="img/moderador.png" alt="Avatar">
                <?php
                if (isset($_SESSION['nome_user'])) {
                    echo $_SESSION['nome_user'];
                } else {
                    include 'conexao.php'; // Certifique-se de incluir o arquivo de conexão

                    // Certifique-se de ter o ID do moderador na sessão
                    $moderador_id = isset($_SESSION['moderador_id']) ? $_SESSION['moderador_id'] : null;

                    if ($moderador_id) {
                        // Consulta para obter o nome do moderador com base no ID
                        $sql_moderador = "SELECT moderador_usuario FROM moderador WHERE moderador_id = $moderador_id";

                        // Executa a consulta
                        $resultado_moderador = $mysqli->query($sql_moderador);

                        if ($resultado_moderador && $resultado_moderador->num_rows > 0) {
                            $row_moderador = $resultado_moderador->fetch_assoc();
                            echo "<p class='name'>Seja bem-vindo moderador(a) " . $row_moderador['moderador_usuario'] . "</p>";
                        } else {
                            echo "Nome de moderador não encontrado";
                        }
                    } else {
                        echo "ID de moderador não encontrado na sessão";
                    }
                }
                ?>
            </div>
            <?php
            // Verifica se a sessão chefe está setada e é verdadeira
            if (isset($_SESSION["chefe"]) && $_SESSION["chefe"] == true) {
                echo '<div class="avatar">';
                echo '    <img src="img/useradd.png" alt="">';
                echo '    <a class="name" href="admcad.php">Cadastre um novo moderador!</a>';
                echo '</div>';
            }
            ?>

            <div class='logout-adm'>
                <a href='#' onclick='confirmLogout()'>Sair</a>
            </div>


        </div>
        </div>
        <div class="navigation">
        <?php
            // Verifica se a sessão chefe está setada e é verdadeira
            if (isset($_SESSION["chefe"]) && $_SESSION["chefe"] == true) {
                echo '<div class="avatar">';
                echo '<a href="lmoderador.php" class="responder">Acessar monitores</a>';
                echo '</div>';
            }
            ?>           
        </div>
        </div>
    </header>
    <main>
        <div class="container">
            <div class="solicita">
                <h1>Solicitações em Andamento</h1>
                <div class="solicitacoes">
                    <?php
                    // Inclui o arquivo de conexão
                    include 'conexao.php';

                    // Consulta SQL para selecionar as 4 solicitações mais antigas com solicitacao_resposta vazia
                    $sql = "SELECT * FROM solicitacao WHERE solicitacao_resposta = '' ORDER BY solicitacao_data ASC LIMIT 4";
                    $result = $mysqli->query($sql);

                    // Exibe as solicitações dentro da div
                    echo '<div class="solicitacoes">';
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Exibe cada solicitação em uma linha única
                            echo '<div class="solicitacao">';
                            echo '<p>' . $row["solicitacao_data"] . '</p>';
                            echo '<p>' . $row["solicitacao_assunto"] . '</p>';
                            echo '<p>' . $row["solicitacao_autor"] . '</p>';
                            // Adiciona um botão para responder à solicitação
                            echo '<a href="responder_solicitacao.php?id=' . $row["solicitacao_id"] . '" class="responder">Responder</a>';
                            echo '</div>'; // Fecha a div da solicitação
                        }
                    } else {
                        echo "Nenhuma solicitação em espera.";
                    }
                    echo '</div>'; // Fecha a div das solicitações

                    // Fecha a conexão com o banco de dados
                    $mysqli->close();
                    ?>
                </div>
            </div>
            <div class="solicita">
                <h1>Perfis de profissionais</h1>
                <p>Verifique profissionais cadastrados</p>
                <div class="funcionarios">
                    <?php
                    include 'conexao.php'; // Certifique-se de incluir o arquivo de conexão

                    // Consulta SQL para selecionar os funcionários cadastrados
                    $sql_funcionarios = "SELECT * FROM funcionario";

                    $resultado_funcionarios = $mysqli->query($sql_funcionarios);

                    if ($resultado_funcionarios->num_rows > 0) {
                        while ($row_funcionario = $resultado_funcionarios->fetch_assoc()) {
                            echo '<div class="person">';
                            echo '<img src="img/avatar.png" alt="Avatar">';
                            echo '<p class="nome">' . $row_funcionario['nome_user'] . '</p>';
                            echo '<p class="desc">' . $row_funcionario['funcao_user'] . '</p>';
                            // echo '<a href="perfil_usuario.php?id=' . $row_funcionario['id_user'] . '" class="responder">Visualizar</a>';
                            echo '</div>';
                        }
                    } else {
                        echo "Nenhum funcionário cadastrado.";
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>
    <div class="space-footer">
        <footer>
            <p>&copy; 2024 Help Me. Todos os direitos reservados.</p>
        </footer>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#cac1fe" fill-opacity="1" d="M0,224L48,229.3C96,235,192,245,288,229.3C384,213,480,171,576,149.3C672,128,768,128,864,128C960,128,1056,128,1152,106.7C1248,85,1344,43,1392,21.3L1440,0L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
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
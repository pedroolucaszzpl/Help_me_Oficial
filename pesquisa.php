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
                    <a href="">Contratações +50</a>
                </div>
                <div class="item">
                    <a href="">Serviços</a>
                </div>
                <div class="item">
                    <a href="">Histórico</a>
                </div>
                <div class="item">
                    <a href="">Salvos</a>
                </div>
            </div>
            <div class="search">
                <form class="formss" action="pesquisa.php" method="post">
                    <input type="image" id="lupa" src="img/lupa.png" alt="lupa">
                    <input name='termo' type="text" placeholder=" O que você precisa?" class="ask">
                </form>
            </div>
        </div>
    </header>
    <main>
        <div class="title">
            <h1>Resultados da Pesquisa</h1>
            <div class="linha"></div>
        </div>
        <div>
            <?php
            include 'conexao.php'; // Inclui o arquivo de conexão

            // Verifica se o formulário foi submetido e se o campo "termo" não está vazio
            if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['termo'])) {
                $pesquisa = $mysqli->real_escape_string($_POST['termo']);
                $sql_code = "SELECT nome_user, funcao_user FROM funcionario WHERE nome_user LIKE '%$pesquisa%' OR funcao_user LIKE '%$pesquisa%'";
                $resultado = $mysqli->query($sql_code);

                if ($resultado) {
                    if ($resultado->num_rows > 0) {
                        while ($row = $resultado->fetch_assoc()) {
                            echo "<div class='person'>";
                            echo "<img class='searchimg' src='img/avatar.png'>"; // Imagem de avatar temporária
                            echo "<p class='nome'>" . $row["nome_user"] . "</p>";
                            echo "<p class='desc'>" . $row["funcao_user"] . "</p>";
                            echo "</div>";
                        }
                    } else {
                        echo "Nenhum resultado encontrado.";
                    }
                } else {
                    die("Erro na consulta: " . $mysqli->error);
                }
            } else {
                echo "Digite um termo de pesquisa.";
            }

            // Fecha a conexão com o banco de dados
            $mysqli->close();
            ?>
        </div>
    </main>

</body>

</html>
<?php
session_start();

if (!isset($_SESSION["usuario_id"]) && !isset($_SESSION["funcionario_id"])) {
    header('location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href='.//css/sobreNos.css'>
    <link rel="icon" href="./img/logo.png">
    <link rel="stylesheet" href="./css/main.css">
    <title>Help Me</title>
    <style>
        #video2 {
            width: 100%;
            /* Ajuste a largura conforme necessário */
            margin: 0 auto;
            /* Isso centraliza o elemento */
        }

        video {
            margin-bottom: 50px;
            width: 100%;
            height: auto;
            /* Isso mantém a proporção do vídeo */
        }
    </style>
</head>

<body>
<style>
        #cont-b {
            display: none;
        }
    </style>
</head>

<body>
<header>
        <div class="head">
            <div class="logo">
                <a href="main.php">
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
                    <a href="main.php">Página Inicial</a>
                </div>
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
    <!-- nav  padrão -->
    <div id="conteudo">
        <div>
            <h1>Contratações +50</h1>
            <h2>Plataforma para Solicitação de Serviços</h2>
            <h3>As contratações de profissionais com mais de 50 anos têm se destacado como uma tendência crescente em nossa  empresa. Esses profissionais trazem consigo uma riqueza de experiência  acumuladas ao longo de suas carreiras, o que pode ser inestimável para as organizações.</h3>
            <div id="video2">
                <video autoplay loop muted controls>
                    <source src="img/help.mp4" type="video/mp4">
                    Seu navegador não suporta o elemento de vídeo.
                </video>
            </div>
        </div>
        <div class="profissionais">
            <div class="title">
                <h1>Profissionais da sua região</h1>
                <div class="linha"></div>
            </div>
            <div class="perfis">
                <?php
                include 'conexao.php';

                $sql = "SELECT nome_user, funcao_user, nascimento_user FROM funcionario WHERE TIMESTAMPDIFF(YEAR, nascimento_user, CURDATE()) > 50";
                $result = $mysqli->query($sql);

                if ($result->num_rows > 0) {
                    // Loop pelos resultados da consulta
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <div class="person">
                            <div>
                                <img src="img/avatar.png" alt="">
                            </div>
                            <p class="nome"><?php echo $row["nome_user"]; ?></p>
                            <p class="desc"><?php echo $row["funcao_user"]; ?></p>
                            <p class="idade"><?php echo "Idade: " . (date('Y') - date('Y', strtotime($row["nascimento_user"]))); ?></p>
                        </div>
                <?php
                    }
                } else {
                    echo "Nenhum funcionário com mais de 50 anos encontrado.";
                }

                // Fecha a conexão com o banco de dados
                $mysqli->close();
                ?>

            </div>
        </div>
    </div>
    <div class="space-footer">
        <footer>
            <p>&copy; 2024 Help Me. Todos os direitos reservados.</p>
        </footer>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#cac1fe" fill-opacity="1" d="M0,128L80,138.7C160,149,320,171,480,165.3C640,160,800,128,960,117.3C1120,107,1280,117,1360,122.7L1440,128L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
        </svg>
    </div>
</body>

</html>
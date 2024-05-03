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
                    <a href="contratacoes50.php">Contratações +50</a>
                </div>
                <div class="item">
                    <a href="">Serviços</a>
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
        <div class="content">
            <div class="cont">
                <div>
                    <p class="title-container">Serviços Cadastrados na Help Me!</p>
                    <p class="desc">&nbsp;&nbsp;&nbsp;&nbsp;A Help Me oferece serviços rápidos e eficientes, garantindo soluções de qualidade sem complicações para seus clientes.</p>
                    <button id="saiba_mais">Saiba Mais</button>
                </div>

                <div>
                    <img class="distraction" src="img/geoServ.jpeg" alt="">
                </div>
            </div>

            <div id="cont-b" class="cont-b">
                <?php
                include 'conexao.php';

                // Consulta SQL para selecionar funções dos funcionários dos setores doméstico e empresarial
                $sqlDomestico = "SELECT DISTINCT nome_profissao FROM profissao WHERE setor_profissao = 'domestico'";
                $resultDomestico = $mysqli->query($sqlDomestico);

                $sqlEmpresarial = "SELECT DISTINCT nome_profissao FROM profissao WHERE setor_profissao = 'empresarial'";
                $resultEmpresarial = $mysqli->query($sqlEmpresarial);
                ?>
                <div class="title">
                    <h1>Serviços Domésticos</h1>
                </div>
                <div class="desc-2">
                    <p> Os serviços domésticos abrangem tarefas como limpeza, organização, preparo de refeições e cuidado
                        com plantas, realizados por profissionais comprometidos em criar ambientes acolhedores e saudáveis
                        para o bem-estar de todos que compartilham o lar, contribuindo para a qualidade de vida e a harmonia
                        do espaço.</p>
                    <img src="img/domesticos.png" alt="">
                </div>
                <div class="categoriasD">
                    <?php
                    if ($resultDomestico->num_rows > 0) {
                        while ($row = $resultDomestico->fetch_assoc()) {
                    ?>
                            <div class='profissao'>
                                <p class="funcao"><?php echo $row["nome_profissao"]; ?></p>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<p>Nenhuma função de serviços domésticos encontrada.</p>";
                    }
                    ?>
                </div>

                <div class="title">
                    <h1>Serviços Empresariais</h1>
                </div>
                <div class="desc-2">
                    <p> Serviços empresariais são atividades fundamentais para empresas, incluindo consultoria,
                        desenvolvimento de software, marketing digital e contabilidade. Consultores em gestão
                        aprimoram operações, software personalizado atende a necessidades específicas, marketing
                        digital promove visibilidade e contabilidade mantém a organização financeira. Esses serviços
                        impulsionam o sucesso e a eficiência empresarial.</p>
                    <img src="img/empresarial.avif" alt="">
                </div>
                <div class="categoriasE">
                    <?php
                    if ($resultEmpresarial->num_rows > 0) {
                        while ($row = $resultEmpresarial->fetch_assoc()) {
                    ?>
                            <div class='profissao'>
                                <p class="funcao"><?php echo $row["nome_profissao"]; ?></p>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<p>Nenhuma função de serviços empresariais encontrada.</p>";
                    }
                    ?>
                </div>

                <?php
                // Fecha a conexão com o banco de dados
                $mysqli->close();
                ?>
            </div>
        </div>
    </main>
    <div class="space-footer">
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

        document.getElementById("saiba_mais").addEventListener("click", function() {
            var elemento = document.getElementById("cont-b");
            if (elemento.style.display === "none") {
                elemento.style.display = "block";
            } else {
                elemento.style.display = "none";
            }
        });
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href='.//css/sobreNos.css'>
    <link rel="icon" href="./img/logo.png">
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
    <!-- nav  padrão -->
    <header>
        <nav>
            <div class="contate">
                <a href="index.php">
                    <img src="img/logo.png" alt="Logo Help Me">
                </a>
                <a href="ajuda.php">Fale Conosco!</a>
                <a href="sobrenos.php">Sobre</a>
            </div>
            <div class="efetualog">
                <img src="img/avatar.png" alt="Avatar">
                <a href="logout.php">Sair</a>
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
    <!-- footer padrão -->
    <footer>
        <p>&copy; 2024 Help Me. Todos os direitos reservados.</p>
    </footer>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#cac1f3" fill-opacity="1" d="M0,256L48,250.7C96,245,192,235,288,224C384,213,480,203,576,192C672,181,768,171,864,176C960,181,1056,203,1152,197.3C1248,192,1344,160,1392,144L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
    </svg>
    
    <!-- footer padrão -->
</body>

</html>
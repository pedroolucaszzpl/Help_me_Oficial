
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Foldit:wght@300&family=Oswald:wght@200&family=Quicksand:wght@500&family=Space+Grotesk:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/sobreNos.css">
    <link rel="icon" href=" ./img/logo.png">
    <title>Help Me - Fale Conosco</title>
    <title>Document</title>
</head>

<body class="page-ajuda">
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
                <a href="logar.php">Login</a>
            </div>
        </div>
    </header>
    <div class="conteudo">
        <div class="container content">
            <div class="title">
                <h1>Olá, nós somos a equipe de suporte da Help Me!</h1>
                <p>Como podemos te ajudar?</p>
            </div>
            <div class="session">
                <div class="s1">
                    <img src="img/icon_help.png" alt="Icon">
                    <p>Serviços Domésticos</p>
                </div>
                <div class="s1">
                    <img src="img/icon_help.png" alt="Icon">
                    <p>Como agendar um serviço?</p>
                </div>
                <div class="s1">
                    <img src="img/icon_help.png" alt="Icon">
                    <p>Onde encontrar contratos prontos?</p>
                </div>
                <div class="s1">
                    <img src="img/icon_help.png" alt="Icon">
                    <p>Onde acessar dados da empresa contratante?</p>
                </div>
                <div class="s1">
                    <img src="img/icon_help.png" alt="Icon">
                    <p>Como aumentar a alcançabilidade do meu perfil?</p>
                </div>
            </div>
            <div class="title-doubt" onclick="openModal()">
                <h2>Deixe uma dúvida</h2>
            </div>
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <div class="duvida"><!-- Formulário de envio de pergunta -->
                    <div class="form-container">
                        <form class="duvida form-duvida" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <span class="close" onclick="closeModal()">&times;</span>
                            <div class="logo-solicitacao"><img src="img/logo.png" alt=""></div>
                                <div class="linha"></div>
                                <h2 class="title-duvida">Solicite sua ajuda!</h2>
                                <label for="assunto">Assunto:</label><br>
                                <input type="text" id="assunto" name="assunto" required><br><br>

                                <label for="mensagem">Mensagem:</label><br>
                                <textarea id="mensagem" name="mensagem" rows="4" cols="50" required></textarea><br><br>

                                <label for="autor">Seu Nome:</label><br>
                                <input type="text" id="autor" name="autor" required><br><br>

                                <label for="email">Seu Email:</label><br>
                                <input type="text" id="email" name="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"><br>
                                <div class="botao">
                                    <input type="submit" value="Enviar">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
    <div class="space-footer">
        <footer>
            <p>&copy; 2024 Help Me. Todos os direitos reservados.</p>
        </footer>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#cac1f3" fill-opacity="1" d="M0,256L48,250.7C96,245,192,235,288,224C384,213,480,203,576,192C672,181,768,171,864,176C960,181,1056,203,1152,197.3C1248,192,1344,160,1392,144L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
    <script>
        
        function openModal() {
            var modal = document.getElementById('myModal');
            modal.style.display = 'block';
        }

        function closeModal() {
            var modal = document.getElementById('myModal');
            modal.style.display = 'none';
        }
        
    </script>

<?php
// Inicializa a variável de mensagem
$msg = "";

// Inclui o arquivo de conexão com o banco de dados
include 'conexao.php';

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepara e executa a inserção da solicitação no banco de dados
    $assunto = $_POST['assunto'];
    $mensagem = $_POST['mensagem'];
    $autor = $_POST['autor'];
    $email = $_POST['email'];
    
    // Verifica se o e-mail tem o "@" obrigatório
    if (strpos($email, '@') === false) {
        echo "<script>alert('O e-mail deve conter o caractere \'@\'!');</script>";
    } else {
        // Verifica se o e-mail já existe no banco de dados
        $query = "SELECT * FROM solicitacao WHERE solicitacao_email = '$email'";
        $result = $mysqli->query($query);

        if ($result) { // Check if the query was successful
            if ($result->num_rows > 0) {
                echo "<script>alert('Este e-mail já está cadastrado!');</script>";
            } else {
                // Insere os dados no banco de dados
                $sql = "INSERT INTO solicitacao (solicitacao_assunto, solicitacao_mensagem, solicitacao_autor, solicitacao_email) VALUES ('$assunto', '$mensagem', '$autor', '$email')";

                if ($mysqli->query($sql) === TRUE) {
                    $msg = "Sua solicitação foi enviada com sucesso!";
                } else {
                    $msg = "Erro ao enviar sua solicitação: " . $mysqli->error;
                }
            }
        } else {
            // Handle query error
            echo "Erro na consulta: " . $mysqli->error;
        }
    }
}

// Fecha a conexão
$mysqli->close();
?>
    
</body>
</html>
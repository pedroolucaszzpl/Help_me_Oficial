<?php
session_start();

if (!isset($_SESSION["moderador_id"]) && !isset($_SESSION["moderador_id"])) {
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
<div class="cad">
    <img src="img/useradd.png" alt="">
    <p class="name"><a href="admcad.php">Cadastre um novo moderador!</a></p>
</div>
<div class='logout'>
    <a href='#' onclick='confirmLogout()'>Sair</a>
</div>


</div>
        </div>
        <div class="navigation">
            
            </div>
        </div>
    </header>
    <main>
        <div class="container">
            
        </div>
    </main>
    <div class="space-footer">
        <footer>
            <p>&copy; 2024 Help Me. Todos os direitos reservados.</p>
        </footer>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#cac1f3" fill-opacity="1" d="M0,256L48,250.7C96,245,192,235,288,224C384,213,480,203,576,192C672,181,768,171,864,176C960,181,1056,203,1152,197.3C1248,192,1344,160,1392,144L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
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
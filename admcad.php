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
    <link rel="stylesheet" href='css/cad.css'>
    <link rel="icon" href=" ./img/logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Foldit:wght@300&family=Oswald:wght@200&family=Quicksand:wght@500&family=Space+Grotesk:wght@300&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>Help Me</title>
</head>

<body>
    <div class='content'>
        <div class='logo'>
            <img id=id-img src="img/logo.png">
        </div>
        <div class="login">
            <form method="post" action="" class="class-alinhar">
                <div class='cliente_cad'>
                    <label for="nome">Nome:</label></br>
                    <input type="text" id="nome" name="moderador_usuario" required>
                </div>
                <div class='cliente_cad'>
                    <label for="email">E-mail:</label> </br>
                    <input type="email" id="email" name="moderador_email" required>
                </div>

                <div class='cliente_cad'>
                    <label for="senha">Senha:</label></br>
                    <input type="password" id="senha" name="moderador_senha" required>
                </div>

                <div id="linhas">
                    <div class="line"></div>
                </div>
                <input id="botao_login" type="submit" value="Cadastrar">
            </form>
        </div>
    </div>
    <?php
$mysqli = new mysqli("localhost", "root", "", "db_helpme");

if ($mysqli->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['moderador_usuario'];
    $email = $_POST['moderador_email'];
    $senha = $_POST['moderador_senha'];
    
    // Hash da senha usando password_hash()
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO moderador (moderador_usuario, moderador_email, moderador_senha) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt-> bind_param("sss", $nome, $email, $senha_hash);
    $stmt->execute();

    // Verifica se a inserção foi bem-sucedida
    if ($stmt->affected_rows > 0) {
        // Cadastro bem-sucedido, exibe o alerta do SweetAlert
        echo '<script>
        Swal.fire({
            icon: "success",
            title: "Cadastro realizado com sucesso!",
            showConfirmButton: false,
            timer: 1500
        }).then(() => {
            window.location.href = "adm.php";
        });
        </script>';
    } else {
        // Caso contrário, exibe uma mensagem de erro
        echo '<script>alert("Erro ao cadastrar. Tente novamente mais tarde.");</script>';
    }

    $stmt->close();
}

$mysqli->close();
?>


</body>

</html>

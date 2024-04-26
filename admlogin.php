<?php
include './conexao.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Suponhamos que você já tenha recebido o nome de usuário e senha do usuário
    $email = $_POST['nome_login']; // Suponha que esses valores sejam recebidos de um formulário HTML
    $password = $_POST['senha_login'];

    // Consulta o banco de dados para verificar as credenciais do moderador
    $query_moderador = "SELECT * FROM moderador WHERE moderador_email = '$email'";
    $result_moderador = $mysqli->query($query_moderador);

    if ($result_moderador->num_rows == 1) {
        $row_moderador = $result_moderador->fetch_assoc();
        $db_password = $row_moderador['moderador_senha'];
        $_SESSION["moderador_id"] = $row_moderador['moderador_id'];

        // Verifica se a senha fornecida corresponde à senha no banco de dados
        if (password_verify($password, $db_password)) {
            // Senha válida, redireciona para a página de administrador
            header('location:adm.php');
            exit();
        } else {
            // Senha incorreta ou credenciais inválidas
            echo "Credenciais inválidas";
        }
    } else {
        // Senha incorreta ou credenciais inválidas
        echo "Credenciais inválidas errada";
    }
} else {
    echo 'Dados não inseridos';
}
?>

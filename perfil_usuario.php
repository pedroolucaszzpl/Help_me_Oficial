<?php
// Inclua o arquivo de conexão
include 'conexao.php';

// Verifique se o ID do usuário está presente na URL
if (isset($_GET['id'])) {
    $id_user = $_GET['id'];

    // Consulta SQL para obter as informações do usuário com base no ID
    $sql = "SELECT * FROM funcionario WHERE id_user = $id_user";
    $resultado = $mysqli->query($sql);

    if ($resultado->num_rows > 0) {
        $row_usuario = $resultado->fetch_assoc();
        // Exiba as informações do perfil do usuário
        echo '<div class="perfil-usuario">';
        echo '<img src="img/avatar.png" alt="Avatar">';
        echo '<p class="nome">' . $row_usuario['nome_user'] . '</p>';
        echo '<p class="funcao">' . $row_usuario['funcao_user'] . '</p>';
        // Exiba outras informações do perfil conforme necessário
        echo '</div>';
    } else {
        echo "Usuário não encontrado.";
    }
} else {
    echo "ID do usuário não especificado.";
}
?>

<link rel="stylesheet" href="css/solicita.css">
<?php
session_start();
include 'conexao.php';

// Verifica se o usuário está logado como moderador
if (!isset($_SESSION["moderador_id"])) {
    header('location: index.php');
    exit();
}

// Verifica se o formulário foi submetido para processar a resposta
if (isset($_POST['submit'])) {
    // Obtém os dados do formulário
    $id_solicitacao = $_POST['id_solicitacao'];
    $resposta = $_POST['resposta'];
    $moderador_id = $_POST['moderador_id'];

    // Verifica se a resposta está vazia
    if (empty($resposta)) {
        // echo '<script>';
        // echo 'alert("Por favor, digite uma resposta!");';
        // echo 'window.location.href = "responder_solicitacao.php?id=' . $id_solicitacao . '";'; // Redireciona para a mesma página
        // echo '</script>';
    } else {
        // Atualiza a tabela de solicitação com a resposta e o ID do moderador
        $sql_update = "UPDATE solicitacao SET solicitacao_resposta = '$resposta', id_moderador = $moderador_id WHERE solicitacao_id = $id_solicitacao";

        if ($mysqli->query($sql_update) === TRUE) {
            echo '<script>';
            echo 'alert("Resposta enviada com sucesso!");';
            echo 'window.location.href = "adm.php";'; // Redireciona para adm.php
            echo '</script>';
        } else {
            echo "Erro ao enviar a resposta: " . $mysqli->error;
        }
    }
} else {
    // Verifica se o ID da solicitação foi enviado via GET
    if (isset($_GET['id'])) {
        $id_solicitacao = $_GET['id'];

        // Consulta SQL para obter os dados da solicitação com base no ID
        $sql_solicitacao = "SELECT * FROM solicitacao WHERE solicitacao_id = $id_solicitacao";
        $resultado_solicitacao = $mysqli->query($sql_solicitacao);

        if ($resultado_solicitacao->num_rows > 0) {
            $row_solicitacao = $resultado_solicitacao->fetch_assoc();
            // Exibe os detalhes da solicitação
            echo '<div class= "content">';
            echo '<div class="solicitacao">';
            echo '<p>Data da Solicitação: ' . $row_solicitacao["solicitacao_data"] . '</p>';
            echo '<p>Assunto: ' . $row_solicitacao["solicitacao_assunto"] . '</p>';
            echo '<p>Autor: ' . $row_solicitacao["solicitacao_autor"] . '</p>';
            echo '<p>Mensagem: ' . $row_solicitacao["solicitacao_mensagem"] . '</p>';
            echo '</div>';

            // Formulário para responder à solicitação
            echo '<form action="responder_solicitacao.php" method="POST">';
            echo '<input type="hidden" name="id_solicitacao" value="' . $id_solicitacao . '">';
            echo '<input type="hidden" name="moderador_id" value="' . $_SESSION['moderador_id'] . '">';
            echo '<textarea name="resposta" placeholder="Digite sua resposta aqui" required></textarea>';
            echo '<button type="submit" name="submit"  class="btn-responder" >Responder</button>';
            echo '</form>';

            // Botão de retorno
            echo '<a href="adm.php" class="btn-return">Retornar</a>';
            echo  '</div>';
        } else {
            echo "Solicitação não encontrada.";
        }
    } else {
        echo "ID da solicitação não especificado.";
    }
}

// Fecha a conexão com o banco de dados
$mysqli->close();
?>
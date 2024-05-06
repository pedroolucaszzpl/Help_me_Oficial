<?php
include './conexao.php';
session_start();

if (isset($_SESSION["chefe"]) && $_SESSION["chefe"] == true) {
    // Consulta o banco de dados para obter os dados dos moderadores
    $query_moderadores = "SELECT moderador_id, moderador_email, moderador_usuario FROM moderador";
    $result_moderadores = $mysqli->query($query_moderadores);
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Foldit:wght@300&family=Oswald:wght@200&family=Quicksand:wght@500&family=Space+Grotesk:wght@300&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./css/admain.css">
        <link rel="icon" href=" ./img/logo.png">
        <title>Help Me</title>
    </head>

    <body>
        <header>
            <div class="head">
                <div class="logo">
                    <a href="adm.php">
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
                </div>
                <?php
                // Verifica se a sessão chefe está setada e é verdadeira
                if (isset($_SESSION["chefe"]) && $_SESSION["chefe"] == true) {
                    echo '<div class="avatar">';
                    echo '    <img src="img/useradd.png" alt="">';
                    echo '    <a class="name" href="admcad.php">Cadastre um novo moderador!</a>';
                    echo '</div>';
                }
                ?>

                <div class='logout-adm'>
                    <a href='#' onclick='confirmLogout()'>Sair</a>
                </div>


            </div>
            </div>
            <div class="navigation">

            </div>
            </div>
        </header>
        <main>
            <?php
            include './conexao.php';

            if (isset($_SESSION["chefe"]) && $_SESSION["chefe"] == true) {
                // Consulta o banco de dados para obter os dados dos moderadores
                $query_moderadores = "SELECT moderador_id, moderador_email, moderador_usuario FROM moderador";
                $result_moderadores = $mysqli->query($query_moderadores);
            }
            ?>

            <div class="container-lista">
                <table>
                    <tr>
                        <th>Email</th>
                        <th>Nome</th>
                        <th>Ação</th>
                    </tr>
                    <?php
                    if ($result_moderadores->num_rows > 0) {
                        while ($row = $result_moderadores->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['moderador_email'] . '</td>';
                            echo '<td>' . $row['moderador_usuario'] . '</td>';
                            echo '<td class="action"><form method="post"><input type="hidden" name="id_moderador" value="' . $row['moderador_id'] . '"><button type="submit" name="banir_moderador" class="banir" onclick="return confirmBan()">Banir</button></form></td>'; // Formulário para banir o moderador
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="3">Nenhum moderador encontrado.</td></tr>';
                    }
                    ?>
                </table>
            </div>
        </main>
        <div class="space-footer-lista">
            <footer>
                <p>&copy; 2024 Help Me. Todos os direitos reservados.</p>
            </footer>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#cac1fe" fill-opacity="1" d="M0,224L48,229.3C96,235,192,245,288,229.3C384,213,480,171,576,149.3C672,128,768,128,864,128C960,128,1056,128,1152,106.7C1248,85,1344,43,1392,21.3L1440,0L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
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

            function confirmBan() {
                // Mostra um alerta perguntando se tem certeza que deseja banir o moderador
                var confirmBan = confirm("Tem certeza que deseja banir permanentemente este moderador?");

                // Retorna true se confirmar, e false se cancelar
                return confirmBan;
            }
        </script>

    </body>

    </html>
<?php
    // Verifica se o formulário de banir foi submetido
    if (isset($_POST['banir_moderador'])) {
        // Verifica se o ID do moderador a ser banido foi recebido via POST
        if (isset($_POST['id_moderador'])) {
            $id_moderador = $_POST['id_moderador'];

            // Aqui você pode executar a lógica para banir o moderador com o ID recebido

            // Por exemplo, você pode executar uma consulta SQL para remover o moderador da tabela
            $sql_banir = "DELETE FROM moderador WHERE moderador_id = $id_moderador";
            $result_banir = $mysqli->query($sql_banir);

            // Verifica se o banimento foi bem-sucedido e se a página ainda não foi recarregada
            if ($result_banir && !isset($_SESSION['reload_lmoderador'])) {
                // Define a variável de sessão para indicar que a página foi recarregada
                $_SESSION['reload_lmoderador'] = true;

                // Exibe um SweetAlert informando que o moderador foi banido com sucesso
                echo '<script>
    Swal.fire({
        icon: "success",
        title: "Moderador banido com sucesso!",
        showConfirmButton: false,
        timer: 1500,
        onClose: () => {
            // Recarrega a página após o banimento bem-sucedido
            window.location.reload();
        }
    });
    </script>';
                exit();
            }
        }
    }
} else {
    echo 'Acesso não autorizado.';
}
?>
<?php
// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "VoltaAoMundo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Aprovar o comentário se o botão for clicado
if (isset($_POST['aprovar'])) {
    $comentario_id = $_POST['comentario_id'];
    $sql = "UPDATE comentarios SET aprovado = 1 WHERE id = $comentario_id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Comentário aprovado com sucesso.";
    } else {
        echo "Erro ao aprovar o comentário: " . $conn->error;
    }
}

// Recuperar os comentários
$sql = "SELECT id, nome, mensagem, email, data_criacao, aprovado FROM comentarios";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Comentários</title>
    <link rel="icon" href="../imagens/favicon-32x32.png" />
    <title>Volta ao Mundo - Suécia</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="estilo.css" />
</head>
<header class="header">
      <img src="imagens/bandeira-suecia.png" alt="Bandeira" width="200" />
      <h1>Suécia</h1>
    </header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="index.html">Página Inicial</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Inserir Novo Admin</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
<body>
    <div class="container mt-5">
        <h1>Comentários</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Mensagem</th>
                    <th>Email</th>
                    <th>Data de Criação</th>
                    <th>Aprovado</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["nome"] . "</td>";
                        echo "<td>" . $row["mensagem"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["data_criacao"] . "</td>";
                        echo "<td>" . ($row["aprovado"] ? "Sim" : "Não") . "</td>";
                        echo "<td>
                                <form method='POST' action=''>
                                    <input type='hidden' name='comentario_id' value='" . $row["id"] . "'>
                                    <button type='submit' name='aprovar' class='btn btn-success'>Aprovar</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Nenhum comentário encontrado</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <div class="admin-container">
        <form action="backupComentarios.php" method="post" style="text-align: right;">
            <button type="submit">Fazer Backup dos Comentários Aprovados</button>
        </form>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
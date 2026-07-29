<?php
require_once "../../controllers/conexao.php"; // Caso a conexao esteja na pasta config, altere para ../../config/conexao.php

// Tenta obter a conexão PDO através da sua classe
try {
    $conn = Conexao::getConnection();
} catch (Exception $e) {
    $conn = null;
}

// 1. Se a conexão falhar, exibe a tela estilizada
if (!$conn) {
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Erro de Conexão - Volta ao Mundo Suécia</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
                min-height: 100vh;
                font-family: system-ui, -apple-system, sans-serif;
            }
        </style>
    </head>
    <body class="d-flex align-items-center justify-content-center p-3">
        <div class="card text-center shadow-lg p-4 border-0" style="max-width: 480px; width: 100%; border-radius: 16px;">
            <div class="card-body">
                <div class="mb-3 text-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                </div>
                <h3 class="fw-bold text-dark mb-2">Erro de Conexão</h3>
                <p class="text-muted mb-4">
                    Não foi possível conectar ao banco de dados <strong>VoltaAoMundo</strong>. Verifique se o MySQL do Wamp está ligado.
                </p>
                <a href="javascript:location.reload()" class="btn btn-outline-primary w-100 py-2 fw-semibold mb-2">
                    🔄 Tentar Novamente
                </a>
                <a href="index.html" class="btn btn-secondary w-100 py-2 fw-semibold">
                    Página Inicial
                </a>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// 2. Aprovar o comentário usando PDO Prepared Statement
$mensagem_status = "";
if (isset($_POST['aprovar'])) {
    $comentario_id = (int)$_POST['comentario_id'];
    $stmtAprovar = $conn->prepare("UPDATE comentarios SET aprovado = 1 WHERE id = ?");
    
    if ($stmtAprovar->execute([$comentario_id])) {
        $mensagem_status = "<div class='alert alert-success m-3'>Comentário aprovado com sucesso!</div>";
    } else {
        $mensagem_status = "<div class='alert alert-danger m-3'>Erro ao aprovar o comentário.</div>";
    }
}

// 3. Recuperar os comentários usando PDO
$stmt = $conn->query("SELECT id, nome, mensagem, email, data_criacao, aprovado FROM comentarios");
$comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volta ao Mundo - Suécia (Painel)</title>
    <link rel="icon" href="../img/favicon-32x32.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="estilo.css" />
</head>
<body>

    <header class="header bg-primary text-white p-3 text-center">
        <img src="../img/bandeira-suecia.png" alt="Bandeira" width="120" class="me-2" />
        <h1 class="d-inline align-middle">Suécia - Painel Administrativo</h1>
    </header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
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

    <div class="container mt-5">
        
        <?php echo $mensagem_status; ?>

        <h1 class="mb-4">Comentários</h1>
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-dark">
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
                    if (count($comentarios) > 0) {
                        foreach ($comentarios as $row) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["nome"] . "</td>";
                            echo "<td>" . $row["mensagem"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $row["data_criacao"] . "</td>";
                            echo "<td>" . ($row["aprovado"] ? "<span class='badge bg-success'>Sim</span>" : "<span class='badge bg-warning text-dark'>Não</span>") . "</td>";
                            echo "<td>";
                            if (!$row["aprovado"]) {
                                echo "<form method='POST' action=''>
                                        <input type='hidden' name='comentario_id' value='" . $row["id"] . "'>
                                        <button type='submit' name='aprovar' class='btn btn-sm btn-success'>Aprovar</button>
                                      </form>";
                            } else {
                                echo "<span class='text-muted small'>Aprovado</span>";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center text-muted'>Nenhum comentário encontrado.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="my-4 text-end">
            <form action="backupComentarios.php" method="post">
                <button type="submit" class="btn btn-outline-secondary">Fazer Backup dos Comentários Aprovados</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
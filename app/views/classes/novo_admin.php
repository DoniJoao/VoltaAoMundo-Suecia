<?php
session_start();
// Proteção: só deixa acessar a tela de cadastro se já estiver logado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.html"); // Ajuste o caminho se necessário
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Novo Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../img/favicon-32x32.png" />
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            font-family: system-ui, -apple-system, sans-serif;
        }
        .admin-card {
            max-width: 420px;
            width: 100%;
            padding: 2.5rem;
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>

    <div class="admin-card">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-dark mb-1">Novo Admin</h2>
            <p class="text-muted small">Adicione um novo usuário ao painel</p>
        </div>

        <!-- Ajuste o action para o caminho correto do seu controller -->
        <form action="../../controllers/admin-cadastrar.php" method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label fw-semibold text-secondary">Nome de Usuário</label>
                <input type="text" class="form-control" name="nome" id="nome" required autofocus>
            </div>
            
            <div class="mb-4">
                <label for="senha" class="form-label fw-semibold text-secondary">Senha de Acesso</label>
                <input type="password" class="form-control" name="senha" id="senha" required>
            </div>
            
            <button type="submit" class="btn btn-primary w-100 mb-2 fw-semibold">Cadastrar Admin</button>
            <a href="index2.php" class="btn btn-outline-secondary w-100 fw-semibold">Voltar ao Painel</a>
        </form>
    </div>

</body>
</html>
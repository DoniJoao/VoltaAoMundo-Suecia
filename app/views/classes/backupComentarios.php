<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Importa a classe Comentarios no caminho correto da pasta models
require_once '../../models/comentarios.php';

$message = '';
$sucesso = false;

try {
    $comentarios = new Comentarios();
    $comentarios->salvarComentariosBackupJSON();
    $message = 'Backup realizado com sucesso!';
    $sucesso = true;
} catch (Exception $e) {
    $message = 'Erro ao realizar o backup de comentários: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backup de Comentários</title>
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
            
            <?php if ($sucesso): ?>
                <!-- Ícone de Sucesso -->
                <div class="mb-3 text-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-file-earmark-arrow-down-fill" viewBox="0 0 16 16">
                        <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 1.5v2.122A1.5 1.5 0 0 0 11.122 5H13.5zM8 6.5a.5.5 0 0 1 .5.5v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 10.793V7a.5.5 0 0 1 .5-.5"/>
                    </svg>
                </div>
                <h3 class="fw-bold text-dark mb-3"><?php echo $message; ?></h3>
                
                <div class="d-grid gap-2 mb-3">
                    <a href="comentariosBackup.json" download class="btn btn-success py-2 fw-semibold shadow-sm">
                        📥 Baixar Arquivo JSON
                    </a>
                </div>
            <?php else: ?>
                <!-- Ícone de Erro -->
                <div class="mb-3 text-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                    </svg>
                </div>
                <h3 class="fw-bold text-dark mb-2">Falha no Backup</h3>
                <p class="text-danger small mb-4"><?php echo $message; ?></p>
            <?php endif; ?>

            <a href="index2.php" class="btn btn-outline-secondary w-100 py-2 fw-semibold">
                ← Voltar ao Painel do Administrador
            </a>

        </div>
    </div>

</body>
</html>
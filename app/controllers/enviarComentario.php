<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // Inclui a conexão com o banco de dados e a classe Comentarios
    include "../models/comentarios.php";

    // Captura e sanitiza os dados do formulário
    $nome = isset($_POST["nome"]) ? htmlspecialchars($_POST["nome"], ENT_QUOTES, 'UTF-8') : null;
    $mensagem = isset($_POST["mensagem"]) ? htmlspecialchars($_POST["mensagem"], ENT_QUOTES, 'UTF-8') : null;
    $email = isset($_POST["email"]) ? htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8') : null;

    // Verifica se todos os campos necessários foram preenchidos
    if (empty($nome) || empty($mensagem) || empty($email)) {
        throw new Exception("Todos os campos são obrigatórios.");
    }

    // Cria um novo objeto Comentarios e define suas propriedades
    $comentario = new Comentarios();
    $comentario->nome = $nome;
    $comentario->mensagem = $mensagem;
    $comentario->email = $email;
    $comentario->aprovado = 0; // Define como não aprovado inicialmente

    // Envia o comentário para o banco de dados
    $comentario->enviarComentarios();
?>
<!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Comentário Enviado</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
                min-height: 100vh;
                font-family: system-ui, -apple-system, sans-serif;
            }
        </style>
    </head>
    <body class="d-flex align-items-center justify-content-center p-3">
        <div class="card text-center shadow-lg p-4 border-0" style="max-width: 450px; width: 100%; border-radius: 16px;">
            <div class="card-body">
                <div class="mb-3 text-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l5.002-6.502a.75.75 0 0 0-.022-1.08z"/>
                    </svg>
                </div>
                <h3 class="fw-bold text-dark mb-2">Comentário enviado com sucesso!</h3>
                <p class="text-muted mb-4">Obrigado pela sua colaboração.</p>
                <a href="../../index.html" class="btn btn-primary w-100 py-2 fw-semibold shadow-sm">
                    Voltar para a Página Inicial
                </a>
            </div>
        </div>
    </body>
    </html>
    <?php

} catch (Exception $erro) {
    // TELA DE ERRO ESTILIZADA
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Erro ao Enviar</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
                min-height: 100vh;
                font-family: system-ui, -apple-system, sans-serif;
            }
        </style>
    </head>
    <body class="d-flex align-items-center justify-content-center p-3">
        <div class="card text-center shadow-lg p-4 border-0" style="max-width: 450px; width: 100%; border-radius: 16px;">
            <div class="card-body">
                <div class="mb-3 text-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                    </svg>
                </div>
                <h3 class="fw-bold text-dark mb-2">Ocorreu um erro</h3>
                <p class="text-danger small mb-2"><?php echo $erro->getMessage(); ?></p>
                <p class="text-muted mb-4">Por favor, tente novamente mais tarde.</p>
                <a href="javascript:history.back()" class="btn btn-secondary w-100 py-2 fw-semibold shadow-sm">
                    Voltar e tentar novamente
                </a>
            </div>
        </div>
    </body>
    </html>
    <?php
}
?>
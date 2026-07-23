<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // Inclui a conexão com o banco de dados e a classe Comentarios
    include "classes/comentarios.php";

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

    echo "<h3>Comentário enviado com sucesso! Obrigado pela colaboração.</h3>";
    echo "<a href='index.html'>Voltar para a Página Inicial</a>";

} catch (Exception $erro) {
    // Exibe a mensagem de erro para depuração
    echo "Erro: " . $erro->getMessage();
    echo "<br>Ocorreu um erro. Por favor, tente novamente mais tarde.";
}
?>

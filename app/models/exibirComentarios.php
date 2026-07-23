<?php
// Inclua o arquivo da classe Comentarios
include_once 'classes/comentarios.php';

try {
    // Crie uma instância da classe Comentarios
    $comentarios = new Comentarios();

    // Obtenha a lista de comentários aprovados
    $lista_comentarios = $comentarios->exibirComentariosAprovados();

    // Verifique se existem comentários
    if ($lista_comentarios) {
        // Retorne a lista de comentários como JSON
        echo json_encode($lista_comentarios);
    } else {
        // Se não houver comentários, retorne um array vazio como JSON
        echo json_encode([]);
    }
} catch (Exception $e) {
    // Retorne um erro como JSON
    echo json_encode(['error' => 'Erro ao carregar os comentários: ' . $e->getMessage()]);
}
?>

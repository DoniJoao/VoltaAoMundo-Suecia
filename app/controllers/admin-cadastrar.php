<?php
session_start();

// Importação da conexão e do model (ajuste os caminhos se necessário)
require_once __DIR__ . '/conexao.php'; 
require_once __DIR__ . '/../models/usuarios.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    // Verifica se não enviaram vazio
    if (empty($nome) || empty($senha)) {
        echo "<script>alert('Preencha todos os campos!'); history.back();</script>";
        exit;
    } 

    try {
        // 1. Pega a conexão usando a sua classe Conexao
        $conexao = Conexao::getConnection();

        // 2. Passa a conexão para dentro da classe Usuario (ISSO RESOLVE O ERRO!)
        $usuarioModel = new Usuario($conexao);

        // Verifica se o usuário já existe para não duplicar
        if ($usuarioModel->buscarPorNome($nome)) {
            echo "<script>alert('Esse nome de usuário já existe!'); history.back();</script>";
            exit;
        }

        // Gera o Hash SHA-256 para manter o padrão seguro do seu banco
        $senhaHash = hash('sha256', $senha);

        // Salva no banco
        if ($usuarioModel->criarUsuario($nome, $senhaHash)) {
            echo "<script>
                    alert('Administrador cadastrado com sucesso!'); 
                    window.location.href = '../views/classes/index2.php';
                  </script>";
        } else {
            echo "<script>alert('Erro ao cadastrar no banco.'); history.back();</script>";
        }

    } catch (Exception $e) {
        echo "Erro do sistema: " . $e->getMessage();
    }
} else {
    // Se tentarem acessar direto pela URL
    header('Location: ../views/classes/index2.php');
    exit;
}
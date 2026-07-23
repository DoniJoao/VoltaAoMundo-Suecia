<?php
session_start();
require_once "classes/usuarios.php";
require_once "classes/conexao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['nome'];
    $pass = $_POST['senha'];

    try {
        $conexao = Conexao::getConnection();

        // Prepara a consulta SQL para buscar o usuário e a senha
        $stmt = $conexao->prepare("SELECT senha FROM usuarios WHERE nome = ?");
        $stmt->bindParam(1, $user);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        
        if ($stmt->rowCount() > 0) {
            $linha = $stmt->fetch();
            $hashed_password = $linha['senha'];
            
            // Verifica se a senha está correta
            if (hash('sha256', $pass) === $hashed_password) {
                $_SESSION['usuario'] = $user;
                header('Location: index2.php');
                exit;
            } else {
                echo "<script>alert('Usuário ou senha incorretos!'); window.location.href='login.html';</script>";
            }
        } else {
            echo "<script>alert('Usuário ou senha incorretos!'); window.location.href='login.html';</script>";
        }
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>

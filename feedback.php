<?php
$servername = "localhost";
$dbname = "";

$conn = new mysqli($servername, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$nome = $_POST['nome'];

$mensagem = $_POST['mensagem'];

$sql = "INSERT INTO contatos (nome, email, mensagem) VALUES ('$nome', '$mensagem')";

if ($conn->query($sql) === TRUE) {
    echo "Dados inseridos com sucesso!";
} else {
    echo "Erro: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
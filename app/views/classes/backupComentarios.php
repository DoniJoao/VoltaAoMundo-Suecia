<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'classes/comentarios.php';

$message = '';

try {
    $comentarios = new Comentarios();
    $comentarios->salvarComentariosBackupJSON();
    $message = 'Backup realizado com sucesso.';
} catch (Exception $e) {
    $message = 'Erro ao realizar o backup de comentários: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Backup de Comentários</title>
  <link rel="stylesheet" href="./style.css">
</head>
<body>
  <h1><?php echo $message; ?></h1>
  <?php if (strpos($message, 'sucesso') !== false): ?>
    <a href="comentariosBackup.json" download>Baixar Backup</a>
  <?php endif; ?>
  <br>
  <a href="index2.php">Voltar à Área do Administrador</a>
</body>
</html>

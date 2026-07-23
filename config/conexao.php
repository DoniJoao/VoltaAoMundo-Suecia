<?php
class Conexao
{
    public static function getConnection()
    {
        try {
            $conexao = new PDO("mysql:host=localhost;dbname=VoltaAoMundo", "root", "");
            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexao;
        } catch (PDOException $e) {
            throw new Exception("Erro na conexão com o banco de dados: " . $e->getMessage());
        }
    }
}
?>

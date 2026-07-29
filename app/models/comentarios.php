<?php
require_once __DIR__ . "/../controllers/conexao.php";

class Comentarios {
    private $conexao;
    
    public $nome;
    public $mensagem;
    public $email;
    public $aprovado;
    
    public function __construct() {
        $this->conexao = $this->obterConexao();
    }

    private function obterConexao() {
        if (!class_exists('Conexao')) {
            throw new Exception('Classe Conexao não encontrada.');
        }

        if (is_callable(['Conexao', 'conectar'])) {
            return call_user_func(['Conexao', 'conectar']);
        }

        $conexaoInstancia = new Conexao();

        if (is_callable([$conexaoInstancia, 'conectar'])) {
            return call_user_func([$conexaoInstancia, 'conectar']);
        }

        if (is_callable(['Conexao', 'connect'])) {
            return call_user_func(['Conexao', 'connect']);
        }

        if (is_callable([$conexaoInstancia, 'connect'])) {
            return call_user_func([$conexaoInstancia, 'connect']);
        }

        if (is_callable(['Conexao', 'getConnection'])) {
            return call_user_func(['Conexao', 'getConnection']);
        }

        if (is_callable([$conexaoInstancia, 'getConnection'])) {
            return call_user_func([$conexaoInstancia, 'getConnection']);
        }

        throw new Exception('Método de conexão não encontrado em Conexao.');
    }

    public function enviarComentarios() {
        if ($this->conexao) {
            $query = "INSERT INTO comentarios (nome, mensagem, email, data_criacao, aprovado) VALUES (:nome, :mensagem, :email, NOW(), :aprovado)";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(':nome', $this->nome);
            $stmt->bindParam(':mensagem', $this->mensagem);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':aprovado', $this->aprovado);

            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception('Falha ao enviar comentário.');
            }
        } else {
            throw new Exception('Falha na conexão com o banco de dados.');
        }
    }

    public function exibirComentariosAprovados() {
        try {
            $query = "SELECT nome, mensagem, email, data_criacao FROM comentarios WHERE aprovado = 1";
            $stmt = $this->conexao->query($query);
            $comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $comentarios;
        } catch (PDOException $e) {
            throw new Exception('Erro ao buscar comentários aprovados: ' . $e->getMessage());
        }
    }

    public function exibirTodosComentarios() {
        try {
            $query = "SELECT nome, mensagem, email, data_criacao, aprovado FROM comentarios";
            $stmt = $this->conexao->query($query);
            $comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $comentarios;
        } catch (PDOException $e) {
            throw new Exception('Erro ao buscar todos os comentários: ' . $e->getMessage());
        }
    }

    public function salvarComentariosBackupJSON($filename = 'comentariosBackup.json') {
        try {
            $comentarios = $this->exibirTodosComentarios();

            if ($comentarios) {
                $json_data = json_encode($comentarios, JSON_PRETTY_PRINT);

                if (file_put_contents($filename, $json_data)) {
                    return true;
                } else {
                    throw new Exception('Falha ao salvar o arquivo JSON.');
                }
            } else {
                throw new Exception('Não há comentários para backup.');
            }
        } catch (Exception $e) {
            throw new Exception('Erro ao realizar o backup de comentários: ' . $e->getMessage());
        }
    }

}
?>

<?php
class Conexao {
    public static function conectar() {
        // Configure os detalhes da conexão
        $host = 'localhost';
        $db = 'VoltaAoMundo';
        $user = 'root';
        $pass = '';
        
        try {
            $conexao = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexao;
        } catch (PDOException $e) {
            throw new Exception('Erro de conexão: ' . $e->getMessage());
        }
    }
}

class Comentarios {
    private $conexao;
    
    public $nome;
    public $mensagem;
    public $email;
    public $aprovado;
    
    public function __construct() {
        $this->conexao = Conexao::conectar();
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

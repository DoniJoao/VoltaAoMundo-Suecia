<?php
require_once "conexao.php";

class Usuario
{
    public $id;
    public $nome;
    public $senha;
    private $conexao;

    public function __construct($conexao, $id = false)
    {
        $this->conexao = $conexao;
        if ($id) {
            $this->id = $id;
            $this->carregar();
        }
    }


    public function criarUsuario($nome, $senhaHash) {
        $stmt = $this->conexao->prepare("INSERT INTO usuarios (nome, senha) VALUES (:nome, :senha)");
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senhaHash, PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    public function buscarPorNome($nome) {
        $stmt = $this->conexao->prepare("SELECT * FROM usuarios WHERE nome = :nome LIMIT 1");
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function login()
    {
        $senha = hash("sha256", $this->senha);

        $sql = "SELECT * FROM usuarios WHERE nome = :nome AND senha = :senha";

        $resultado = $this->conexao->prepare($sql);
        $resultado->bindParam(':nome', $this->nome);
        $resultado->bindParam(':senha', $senha);
        $resultado->execute();

        $linha = $resultado->fetch(PDO::FETCH_ASSOC);
        if ($linha) {
            $this->nome = $linha['nome'];
            $this->senha = $linha['senha'];
            return true;
        } else {
            return false;
        }
    }

    public function excluir()
    {
        $sql = "DELETE FROM usuarios WHERE id = :id";

        $resultado = $this->conexao->prepare($sql);
        $resultado->bindParam(':id', $this->id);
        $resultado->execute();
    }

    public function carregar()
    {
        $sql = "SELECT * FROM usuarios WHERE id = :id";

        $resultado = $this->conexao->prepare($sql);
        $resultado->bindParam(':id', $this->id);
        $resultado->execute();

        $linha = $resultado->fetch(PDO::FETCH_ASSOC);

        $this->nome = $linha['nome'];
        $this->senha = $linha['senha'];
    }
}
?>

<?php
class Usuario
{
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

    public function inserir()
    {
        $sql = "INSERT INTO usuarios (nome, senha) VALUES (:nome, :senha)";

        $resultado = $this->conexao->prepare($sql);
        $resultado->bindParam(':nome', $this->nome);
        $resultado->bindParam(':senha', $this->senha);
        $resultado->execute();
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

    private function contarUsuarios()
    {
        $sql = "SELECT COUNT(*) AS total FROM usuarios";

        $resultado = $this->conexao->prepare($sql);
        $resultado->execute();

        $linha = $resultado->fetch(PDO::FETCH_ASSOC);

        return $linha['total'];
    }
}
?>

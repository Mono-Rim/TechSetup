<?php
class Pessoa {
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $imagem;

    public function __construct($id, $nome, $email, $senha, $imagem) {
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
        $this->imagem = $imagem;
    }


    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function getImagem() {
        return $this->imagem;
    }

    public function setImagem($imagem) {
        $this->imagem = $imagem;
    }

    public function __toString() {
        return "Pessoa{" .
               "id=" . $this->id .
               ", nome='" . $this->nome . '\'' .
               ", email='" . $this->email . '\'' .
               ", senha='" . $this->senha . '\'' .
               ", imagem='" . $this->imagem . '\'' .
               '}';
    }
}
?>

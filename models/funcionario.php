<?php

namespace Models;

use Lib\Session;
use Lib\DB;
use Lib\Router;
use Lib\App;

class Funcionario {

    private $idFuncionario;
    private $nome;
    private $usuario;
    private $senha;
    private $cargo;

    /**
     * Retorna todos os funcionarios
     * @return \Models\Funcionario
     * @throws \Exception
     */
    public static function getFuncionarios() {
        $conn = DB::getConnection();

        $query = 'SELECT idFuncionario, nome, usuario, senha,cargo FROM Funcionario';

        $result = $conn->query($query);
        if ($result == FALSE) {
            throw new \Exception("Falha ao carregar lista de usuarios. Erro: {$conn->error}");
        }

        $funcionarios = [];
        while ($row = $result->fetch_assoc()) {
            $funcionarios[] = new Funcionario($row['idFuncionario'], $row['nome'], $row['usuario'], $row['senha'], $row['cargo']);
        }

        $result->close();

        return $funcionarios;
    }

    /**
     * Busca um funcionario pelo usuario
     * @param type $login
     * @return funcionario
     * @throws \Exception
     */
    public static function getByLogin($login) {
        $conn = DB::getConnection();
        $query = 'SELECT `idFuncionario`, `nome`, `usuario`, `senha`, `cargo` FROM `Funcionario` WHERE `usuario` = ?';
        $stmt = $conn->prepare($query);

        if ($stmt === FALSE) {
            throw new \Exception("Falha ao preparar query. Erro: {$conn->error}");
        }

        if ($stmt->bind_param('s', $login) === FALSE) {
            throw new \Exception("Falha ao associar parametros. Erro : {$stmt->error}");
        }

        if ($stmt->execute() === FALSE) {
            throw new \Exception("Falha ao executar query. Erro : {$stmt->error}");
        }

        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $funcionario = new Funcionario($row['idFuncionario'], $row['nome'], $row['usuario'], $row['senha'], $row['cargo']);
        } else {
            $funcionario = NULL;
        }



        $result->close();
        $stmt->close();

        return $funcionario;
    }

    /**
     * Busca um funcionario pelo IdFuncionario
     * @param integer $id
     * @return funcionario
     * @throws \Exception
     */
    public static function getById($id) {
        $conn = DB::getConnection();

        $query = 'SELECT `idFuncionario`, `nome`,`usuario`, `senha`, `cargo` FROM `Funcionario` WHERE `idFuncionario` = ?';
        $stmt = $conn->prepare($query);

        if ($stmt === FALSE) {
            throw new \Exception("Falha ao preparar query. Erro: {$conn->error}");
        }

        if ($stmt->bind_param('i', $id) === FALSE) {
            throw new \Exception("Falha ao associar parametros. Erro : {$stmt->error}");
        }

        if ($stmt->execute() === FALSE) {
            throw new \Exception("Falha ao executar query. Erro : {$stmt->error}");
        }

        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $funcionario = new Funcionario($row['idFuncionario'], $row['nome'], $row['usuario'], $row['senha'], $row['cargo']);
        } else {
            $funcionario = NULL;
        }


        $result->close();
        $stmt->close();

        return $funcionario;
    }

    /**
     * Insere um Funcionario na tabela funcionario
     * @param funcionario $func
     * @throws \Exception
     */
    public static function insere($func) {
        $conn = DB::getConnection();

        $query = 'INSERT INTO Funcionario (nome, usuario, senha,cargo) VALUES (?, ?, ?,?)';
        $stmt = $conn->prepare($query);
        if ($stmt === FALSE) {
            throw new \Exception("Falha ao preparar query. Erro: {$conn->error}");
        }

        $nome = $func->getNome();
        $usuario = $func->getUsuario();
        $senha = $func->getSenha();
        $cargo = $func->getCargo();
        if ($stmt->bind_param('ssss', $nome, $usuario, $senha, $cargo) === FALSE) {
            throw new \Exception("Falha ao associar parâmetros. Erro: {$stmt->error}");
        }

        if ($stmt->execute() === FALSE) {
            throw new \Exception("Falha ao executar query. Erro: {$stmt->error}");
        }

        $stmt->close();
    }

    /**
     * Altera o funcionario que possui os dados passados
     * @param type $func
     * @throws \Exception
     */
    public static function altera($func) {
        $conn = DB::getConnection();

        $query = 'UPDATE Funcionario SET nome = ?, usuario = ?, senha = ?,cargo= ? WHERE idFuncionario= ?';
        $stmt = $conn->prepare($query);
        if ($stmt === FALSE) {
            throw new \Exception("Falha ao preparar query. Erro: {$conn->error}");
        }

        $idFuncionario = $func->getIdFuncionario();
        $nome = $func->getNome();
        $usuario = $func->getUsuario();
        $senha = $func->getSenha();
        $cargo = $func->getCargo();
        if ($stmt->bind_param('sssii', $nome, $usuario, $senha, $cargo, $idFuncionario) === FALSE) {
            throw new \Exception("Falha ao associar parâmetros. Erro: {$stmt->error}");
        }

        if ($stmt->execute() === FALSE) {
            throw new \Exception("Falha ao executar query. Erro: {$stmt->error}");
        }

        $stmt->close();
    }

    /**
     * Verifica se um funcionario possui permissão de admin ou não(inpede ações de edição de usuarios caso não seja admin)
     */
    public static function verificarcargo() {
        $funcionario = Session::get('funcionario');
        $funcionario = $funcionario->getIdFuncionario();
        $funcionario = Funcionario::getById($funcionario);
        if (($funcionario->getCargo()) != 'admin') {
            Session::setFlash('SEM PERMISSÃO PARA AÇÃO');
            Router::redirect(App::getRouter()->getUrl(''));
        }
    }

    /**
     * Exclui um funcionario da tabela Funcionario
     * @param type $idFuncionario
     * @throws \Exception
     */
    public static function exclui($idFuncionario) {
        $conn = DB::getConnection();

        $query = 'DELETE FROM Funcionario WHERE idFuncionario = ?';
        $stmt = $conn->prepare($query);
        if ($stmt === FALSE) {
            throw new \Exception("Falha ao preparar query. Erro: {$conn->error}");
        }

        if ($stmt->bind_param('i', $idFuncionario) === FALSE) {
            throw new \Exception("Falha ao associar parametros. Erro: {$stmt->error}");
        }

        if ($stmt->execute() === FALSE) {
            throw new \Exception("Falha ao executar query. Erro: {$stmt->error}");
        }

        $stmt->close();
    }

    /**
     * 
     * @return idFuncionario -
     */
    function getIdFuncionario() {
        return $this->idFuncionario;
    }

    /**
     * 
     * @return string nome - do funcionario 
     */
    function getNome() {
        return $this->nome;
    }

    /**
     * 
     * @return string usuario
     */
    function getUsuario() {
        return $this->usuario;
    }

    /**
     * 
     * @return string senha - do funcionario
     */
    function getSenha() {
        return $this->senha;
    }

    /**
     * 
     * @return string cargo
     */
    function getCargo() {
        return $this->cargo;
    }

    /**
     * @param int $idFuncionario
     */
    function setIdFuncionario($idFuncionario) {
        $this->idFuncionario = $idFuncionario;
    }

    /**
     * 
     * @param string $nome
     */
    function setNome($nome) {
        $this->nome = $nome;
    }

    /**
     * 
     * @param type $usuario
     */
    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    /**
     * 
     * @param string $senha
     */
    function setSenha($senha) {
        $this->senha = $senha;
    }

    /**
     * 
     * @param string $cargo
     */
    function setCargo($cargo) {
        $this->cargo = $cargo;
    }

    /**
     * Constroe um novo funcionario
     * @param int $idFuncionario
     * @param string $nome
     * @param string $usuario
     * @param string $senha
     * @param string $cargo
     */
    function __construct($idFuncionario, $nome, $usuario, $senha, $cargo) {
        $this->idFuncionario = $idFuncionario;
        $this->nome = $nome;
        $this->usuario = $usuario;
        $this->senha = $senha;
        $this->cargo = $cargo;
    }

}

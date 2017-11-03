<?php

namespace Models;

use Lib\DB;
use Lib\Model;

class Produto extends Model {

    private $idProduto;
    private $nome;
    private $descricao;
    private $valor;
    private $disponivel;

    /**
     * Retorna todos os produtos com campo disponivel igual a verdadeiro
     * @param bool $disponivel
     * @return \Models\Produto
     * @throws \Exception
     */
    public static function getProduto($disponivel = false) {
        $conn = DB::getConnection();

        if ($disponivel == FALSE) {
            $query = 'SELECT `idProduto`,`nome`, `descricao`, `valor`, `disponivel` FROM `produto`';
        } else {
            $query = 'SELECT `idProduto`, `nome`,`descricao`, `valor`, `disponivel` FROM `produto` WHERE `disponivel` = 1';
        }

        $result = $conn->query($query);
        if ($result === FALSE) {
            throw new \Exception("Falha ao carregar lista de Produtos. Erro: {$conn->error}");
        }

        $produto = [];
        while ($row = $result->fetch_assoc()) {
            $produto[] = new Produto($row['idProduto'], $row['nome'], $row['descricao'], $row['valor'], $row['disponivel']);
        }

        $result->close();

        return $produto;
    }

    /**
     * Busca o produto com o id igual ao passado por parametro
     * @param integer $idProduto
     * @return type
     * @throws \Exception
     */
    public static function getProdutoPorId($idProduto) {
        $conn = DB::getConnection();
        $query = 'SELECT `idProduto`, `nome`, `descricao`, `valor`, `disponivel` FROM `produto` WHERE `idProduto` = ?';
        $stmt = $conn->prepare($query);

        if ($stmt === FALSE) {
            throw new \Exception("Falha ao preparar query. Erro: {$conn->error}");
        }

        if ($stmt->bind_param('i', $idProduto) === FALSE) {
            throw new \Exception("Falha ao associar parametros. Erro : {$stmt->error}");
        }

        if ($stmt->execute() === FALSE) {
            throw new \Exception("Falha ao executar query. Erro : {$stmt->error}");
        }

        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $produto = new Produto($row['idProduto'], $row['nome'], $row['descricao'], $row['valor'], $row['disponivel']);
        } else {
            $produto = NULL;
        }

        $result->close();
        $stmt->close();

        return $produto;
    }

    /**
     * Insere um produto na tabel Produto
     * @param produto $produto
     * @throws \Exception
     */
    public static function cadastrar($produto) {
        $conn = DB::getConnection();
        $query = 'INSERT INTO `Produto` (`idProduto`, `nome`, `descricao`, `valor`, `disponivel`) VALUES (?, ?, ?, ?, ?)';
        $stmt = $conn->prepare($query);

        if ($stmt === FALSE) {
            throw new \Exception("Falha ao preparar query. Erro: {$conn->error}");
        }

        $nome = $produto->getNome();
        $descricao = $produto->getDescricao();
        $valor = $produto->getValor();
        $disponivel = $produto->getDisponivel();
        //$idUsuario = $pagina->getAutor()->getIdUsuario(); ***** EXCLUIR

        if ($stmt->bind_param('sssii', $idProduto, $nome, $descricao, $valor, $disponivel) === FALSE) {
            throw new \Exception("Falha ao associar parametros. Erro : {$stmt->error}");
        }

        if ($stmt->execute() === FALSE) {
            throw new \Exception("Falha ao executar query. Erro : {$stmt->error}");
        }

        $stmt->close();
    }

    /**
     * Atualiza o produto relativo aos dados passados como parametro
     * @param produto $produto
     * @throws \Exception
     */
    public static function atualizar($produto) {
        $conn = DB::getConnection();
        $query = 'UPDATE `Produto` SET `nome`= ? , `descricao` = ?, `valor` = ?, `disponivel` = ? WHERE `idProduto` = ?';
        $stmt = $conn->prepare($query);

        if ($stmt === FALSE) {
            throw new \Exception("Falha ao preparar query. Erro: {$conn->error}");
        }

        $idProduto = $produto->getIdProduto();
        $nome = $produto->getNome();
        $descricao = $produto->getDescricao();
        $valor = $produto->getValor();
        $disponivel = $produto->getDisponivel();
        if ($stmt->bind_param('ssiii', $nome, $descricao, $valor, $disponivel, $idProduto) === FALSE) {
            throw new \Exception("Falha ao associar parametros. Erro : {$stmt->error}");
        }

        if ($stmt->execute() === FALSE) {
            throw new \Exception("Falha ao executar query. Erro : {$stmt->error}");
        }

        $stmt->close();
    }

    /**
     * Exclui o produto com id correspondente ao passado
     * @param integer $idProduto
     * @throws \Exception
     */
    public static function excluir($idProduto) {
        $conn = DB::getConnection();

        $query = 'DELETE FROM `Produto` WHERE `idProduto` = ?';
        $stmt = $conn->prepare($query);

        if ($stmt === FALSE) {
            throw new \Exception("Falha ao preparar query. Erro: {$conn->error}");
        }

        if ($stmt->bind_param('i', $idProduto) === FALSE) {
            throw new \Exception("Falha ao associar parametros. Erro : {$stmt->error}");
        }

        if ($stmt->execute() === FALSE) {
            throw new \Exception("Falha ao executar query. Erro : {$stmt->error}");
        }

        $stmt->close();
    }

    /**
     * 
     * @return integer
     */
    function getIdProduto() {
        return $this->idProduto;
    }

    /**
     * 
     * @return string
     */
    function getNome() {
        return $this->nome;
    }

    /**
     * 
     * @return string
     */
    function getDescricao() {
        return $this->descricao;
    }

    /**
     * 
     * @return float
     */
    function getValor() {
        return $this->valor;
    }

    /**
     * 
     * @return bool
     */
    function getDisponivel() {
        return $this->disponivel;
    }

    /**
     * 
     * @param integer $idProduto
     */
    function setIdProduto($idProduto) {
        $this->idProduto = $idProduto;
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
     * @param string $descricao
     */
    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    /**
     * 
     * @param float $valor
     */
    function setValor($valor) {
        $this->valor = $valor;
    }

    /**
     * 
     * @param bool $disponivel
     */
    function setDisponivel($disponivel) {
        $this->disponivel = $disponivel;
    }

    /**
     * Construtor da classe Produto
     * @param int $idProduto
     * @param string $nome
     * @param string $descricao
     * @param float $valor
     * @param bool $disponivel
     */
    function __construct($idProduto, $nome, $descricao, $valor, $disponivel) {
        $this->idProduto = $idProduto;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->valor = $valor;
        $this->disponivel = $disponivel;
    }

}

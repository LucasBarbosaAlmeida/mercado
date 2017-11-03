<?php

namespace Models;

use Lib\DB;
use Lib\Model;

class Pedido extends Model {

    private $idPedido;
    private $nome;
    private $endereço;
    private $quantidade;
    private $produto_idProduto;

    /**
     * Pega todos os pedidos
     * @return \Models\Pedido
     * @throws \Exception
     */
    public static function getPedido() {
        $conn = DB::getConnection();

        $query = 'SELECT `idPedido`, `nome`,`endereco`, `quantidade`, `produto_idProduto` FROM `Pedido`';
        $result = $conn->query($query);
        if ($result === FALSE) {
            throw new \Exception("Falha ao carregar lista de Pedidos. Erro: {$conn->error}");
        }

        $pedido = [];
        while ($row = $result->fetch_assoc()) {
            $pedido[] = new Pedido($row['idPedido'], $row['nome'], $row['endereco'], $row['quantidade'], $row['produto_idProduto']);
        }

        $result->close();

        return $pedido;
    }

    /**
     * cadastra um pedido na table Pedido
     * @param Pedido $pdd
     * @throws \Exception
     */
    public static function cadastrar($pdd) {
        $conn = DB::getConnection();
        $query = 'INSERT INTO `Pedido` (`nome`, `endereco`, `quantidade`, `produto_idProduto`) VALUES (?, ?, ?, ?)';
        $stmt = $conn->prepare($query);

        if ($stmt === FALSE) {
            throw new \Exception("Falha ao preparar query. Erro: {$conn->error}");
        }

        $nome = $pdd->getNome();
        $endereço = $pdd->getEndereço();
        $quantidade = $pdd->getQuantidade();
        $produto_idProduto = $pdd->getProduto_idProduto();

        if ($stmt->bind_param('ssss', $nome, $endereço, $quantidade, $produto_idProduto) === FALSE) {
            throw new \Exception("Falha ao associar parametros. Erro : {$stmt->error}");
        }

        if ($stmt->execute() === FALSE) {
            throw new \Exception("Falha ao executar query. Erro : {$stmt->error}");
        }

        $stmt->close();
    }

    /**
     * Exclui o pedido que possui o id especificado como parametro
     * @param integer $idPedido
     * @throws \Exception
     */
    public static function excluir($idPedido) {
        $conn = DB::getConnection();

        $query = 'DELETE FROM `Pedido` WHERE `idPedido` = ?';
        $stmt = $conn->prepare($query);

        if ($stmt === FALSE) {
            throw new \Exception("Falha ao preparar query. Erro: {$conn->error}");
        }

        if ($stmt->bind_param('i', $idPedido) === FALSE) {
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
    function getIdPedido() {
        return $this->idPedido;
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
    function getEndereço() {
        return $this->endereço;
    }

    /**
     * 
     * @return int
     */
    function getQuantidade() {
        return $this->quantidade;
    }

    /**
     * 
     * @return integer
     */
    function getProduto_idProduto() {
        return $this->produto_idProduto;
    }

    /**
     * 
     * @param integer $idPedido
     */
    function setIdPedido($idPedido) {
        $this->idPedido = $idPedido;
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
     * @param string $endereço
     */
    function setEndereço($endereço) {
        $this->endereço = $endereço;
    }

    /**
     * 
     * @param int $quantidade
     */
    function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
    }

    /**
     * 
     * @param integer $produto_idProduto
     */
    function setProduto_idProduto($produto_idProduto) {
        $this->produto_idProduto = $produto_idProduto;
    }

    /**
     * Constroe um novo pedido
     * @param int $idPedido
     * @param string $nome
     * @param string $endereço
     * @param int $quantidade
     * @param int $produto_idProduto
     */
    function __construct($idPedido, $nome, $endereço, $quantidade, $produto_idProduto) {
        $this->idPedido = $idPedido;
        $this->nome = $nome;
        $this->endereço = $endereço;
        $this->quantidade = $quantidade;
        $this->produto_idProduto = $produto_idProduto;
    }

}

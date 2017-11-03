<?php

namespace Controllers;

use Lib\Controller;
use Lib\Session;
use Lib\Router;
use Models\Produto;
use Lib\App;
use Models\Pedido;

class ProdutoController extends Controller {

    /**
     * Mostra todos os produtos (visão visitates)
     */
    public function index() {
        $this->data['produtos'] = Produto::getProduto(true);
    }

    /**
     * Ao clicar em um produto leva para a página de compra do mesmo, essa função controla isso
     * @param integer $idprod id do produto selecionado
     */
    public function comprar($idprod) {
        $idprod = filter_var($idprod, FILTER_SANITIZE_NUMBER_INT);
        if ($idprod != FALSE) {
            $this->data['produto'] = Produto::getProdutoPorId($idprod);
            $aux = $this->data['produto'];


            if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === "POST") {
                $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
                $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);
                $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_SANITIZE_NUMBER_INT);

                if ($nome == FALSE || $endereco == FALSE || $quantidade == FALSE || $idprod == FALSE) {
                    Session::setFlash('Todos os campos são obrigatórios.');
                } else {
                    $pedido = new Pedido(0, $nome, $endereco, $quantidade, $idprod);
                    \Models\Pedido::cadastrar($pedido);

                    Session::setFlash('Pedido efetuado com sucesso.');
                    Router::redirect(App::getRouter()->getUrl(''));
                }
            }
            if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === "GET") {
                $this->data['produto'] = \Models\Produto::getProdutoPorId($idprod);
            }
        }
    }

    /**
     * Mostra todos os produtos com a permissão/visãp de Admin
     */
    public function admin_index() {
        $this->data['produtos'] = Produto::getProduto();
    }

    /**
     * Permite a um funcionario criar um novo produto
     */
    public function admin_novo() {
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
            $valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_STRING);
            $disponivel = filter_input(INPUT_POST, 'disponivel') ? 1 : 0;

            if ($nome == FALSE || $descricao == FALSE || $valor == FALSE) {
                Session::setFlash('Todos os campos são obrigatórios.');
                Router::redirect(App::getRouter()->getUrl('produto', 'novo'));
            }

            $produto = new Produto(0, $nome, $descricao, $valor, $disponivel);
            Produto::cadastrar($produto);

            Session::flash('Produto criado com sucesso.');
            Router::redirect(App::getRouter()->getUrl('produto'));
        }
    }

    /**
     * Permite aos funcionario editar um produto
     * @param integer $id - id do produto q será editado
     */
    public function admin_editar($id) {
        $request = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

        if ($request === 'POST') {
            $idProduto = filter_input(INPUT_POST, 'idProduto', FILTER_SANITIZE_NUMBER_INT);
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
            $valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_STRING);
            $disponivel = filter_input(INPUT_POST, 'disponivel') ? 1 : 0;

            if ($idProduto == FALSE || $idProduto <= 0) {
                Session::setFlash('Produto não encontrado.');
                Router::redirect(App::getRouter()->getUrl('produto'));
            } else if ($nome == FALSE || $descricao == FALSE || $valor == FALSE) {
                Session::setFlash('Todos os campos são obrigatórios.');
                Router::redirect(App::getRouter()->getUrl('produto', 'editar', [$idProduto]));
            }


            $produto = new Produto($idProduto, $nome, $descricao, $valor, $disponivel);
            Produto::atualizar($produto);

            Session::flash('Produto atualizado com sucesso.');
            Router::redirect(App::getRouter()->getUrl('produto'));
        } else if ($request === 'GET') {
            $idProduto = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

            if ($idProduto == FALSE || $idProduto < 0) {
                Session::setFlash('Produto não encontrado.');
                Router::redirect(App::getRouter()->getUrl('produto'));
            }

            $this->data['produto'] = Produto::getProdutoPorId($idProduto);
        }
    }

    /**
     * Permite aos funcionarios excluir um produto
     * @param integer $id - id do produto
     */
    public function admin_excluir($id) {
        $idProduto = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        if ($idProduto == FALSE || $idProduto < 0) {
            Session::setFlash('Produto não encontrado.');
            Router::redirect(App::getRouter()->getUrl('produto'));
        }

        Produto::excluir($idProduto);
        Session::setFlash('Produto excluído com sucesso.');
        Router::redirect(App::getRouter()->getUrl('produto'));
    }

}

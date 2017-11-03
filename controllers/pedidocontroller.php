<?php

namespace Controllers;

use Lib\Controller;
use Models\Pedido;
use Lib\Session;
use Lib\Router;
use Lib\App;

class PedidoController extends Controller {

    /**
     * Mostra pedidos para um funcionario (independete do cargo)
     */
    public function admin_index() {
        $this->data['pedidos'] = Pedido::getPedido();
    }

    /**
     * Permite um funcionario(independete do cargo) excluir um pedido
     */
    public function admin_excluir($id) {
        $idPedido = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        if ($idPedido == FALSE || $idPedido < 0) {
            Session::setFlash('Pedido não encontrado.');
            Router::redirect(App::getRouter()->getUrl('pedido'));
        }

        Pedido::excluir($idPedido);
        Session::setFlash('Pedido excluído com sucesso.');
        Router::redirect(App::getRouter()->getUrl('pedido'));
    }

}

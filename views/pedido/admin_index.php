<h3>Pedidos</h3>
<table class="table table-hover" style="width: 100%;">
    <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Pedido</th>
            <th>IdProduto Pedido</th>
        </tr>
    </thead>

    <tbody>
        <?php
        /* @var $pedido Models\Pedido */

        foreach ($data['pedidos'] as $pedido):
            ?>
            <tr>
                <td><?= $pedido->getIdPedido() ?></td>
                <td><?= $pedido->getNome() ?></td>
                <td><?= $pedido->getEndereço() ?></td>
                <td><?= $pedido->getQuantidade() ?></td>
                <td><?= $pedido->getProduto_idProduto()?></td>
                <td>  <a  class="btn btn-danger" href="<?= Lib\App::getRouter()->getUrl('pedido', 'excluir', [$pedido->getIdPedido()]) ?>">Excluir</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
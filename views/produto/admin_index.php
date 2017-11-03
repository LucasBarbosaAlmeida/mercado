<h3>Produtos</h3>
<table class="table table-striped" style="width: 400px">
    <tbody>
        <?php foreach ($data['produtos'] as $produto): ?>

            <tr>
                <td><?= $produto->getNome() ?></td>
                <td class="text-right">
                    <a href="<?= Lib\App::getRouter()->getUrl('produto', 'editar', [$produto->getIdProduto()]) ?>"
                       class="btn btn-sm btn-primary"> Atualizar
                    </a>
                    <a href="<?= Lib\App::getRouter()->getUrl('produto', 'excluir', [$produto->getIdProduto()]) ?>"
                       class="btn btn-sm btn-danger"
                       onclick="return confirmaExcluir()"> Excluir
                    </a>
                </td>
            </tr>

        <?php endforeach; ?>
    </tbody>

</table>

<br />
<div>
    <a href="<?= Lib\App::getRouter()->getUrl('produto', 'novo') ?>"
       class="btn btn-sm btn-success"> Novo Produto
    </a>
</div>
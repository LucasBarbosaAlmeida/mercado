<?php foreach ($data['produtos'] as $produto): ?>
    <div class="item-pagina">
        <a href="<?= Lib\App::getRouter()->getUrl('produto', 'comprar', [$produto->getIdProduto()]) ?>"><?= $produto->getNome() ?></a><br />
    </div>
<?php endforeach; ?>



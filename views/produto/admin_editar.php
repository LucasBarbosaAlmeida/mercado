<?php
/* @var $produto Models\Produto */
$produto = $data['produto'];
?>

<h3>Editar Produto</h3>
<form method="POST" action="">
    <input type="hidden" name="idProduto" value="<?= $produto->getIdProduto() ?>"/>
    <div class="form-group">
        <label for="titulo">Nome</label>
        <input type="text" name="nome" id="nome" class="form-control" value="<?= $produto->getNome() ?>" placeholder="Nome"/>
    </div>
    <div class="form-group">
        <label for="titulo">Descricao</label>
        <textarea name="descricao" id="descricao" class="form-control" placeholder="Descricao"><?= $produto->getDescricao() ?></textarea>
    </div>
    <div class="form-group">
        <label for="titulo">Valor</label>
        <input type="text" name="valor" id="valor" class="form-control" value="<?= $produto->getValor() ?>" placeholder="Valor"/>
    </div>
    <div class="form-group">
        <input type="checkbox" name="disponivel" id="disponivel" <?= ($produto->getDisponivel() ? 'checked=""' : '') ?>/>
        <label for="titulo">Disponivel</label>
    </div>

    <input type="submit" class="btn btn-success" value="Editar"/>
</form>
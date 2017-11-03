<h3>Novo Produto</h3>
<form method="POST" action="">
    <div class="form-group">
        <label for="titulo">Nome</label>
        <input type="text" name="nome" id="nome" class="form-control" value="" placeholder="Nome"/>
    </div>
    <div class="form-group">
        <label for="titulo">Descricao</label>
        <textarea name="descricao" id="descricao" class="form-control" placeholder="Descricao"></textarea>
    </div>
     <div class="form-group">
        <label for="titulo">Valor</label>
        <input type="text" name="valor" id="valor" class="form-control" value="" placeholder="Valor"/>
    </div>
    <div class="form-group">
        <input type="checkbox" name="disponivel" id="disponivel" checked=""/>
        <label for="disponivel">Disponivel</label>
    </div>

    <input type="submit" class="btn btn-success" value="Criar"/>
</form>
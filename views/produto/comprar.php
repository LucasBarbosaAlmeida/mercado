<h3>Pedido</h3>
<h3>Comprar Produto:<?= $data['produto']->getNome()?></h3>
<form action="" method="POST">
    <input type="text" class="form-control" name="nome" placeholder="Seu nome" /><br />
    <input type="text" class="form-control" name="endereco" placeholder="Endereço" /><br />
    <h4>Quantidade</h4><br />
    <input type="number" class="form-control" name="quantidade" placeholder="Quantos?" /><br />
    <button class="btn btn-lg btn-primary btn-block" type="submit">Enviar</button>
</form>
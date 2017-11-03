<?php
$funcionario = $data['funcionario'];
?>

<h3>Atualizar Usuário</h3>
<form action="" method="POST">
    <input type="hidden" name="idFuncionario" value="<?= $funcionario->getIdFuncionario() ?>"/>
    <input type="text" class="form-control" name="nome" placeholder="Nome do usuário" value="<?= $funcionario->getNome() ?>" /><br />
    <input type="text" class="form-control" name="usuario" placeholder="E-mail" value="<?= $funcionario->getUsuario() ?>" /><br />
    <input type="text" class="form-control" name="cargo" placeholder="cargo" value="<?= $funcionario->getCargo() ?>" /><br />
    <input type="password" class="form-control" name="senhaAntiga" placeholder="Antiga Senha"  /><br />
    <input type="password" class="form-control" name="senhaNova" placeholder="Nova Senha"  /><br />
    <button class="btn btn-lg btn-primary btn-block" type="submit">Atualizar</button>
</form>

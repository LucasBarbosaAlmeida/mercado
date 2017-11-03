<button class="btn btn-primary" type="button">
  <a href="<?= Lib\App::getRouter()->getUrl('funcionario', 'cadastrar') ?>">Cadastrar Usuário</a>
</button>

<h3>Usuários</h3>
<table class="table table-stripped">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Usuario</th>
        </tr>
    </thead>
  <tbody>
    <?php foreach ($data['funcionarios'] as $funcionario): ?>
      <tr>
        <td>
          <?= $funcionario->getNome() ?>
        </td>
        <td>
          <?= $funcionario->getUsuario() ?>
        </td>
        <td>
          <a href="<?= Lib\App::getRouter()->getUrl('funcionario', 'atualizar', [$funcionario->getIdFuncionario()]) ?>"
             class="btn btn-sm btn-primary">Atualizar</a>
          <a href="<?= Lib\App::getRouter()->getUrl('funcionario', 'remover', [$funcionario->getIdFuncionario()]) ?>"
             class="btn btn-sm btn-danger"
             onclick="return confirmaExcluir()">Excluir</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

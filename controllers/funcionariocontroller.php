<?php

namespace Controllers;

use Models\DB;
use Models\Funcionario;
use Lib\Session;
use Lib\Router;
use Lib\Controller;
use Lib\App;

class FuncionarioController extends Controller {

    /**
     * Realiza login do funcionario
     */
    public function admin_login() {
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
            $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
            $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

            if ($login == FALSE || $senha == FALSE) {
                Session::setFlash('Todos os campos são obrigatórios.');
                Router::redirect(App::getRouter()->getUrl('funcionario', 'login', [], 'admin'));
            }

            $funcionario = funcionario::getByLogin($login);
            if ($funcionario == NULL || password_verify($senha, $funcionario->getSenha()) == FALSE) {
                Session::setFlash('Não foi possível encontrar um usuário com os dados informados.');
            } else {
                Session::set('funcionario', $funcionario);
            }
            Router::redirect(App::getRouter()->getUrl('', '', [], 'admin'));
        }
    }

    /**
     * Realiza logout do funcionario
     */
    public function admin_logout() {

        Session::destroy();
        Router::redirect(App::getRouter()->getUrl('', '', [], 'admin'));
    }

    /*
     * Mostra todos os funcionarios, na visão de admin
     */

    public function admin_index() {

        $this->data['funcionarios'] = Funcionario::getFuncionarios();
    }

    /*
     * Permite um funcionario com cargo admin cadastrar um funionario
     */

    public function admin_cadastrar() {
        Funcionario::verificarcargo();

        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === "POST") {
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
            $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
            $cargo = filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_STRING);

            if ($nome == FALSE || $usuario == FALSE || $senha == FALSE || $cargo == FALSE) {
                Session::setFlash('Todos esses campos são obrigatórios!');
                Router::redirect(App::getRouter()->getUrl('funcionario', 'cadastrar'));
            }

            // verifica se já existe um usuário com o login informado
            if (Funcionario::getByLogin($usuario) <> NULL) {
                Session::setFlash('Já existe um usuário cadastrado com o e-mail informado!');
                Router::redirect(App::getRouter()->getUrl('funcionario', 'cadastrar'));
            }


            $senha = password_hash($senha, PASSWORD_DEFAULT);

            $user = new Funcionario(0, $nome, $usuario, $senha, $cargo);
            Funcionario::insere($user);
            Session::setFlash('Cadastro de Usuário realizado com sucesso!');
            Router::redirect(App::getRouter()->getUrl('funcionario'));
        }
    }

    /*
     *   * Permite um funcionario com cargo admin atualizar os dados de um funcionario
     */

    public function admin_atualizar($id) {
        Funcionario::verificarcargo();
        $request = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
        if ($request === 'POST') {
            $idFuncionario = filter_input(INPUT_POST, 'idFuncionario', FILTER_SANITIZE_NUMBER_INT);
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
            $senhaAntiga = filter_input(INPUT_POST, 'senhaAntiga', FILTER_SANITIZE_STRING);
            $senhaNova = filter_input(INPUT_POST, 'senhaNova', FILTER_SANITIZE_STRING);
            $cargo = filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_STRING);

            if ($idFuncionario == NULL || $idFuncionario <= 0) {
                Session::setFlash('Funcionário não encontrado.');
                Router::redirect(App::getRouter()->getUrl('funcionario'));
            } else {
                if ($nome == FALSE || $usuario == FALSE || $senhaAntiga == FALSE || $cargo == FALSE) {
                    Session::setFlash('Todos esses campos são obrigatórios, menos a senha nova.');
                    Router::redirect(App::getRouter()->getUrl('funcionario', 'atualizar', [$idFuncionario]));
                } else {
                    $user = Funcionario::getById($idFuncionario);
                    if (password_verify($senhaAntiga, $user->getSenha()) == FALSE) {
                        Session::setFlash('Senha antiga inválida!');
                        Router::redirect(App::getRouter()->getUrl('funcionario', 'atualizar', [$idFuncionario]));
                    }
                }
            }

            if ($senhaNova == NULL) {
                $senhaNova = $senhaAntiga;
            }

            $senhaNova = password_hash($senhaNova, PASSWORD_DEFAULT);

            $funcionario = new Funcionario($idFuncionario, $nome, $usuario, $senhaNova, $cargo);
            \Models\Funcionario::altera($funcionario);

            Session::setFlash('Funcionario atualizado com sucesso!');
            Router::redirect(App::getRouter()->getUrl('funcionario'));
        } else {
            $idFuncionario = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
            if ($idFuncionario == FALSE || $idFuncionario < 0) {
                Session::setFlash('Usuário não encontrado.');
                Router::redirect(App::getRouter()->getUrl('funcionario'));
            }

            $this->data['funcionario'] = Funcionario::getById($idFuncionario);
        }
    }

    /*
     * Permite um funcionario com cargo admin excluir um funcionario
     */

    public function admin_remover($id) {
        Funcionario::verificarcargo();
        $idFuncionario = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        if ($idFuncionario == FALSE || $idFuncionario < 0) {
            Session::setFlash('Funcionario não encontrado.');
            Router::redirect(App::getRouter()->getUrl('funcionario'));
        }

        Funcionario::exclui($idFuncionario);
        Session::setFlash('Funcionario excluido com sucesso!');
        Router::redirect(App::getRouter()->getUrl('funcionario'));
    }

}

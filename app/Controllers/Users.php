<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UsersModel;

class Users extends BaseController
{
	protected $session;

	//===============================================================
	public function __construct()
	{
		$this->session = session();
	}
	//===============================================================
	public function index()
	{
		//Verifica se há uma sessão ativa
		if ($this->checkSession()) {
			//Active session
			$this->homePage();
		} else {
			//Show login from
			$this->login();
		}
	}

	//--------------------------------------------------------------------
	public function login()
	{

		/*
		Verificar se houve submissão
		se houve submissão:
			-verificar se os campos estão preencidos
			-perguntar à bd se existe username e password
			-se existir: abrir sessão e envar para menu inicial
			-se não existir: apresentar formulário de login com erro
			*/

		//Verifica se há uma sessão ativa
		if ($this->checkSession()) {
			//Active session
			$this->homePage();
			return;
		}

		$error = '';
		$data = array();
		$request = \Config\Services::request();

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			//check fields
			$username = $request->getPost('text_username');
			$password = $request->getPost('text_password');
			if ($username == '' || $password == '') {
				$error = "Erro no preenchimento dos campos!";
			}

			//check database
			if ($error == '') {
				$model = new UsersModel();
				$result = $model->verifyLogin($username, $password);
				if (is_array($result)) {
					//valid login
					$this->setSession($result);
					$this->homePage();
					return;
				} else {
					//invalid login
					$error = "Login inválido!";
				}
			}
		}

		if ($error != '') {
			$data['error'] = $error;
		}
		//Show the login page
		echo view('users/login', $data);
	}

	//==============================================================================
	private function setSession($data)
	{
		//Init session

		$session_data = array(
			'id_user' => $data['id_user'],
			'name' => $data['name'],
			'profile' => $data['profile']
		);

		$this->session->set($session_data);
	}

	//==============================================================================
	public function homePage()
	{
		//Verificar se existe sessão
		if (!$this->checkSession()) {
			$this->login();
			return;
		}

		//Verificar se o usuário é administrador -admin-
		$data = array();
		if ($this->checkProfile('admin')) {
			$data['admin'] = true;
		}

		//===== Show homePage view =================================
		echo view('users/homepage', $data);
	}

	//==============================================================================
	public function logout()
	{
		// logout

		$this->session->destroy();
		return redirect()->to(\site_url('users'));
	}

	//==============================================================================
	public function recover()
	{

		//Shows form to recover password
		echo view('users/recover_password');
	}

	//==============================================================================
	public function reset_password()
	{
		//Método 1 ==========================================
		/*
			1. Verifica se existe algum usuário com registro (email inserido)
			2. Caso exista usuário, altera o seu password (random)
			3. "Envia" uma mensagem com a nova password.
			*/

		////reset users password
		////redefines the password and sends by email
		//$request = \Config\Services::request();
		//$email = $request->getPost('text_email');

		////Verificar se há um usuario com este email
		////If exists, change the password and send email
		//$users = new UsersModel();
		//$users->resetPassword($email);

		//Método 2 ==========================================
		/*
			1- Apresenta o formulário para o email
			2- Vai verificar se o email está associado a uma conta
			3- Caso esteja associado, cria um purl e envia email com o purl
			4- O link do purl permite aceder a uma área reservada para redefinir nova password
			
			*/

		$request = \Config\Services::request();
		$email = $request->getPost('text_email');
		$users = new UsersModel();
		$result = $users->checkEmail($email);
		if (count($result) != 0) {
			//Existe o email associado
			$users->sendPurl($email, $result[0]['id_user']);

			echo 'Existe o email!';
		} else {
			//Não existe email
			echo 'Não existe email associado!';
		}
	}

	//==============================================================================
	public function redefine_password($purl)
	{
		echo 'Ola!';
		echo "<p>$purl</p>";
	}

	public function teste($value)
	{
		if ($this->checkProfile($value)) {
			echo 'Existe';
		} else {
			echo 'Não existe!';
		}
	}

	//==============================================================================
	//PRIVATE
	//==============================================================================
	private function checkSession()
	{
		//Check if session exists
		return $this->session->has('id_user');
	}

	//==============================================================================
	private function checkProfile($profile)
	{

		//check if the user has permission to access feature
		if (preg_match("/$profile/", $this->session->profile)) {
			return true;
		} else {
			return false;
		}
	}

	//Aula 31 --------------------
	//====================================================
	public function op1()
	{
		echo 'op1';
	}

	//====================================================
	public function op2()
	{
		echo 'op2';
	}

	//====================================================
	public function admin_users()
	{
		//Verificar se o usuário tem permissão
		if ($this->checkProfile('admin') == false) {
			return redirect()->to(site_url('users'));
		}
		echo 'Administração de utilizadores';
	}
}

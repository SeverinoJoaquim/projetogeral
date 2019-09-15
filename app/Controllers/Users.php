<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UsersModel;

class Users extends BaseController
{
	protected $session;

	//===============================================================
	public function __construct(){
		$this->session = session();
	}
	//===============================================================
	public function index()
	{
		//Verifica se há uma sessão ativa
		if($this->checkSession()){
				//Active session

		} else{
				//Show login from
				$this->login();
			}
	}

	//--------------------------------------------------------------------
	public function login(){

		/*
		Verificar se houve submissão
		se houve submissão:
			-verificar se os campos estão preencidos
			-perguntar à bd se existe username e password
			-se existir: abrir sessão e envar para menu inicial
			-se não existir: apresentar formulário de login com erro
			*/
			$error = '';
			$data = array();
			$request = \Config\Services::request();

			if($_SERVER['REQUEST_METHOD'] == 'POST'){

					//check fields
					$username = $request->getPost('text_username');
					$password = $request->getPost('text_password');
					if($username == '' || $password == ''){
						$error = "Erro no preenchimento dos campos!";
					}

					//check database
					if($error == '' ){
						$model = new UsersModel();
						$result = $model->verifyLogin($username, $password);
						if(is_array($result)){
								//valid login
								$this->setSession($result);
								$this->homePage();
								return;
						}else{
								//invalid login
								$error = "Login inválido!";
						}
					}
			}

			if($error != ''){
				$data['error'] = $error;
			}
		//Show the login page
		echo view('users/login', $data);
	}

	//==============================================================================
	private function setSession($data){
			//Init session

			$session_data = array(
					'id_user' => $data['id_user'],
					'name' => $data['name']
			);

			$this->session->set($session_data);
	}

	//==============================================================================
	public function homePage(){
		echo 'Entrando na aolicação!';

		echo '<pre>';
		print_r($_SESSION);
		echo '</pre>';
	}
	//==============================================================================
	private function checkSession(){
		//Check if session exists
		return $this->session->has('id_user');
	}
}
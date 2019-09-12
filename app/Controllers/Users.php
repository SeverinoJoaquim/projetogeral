<?php namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
	private $sessao;

	//===============================================================
	public function __construct(){
		$this->sessao = session();
	}
	//===============================================================
	public function index()
	{
		
		//login com sucesso
		$dados = array(
			'id_user' => 1,
			'name'=>'Joaquim'
		);
		$this->sessao->set($dados);
	}

	//--------------------------------------------------------------------
	public function menu_inicial(){
		if(!$this->checkSessao()){
			echo 'Acesso negado!';
			exit();
		}
		echo 'Estou no menu principal';
	}

	//--------------------------------------------------------------------
	private function checkSessao(){
		//Verifica se existe sessão
		return $this->sessao->has('id_user');
	}
}
<?php namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
	private $session;

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
		//Show the login page
		echo view('users/login');
	}
	//--------------------------------------------------------------------
	private function checkSession(){
		//Check if session exists
		return $this->session->has('id_user');
	}
}
<?php namespace App\Controllers;

use App\Models\UserModel;

class Main extends BaseController
{
	//===============================================================
	public function index()
	{
		echo view('main');
	}

	//--------------------------------------------------------------------

}

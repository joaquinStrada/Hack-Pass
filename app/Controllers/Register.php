<?php namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UserModel;

class Register extends BaseController
{
	public function index()
	{
		echo view('register');
		echo view('footer');
	}
	public function to_register()
	{
		// creamos una conexion con el modelo
		$userModel = new UserModel($db);

		// recuperamos los datos del formulario
		$request = \Config\Services::request();
		$nombre = $request->getPostGet('nombre');
		$email = $request->getPostGet('email');
		$user = $request->getPostGet('usuario');

		// creamos un hash de Contraseña
		$opciones = [
    	'cost' => 12,
		];
		$pass = password_hash($request->getPostGet('pass'), PASSWORD_BCRYPT, $opciones);

		// validamos que el usuario ni el email exista
		$row = $userModel->where('email', $email)->findAll();
		if (count($row) != 0) {
		 echo "false|El EMAIL que usted esta intentando registrar Ya Existe";
		 die();
		}

		$row = $userModel->where('usuario', $user)->findAll();
		if (count($row) != 0) {
		 echo "false|El USUARIO que usted esta intentando registrar Ya Existe";
		 die();
		}
		// insertamos los registros
		$data = array('nombre_completo' => $nombre, 'email' => $email, 'usuario' => $user, 'password' => $pass);
		if ($userModel->insert($data)) {
			echo "true|Usuario registrado Satisfactoriamente!";
		} else {
			print_r($userModel->errors());
		}
	}

	//--------------------------------------------------------------------

}

<?php
class Utama{

	public function ambilLink(){

		if(isset($_GET['s'])){ //mengatur variabel s setiap folder
			$link = $_GET['s'];

			if(empty($link)){

				include_once $this->callCtrl('index');
				include_once $this->viewLink('index');
			}elseif ($link == 'out') {
				session_destroy();
				header("Location: ?");
			}else{

				$controller = 's_controller/' . ucfirst($link). 'View.php';

				if (file_exists($controller)) {
					include_once $controller;
				}else {
					include_once $this->callCtrl('dashboard');
				}
			}
		}else{
			include_once $this->callCtrl('index');
		}
	}

	private function callCtrl($ctrl = NULL){
		return 's_controller/' . ucfirst($ctrl) . 'View.php';
	}
}

session_start();

$utama = new Utama();
$link = $utama->ambilLink();
?>
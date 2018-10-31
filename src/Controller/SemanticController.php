<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Semantic Controller
 *
 *
 * @method \App\Model\Entity\Semantic[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SemanticController extends AppController {

	public function beforeFilter(\Cake\Event\Event $event) {
		parent::beforeFilter($event);
		$this->Auth->allow('display');
	}
	
	public function display($path) {
		$allowed = [
			'semantic.css' => true,
			'semantic.min.css' => true,
			'semantic.js' => true,
			'semantic.min.js' => true
		];
		return isset($allowed[$path]) ?
			   $this->response->withFile(ROOT . "/vendor/semantic/ui/dist/" . $path) :
			   $this->response->withStatus(404);
	}

}

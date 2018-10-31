<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
/**
* Users Controller
*
* @property \App\Model\Table\UsersTable $Users
*
* @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
*/
class UsersController extends AppController {

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->Auth->allow(['login', 'register']);
	}


	public function login(){
		if ($this->request->is('post')) {
			$user = $this->Auth->identify();
			if ($user) {
				$this->Auth->setUser($user);
				$this->Flash->success("Logged in as " . $user['full_name']);
				return $this->redirect($this->Auth->redirectUrl());
			}
			$this->Flash->error('Your username or password is incorrect.');
		}
	}

	/**
	* Register Method
	*/
	public function register(){
		$user = $this->Users->newEntity();
		if ($this->request->is('post')) {
			$user = $this->Users->patchEntity($user, $this->request->getData());
			//Determine if first user
			$count = $this->Users->find()->all()->count();
			if ($count == 0) {
				$user->role_id = 1;
			} else {
				$user->role_id = 2;
			}
			if ($this->Users->save($user)) {
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The user could not be saved. Please, try again.'));
		}
		$this->set(compact('user'));
	}

	public function dashboard() {
		$user = $this->Users->get($this->authUser['id'], ['contain' => ['PlaidAccounts']]);
		$this->set(compact('user'));
	}
}

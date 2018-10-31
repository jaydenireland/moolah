<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Http\Client;
use Cake\Core\Configure;
/**
 * Plaidaccounts Controller
 *
 * @property \App\Model\Table\PlaidAccountsTable $PlaidAccounts
 *
 * @method \App\Model\Entity\Plaidaccount[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PlaidAccountsController extends AppController{

	public function beforeFilter(\Cake\Event\Event $event) {
		parent::beforeFilter($event);
		$this->Security->setConfig([
			'unlockedActions' => ['addAccessToken']
		]);
		$this->loadComponent('JsonResponse');
	}

	public function add() {
		$this->set('public_key', Configure::read('Plaid.public_key'));
	}

	public function addAccessToken() {
		$data = $this->request->getData();

		$response = $this->PlaidAccounts->getItem($data['public_token']);
		$data = [
			'user_id' => $this->Auth->user()['id']
		] + $response;

		$plaidAccount = $this->PlaidAccounts->newEntity();
		$this->PlaidAccounts->patchEntity($plaidAccount, $data);

		if ($this->PlaidAccounts->save($plaidAccount)) {
			$res = $this->PlaidAccounts->getAccountBalance($plaidAccount);
			$accounts = $res['accounts'];
			return $this->JsonResponse->response(compact('accounts'));
		} else {
			$errors = $plaidAccount->getErrors();
			return $this->JsonResponse->response(compact('errors'), 500);
		}

	}



}

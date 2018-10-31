<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Model\Entity\PlaidAccount;
use Cake\Http\Client;
use Cake\Core\Configure;
use Cake\Cache\Cache;
/**
 * PlaidAccounts Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property |\Cake\ORM\Association\BelongsTo $Items
 *
 * @method \App\Model\Entity\PlaidAccount get($primaryKey, $options = [])
 * @method \App\Model\Entity\PlaidAccount newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PlaidAccount[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PlaidAccount|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlaidAccount|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlaidAccount patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PlaidAccount[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PlaidAccount findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PlaidAccountsTable extends Table
{

	/**
	 * Initialize method
	 *
	 * @param array $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config)
	{
		parent::initialize($config);

		$this->setTable('plaid_accounts');
		$this->setDisplayField('id');
		$this->setPrimaryKey('id');

		$this->addBehavior('Timestamp');

		$this->belongsTo('Users', [
			'foreignKey' => 'user_id',
			'joinType' => 'INNER'
		]);
	}

	/**
	 * Default validation rules.
	 *
	 * @param \Cake\Validation\Validator $validator Validator instance.
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator)
	{
		$validator
			->nonNegativeInteger('id')
			->allowEmpty('id', 'create');

		$validator
			->scalar('access_token')
			->requirePresence('access_token', 'create')
			->notEmpty('access_token');

		return $validator;
	}

	/**
	 * Returns a rules checker object that will be used for validating
	 * application integrity.
	 *
	 * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
	 * @return \Cake\ORM\RulesChecker
	 */
	public function buildRules(RulesChecker $rules)
	{
		$rules->add($rules->existsIn(['user_id'], 'Users'));
		// $rules->add($rules->isUnique(['access_token']));
		return $rules;
	}

	public function getAccountBalance(PlaidAccount $plaidAccount) {
		return Cache::remember($plaidAccount->id . '-balance', function () use ($plaidAccount) {
			$http = new Client();
			$response = $http->post(
				Configure::read('Plaid.baseUrl') . '/accounts/balance/get',
				json_encode([
					'client_id' => Configure::read('Plaid.client_id'),
					'secret' => Configure::read('Plaid.secret'),
					'access_token' => $plaidAccount->access_token
				]),
				['type' => 'json']
			);
			$json = $response->json;
			$json['item']['institution'] = $this->getInstitution($json['item']['institution_id']);
			return $json;
		});

	}

	public function getItem($publicToken = '') {
		$http = new Client();
		$response = $http->post(
			Configure::read('Plaid.baseUrl') . '/item/public_token/exchange',
			json_encode([
				'client_id' => Configure::read('Plaid.client_id'),
				'secret' => Configure::read('Plaid.secret'),
				'public_token' => $publicToken
			]),
			['type' => 'json']
		);
		return $response->json;
	}

	public function getInstitution($id = null) {
		$http = new Client();
		$response = $http->post(
			Configure::read('Plaid.baseUrl') . '/institutions/get_by_id',
			json_encode([
				'public_key' => Configure::read('Plaid.public_key'),
				'institution_id' => $id
			]),
			['type' => 'json']
		);
		return $response->json['institution'];
	}
}

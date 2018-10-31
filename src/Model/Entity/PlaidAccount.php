<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
/**
 * PlaidAccount Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $access_token
 * @property string $item_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 */
class PlaidAccount extends Entity
{

	/**
	 * Fields that can be mass assigned using newEntity() or patchEntity().
	 *
	 * Note that when '*' is set to true, this allows all unspecified fields to
	 * be mass assigned. For security purposes, it is advised to set '*' to false
	 * (or remove it), and explicitly make individual fields accessible as needed.
	 *
	 * @var array
	 */
	protected $_accessible = [
		'user_id' => true,
		'access_token' => true,
		'item_id' => true,
		'created' => true,
		'modified' => true,
		'user' => true
	];

	protected $_virtual =[
		'balances'
	];

	public function _getBalances() {
		$table = TableRegistry::get($this->getSource());
		return $table->getAccountBalance($this);
	}
}

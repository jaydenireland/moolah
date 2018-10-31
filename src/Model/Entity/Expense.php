<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use \Recurr;
use Cake\I18n\Time;
/**
* Expense Entity
*
* @property int $id
* @property int $user_id
* @property string $rrule
* @property \Cake\I18n\FrozenDate $start_date
* @property \Cake\I18n\FrozenDate $end_date
* @property float $amount
*
* @property \App\Model\Entity\User $user
*/
class Expense extends Entity
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
		'rrule' => true,
		'start_date' => true,
		'end_date' => true,
		'amount' => true,
		'user' => true
	];

	protected $_virtual = [
		'human_readable', 'array'
	];

	protected $nextKey = 0;

	protected function _getHumanReadable() {
		$rule = $this->_getRRule();
		$textTransformer = new \Recurr\Transformer\TextTransformer();
		return $textTransformer->transform($rule);
	}

	public function _getNext($limit = 10) {
		$rule = $this->_getRRule();
		return (new \Recurr\Transformer\ArrayTransformer)->transform($rule)->map(function($e) {
			return new Time($e->getStart());
		})->slice($this->nextKey, $limit);
	}

	/**
	* Magic getter to allow for magic next{length} getter
	*/
	public function &__get($property) {
		if (substr($property, 0, 4) == 'next') {
			$length = substr($property, 4, strlen($property));
			$next = $this->_getNext($length);
			$this->nextKey += $length;
			return $next;
		}
		return parent::__get($property);
	}

	protected function _getRRule() {
		return new \Recurr\Rule(
			$this->_properties['rrule'],
			$this->_properties['start_date']
		);
	}
}

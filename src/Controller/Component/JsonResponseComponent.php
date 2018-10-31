<?php
namespace App\Controller\Component;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Utility\Hash;
use Cake\Core\Configure;
/**
 * JsonResponse component
 */
class JsonResponseComponent extends Component
{
	/**
	 * Default configuration.
	 *
	 * @var array
	 */
	protected $_defaultConfig = [];
	protected $_redirect = null;
	protected $_data = [];
	protected $_status = 200;
	protected $_headers = [];
	/**
	* JSON response method. Use to standardize json responses.
	*
	* [
	* 'success' => 'OK',
	* 'data' => [
	*		'key' => 'value'
	*		 ],
	* 'paginate' => [
	*		'currentPage' => 0,
	*		'maxPages' => 0,
	*		...
	*		]
	* ]
	* @param array|mixed $data Data to output
	* @param int $responseCode Response code to respond with
	*
	* @return \Cake\HTTP\Response JSON encoded response
	*/
	public function response($data = [], $responseCode = null) {
		if (is_null($responseCode)) $responseCode = $this->_status;
		$data = Hash::merge($data ?? [], $this->_data);
		$responseData = [
			'success' => ($responseCode == 200) ? 'OK' : 'NOT OK',
			'data' => $data,
			'paginate' => $this->request->getParam('paging') ?? null,
			'flash' => $this->request->getSession()->read('Flash.flash'),
			'global' => $this->globalData,
			'redirect' => $this->_redirect
		];
		if (Configure::read('debug')) {
			$responseData['location'] = [
							'action' => $this->request->getParam('action'),
							'controller' => $this->request->getParam('controller')
						];
		}
		foreach ($this->_headers as $key => $val) {
			$this->response = $this->response->withHeader($key, $val);
		}
		$this->response = $this->response->withHeader('Access-Control-Expose-Headers', implode(',', array_keys($this->_headers)));
		$this->response = $this->response->withStatus($responseCode)->withType("application/json")->withStringBody(json_encode($responseData));
		return $this->response;
	}
	public function redirect($arr) {
		$this->_redirect = $arr;
	}
	public function addData($data) {
		$this->_data = Hash::merge($this->_data, $data);
	}
	public function setStatus($int) {
		$this->_status = $int;
	}
	public function addHeader($key, $val) {
		$this->_headers[$key] = $val;
	}
}

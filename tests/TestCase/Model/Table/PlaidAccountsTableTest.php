<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PlaidAccountsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PlaidAccountsTable Test Case
 */
class PlaidAccountsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PlaidAccountsTable
     */
    public $PlaidAccounts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.plaid_accounts',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PlaidAccounts') ? [] : ['className' => PlaidAccountsTable::class];
        $this->PlaidAccounts = TableRegistry::getTableLocator()->get('PlaidAccounts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PlaidAccounts);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

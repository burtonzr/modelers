<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PiwigoUsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PiwigoUsersTable Test Case
 */
class PiwigoUsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PiwigoUsersTable
     */
    protected $PiwigoUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.PiwigoUsers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PiwigoUsers') ? [] : ['className' => PiwigoUsersTable::class];
        $this->PiwigoUsers = TableRegistry::getTableLocator()->get('PiwigoUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PiwigoUsers);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

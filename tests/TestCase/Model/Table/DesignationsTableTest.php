<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DesignationsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DesignationsTable Test Case
 */
class DesignationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DesignationsTable
     */
    protected $Designations;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Designations',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Designations') ? [] : ['className' => DesignationsTable::class];
        $this->Designations = $this->getTableLocator()->get('Designations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Designations);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DesignationsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

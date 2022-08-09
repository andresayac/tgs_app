<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TrainingsAssistancesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TrainingsAssistancesTable Test Case
 */
class TrainingsAssistancesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TrainingsAssistancesTable
     */
    protected $TrainingsAssistances;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.TrainingsAssistances',
        'app.Trainings',
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
        $config = $this->getTableLocator()->exists('TrainingsAssistances') ? [] : ['className' => TrainingsAssistancesTable::class];
        $this->TrainingsAssistances = $this->getTableLocator()->get('TrainingsAssistances', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->TrainingsAssistances);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\TrainingsAssistancesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\TrainingsAssistancesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

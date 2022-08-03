<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TrainingsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TrainingsTable Test Case
 */
class TrainingsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TrainingsTable
     */
    protected $Trainings;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Trainings',
        'app.TrainingsAssistances',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Trainings') ? [] : ['className' => TrainingsTable::class];
        $this->Trainings = $this->getTableLocator()->get('Trainings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Trainings);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\TrainingsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

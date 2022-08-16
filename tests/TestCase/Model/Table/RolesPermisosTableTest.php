<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RolesPermisosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RolesPermisosTable Test Case
 */
class RolesPermisosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RolesPermisosTable
     */
    protected $RolesPermisos;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.RolesPermisos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('RolesPermisos') ? [] : ['className' => RolesPermisosTable::class];
        $this->RolesPermisos = $this->getTableLocator()->get('RolesPermisos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->RolesPermisos);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\RolesPermisosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

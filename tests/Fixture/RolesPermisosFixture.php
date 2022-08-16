<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RolesPermisosFixture
 */
class RolesPermisosFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'modulo_padre' => 'Lorem ipsum dolor sit amet',
                'modulo_hijo' => 'Lorem ipsum dolor sit amet',
                'roles' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}

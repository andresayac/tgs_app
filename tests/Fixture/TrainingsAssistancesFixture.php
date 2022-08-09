<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TrainingsAssistancesFixture
 */
class TrainingsAssistancesFixture extends TestFixture
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
                'training_id' => 1,
                'user_id' => 1,
                'checked' => 1,
                'type_check' => 'Lorem ipsum dolor sit amet',
                'created_by' => 1,
                'modified_by' => 1,
                'created' => '2022-08-08 18:39:38',
                'modified' => '2022-08-08 18:39:38',
            ],
        ];
        parent::init();
    }
}

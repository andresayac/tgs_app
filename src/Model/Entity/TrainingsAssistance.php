<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TrainingsAssistance Entity
 *
 * @property int $id
 * @property int|null $training_id
 * @property string|null $users
 *
 * @property \App\Model\Entity\Training $training
 */
class TrainingsAssistance extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'training_id' => true,
        'users' => true,
        'training' => true,
    ];
}

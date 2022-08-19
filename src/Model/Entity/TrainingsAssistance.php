<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TrainingsAssistance Entity
 *
 * @property int $id
 * @property int|null $training_id
 * @property int|null $user_id
 * @property int|null $checked
 * @property string|null $type_check
 * @property int|null $created_by
 * @property int|null $modified_by
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Training $training
 * @property \App\Model\Entity\User $user
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
        'user_id' => true,
        'checked' => true,
        'type_check' => true,
        'check_ts' => true,
        'created_by' => true,
        'modified_by' => true,
        'created' => true,
        'modified' => true
    ];
}

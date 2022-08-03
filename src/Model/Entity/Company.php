<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Company Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $address
 * @property string|null $city
 * @property string|null $state
 * @property int|null $zipcode
 * @property string|null $country
 * @property string|null $logo
 * @property int|null $active
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 */
class Company extends Entity
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
        'name' => true,
        'address' => true,
        'city' => true,
        'state' => true,
        'zipcode' => true,
        'country' => true,
        'logo' => true,
        'active' => true,
        'created' => true,
        'modified' => true,
    ];
}

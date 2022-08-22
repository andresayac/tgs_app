<?php
declare(strict_types=1);

namespace App\Model\Entity;
use Cake\Auth\DefaultPasswordHasher;


use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property int|null $rol_id
 * @property string|null $username
 * @property string|null $password
 * @property string|null $fullname
 * @property string|null $document_type
 * @property string|null $document
 * @property \Cake\I18n\FrozenDate|null $date_birthday
 * @property string|null $telephone
 * @property int|null $active
 * @property int|null $dep_id
 * @property int|null $branch_id
 * @property int|null $designation_id
 * @property string|null $indexfinger
 * @property string|null $middlefinger
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Role $role
 * @property \App\Model\Entity\Departament $departament
 * @property \App\Model\Entity\Branch $branch
 * @property \App\Model\Entity\Designation $designation
 */
class User extends Entity
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
        'rol_id' => true,
        'username' => true,
        'password' => true,
        'fullname' => true,
        'document_type' => true,
        'document' => true,
        'date_birthday' => true,
        'telephone' => true,
        'manual_assistance' => true,
        'active' => true,
        'dep_id' => true,
        'branch_id' => true,
        'designation_id' => true,
        'indexfinger' => true,
        'middlefinger' => true,
        'created' => true,
        'modified' => true,
        'role' => true,
        'departament' => true,
        'branch' => true,
        'designation' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array<string>
     */
    protected $_hidden = [
        'password',
    ];

    protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher)->hash($password);
        }
    }
}

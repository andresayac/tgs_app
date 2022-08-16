<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RolesPermisos Model
 *
 * @method \App\Model\Entity\RolesPermiso newEmptyEntity()
 * @method \App\Model\Entity\RolesPermiso newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\RolesPermiso[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RolesPermiso get($primaryKey, $options = [])
 * @method \App\Model\Entity\RolesPermiso findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\RolesPermiso patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RolesPermiso[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\RolesPermiso|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RolesPermiso saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RolesPermiso[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\RolesPermiso[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\RolesPermiso[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\RolesPermiso[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class RolesPermisosTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('roles_permisos');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('modulo_padre')
            ->maxLength('modulo_padre', 255)
            ->allowEmptyString('modulo_padre');

        $validator
            ->scalar('modulo_hijo')
            ->maxLength('modulo_hijo', 255)
            ->allowEmptyString('modulo_hijo');

        $validator
            ->scalar('roles')
            ->maxLength('roles', 255)
            ->allowEmptyString('roles');

        return $validator;
    }
}

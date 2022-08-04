<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 * @property \App\Model\Table\DepartamentsTable&\Cake\ORM\Association\BelongsTo $Departaments
 * @property \App\Model\Table\BranchsTable&\Cake\ORM\Association\BelongsTo $Branchs
 * @property \App\Model\Table\DesignationsTable&\Cake\ORM\Association\BelongsTo $Designations
 *
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Roles', [
            'foreignKey' => 'rol_id',
        ]);
        $this->belongsTo('Departaments', [
            'foreignKey' => 'dep_id',
        ]);
        $this->belongsTo('Branchs', [
            'foreignKey' => 'branch_id',
        ]);
        $this->belongsTo('Designations', [
            'foreignKey' => 'designation_id',
        ]);
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
            ->integer('rol_id')
            ->allowEmptyString('rol_id');

        $validator
            ->scalar('username')
            ->maxLength('username', 65)
            ->allowEmptyString('username');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->allowEmptyString('password');

        $validator
            ->scalar('name')
            ->maxLength('name', 65)
            ->allowEmptyString('name');

        $validator
            ->scalar('lastname')
            ->maxLength('lastname', 65)
            ->allowEmptyString('lastname');

        $validator
            ->scalar('document_type')
            ->maxLength('document_type', 4)
            ->allowEmptyString('document_type');

        $validator
            ->scalar('document')
            ->maxLength('document', 44)
            ->allowEmptyString('document');

        $validator
            ->date('date_birthday')
            ->allowEmptyDate('date_birthday');

        $validator
            ->scalar('telephone')
            ->maxLength('telephone', 11)
            ->allowEmptyString('telephone');

        $validator
            ->integer('active')
            ->allowEmptyString('active');

        $validator
            ->integer('dep_id')
            ->allowEmptyString('dep_id');

        $validator
            ->integer('branch_id')
            ->allowEmptyString('branch_id');

        $validator
            ->integer('designation_id')
            ->allowEmptyString('designation_id');

        $validator
            ->scalar('indexfinger')
            ->allowEmptyString('indexfinger');

        $validator
            ->scalar('middlefinger')
            ->allowEmptyString('middlefinger');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['username']), ['errorField' => 'username']);
        $rules->add($rules->existsIn('rol_id', 'Roles'), ['errorField' => 'rol_id']);
        $rules->add($rules->existsIn('dep_id', 'Departaments'), ['errorField' => 'dep_id']);
        $rules->add($rules->existsIn('branch_id', 'Branchs'), ['errorField' => 'branch_id']);
        $rules->add($rules->existsIn('designation_id', 'Designations'), ['errorField' => 'designation_id']);

        return $rules;
    }
}
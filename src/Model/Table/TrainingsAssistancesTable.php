<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TrainingsAssistances Model
 *
 * @property \App\Model\Table\TrainingsTable&\Cake\ORM\Association\BelongsTo $Trainings
 *
 * @method \App\Model\Entity\TrainingsAssistance newEmptyEntity()
 * @method \App\Model\Entity\TrainingsAssistance newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\TrainingsAssistance[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TrainingsAssistance get($primaryKey, $options = [])
 * @method \App\Model\Entity\TrainingsAssistance findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\TrainingsAssistance patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TrainingsAssistance[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\TrainingsAssistance|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TrainingsAssistance saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TrainingsAssistance[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\TrainingsAssistance[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\TrainingsAssistance[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\TrainingsAssistance[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class TrainingsAssistancesTable extends Table
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

        $this->setTable('trainings_assistances');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Trainings', [
            'foreignKey' => 'training_id',
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
            ->integer('training_id')
            ->allowEmptyString('training_id');

        $validator
            ->scalar('users')
            ->maxLength('users', 16777215)
            ->allowEmptyString('users');

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
        $rules->add($rules->existsIn('training_id', 'Trainings'), ['errorField' => 'training_id']);

        return $rules;
    }
}

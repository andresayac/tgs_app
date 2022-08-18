<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Trainings Model
 *
 * @property \App\Model\Table\TrainingsAssistancesTable&\Cake\ORM\Association\HasMany $TrainingsAssistances
 *
 * @method \App\Model\Entity\Training newEmptyEntity()
 * @method \App\Model\Entity\Training newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Training[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Training get($primaryKey, $options = [])
 * @method \App\Model\Entity\Training findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Training patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Training[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Training|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Training saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Training[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Training[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Training[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Training[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TrainingsTable extends Table
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

        $this->setTable('trainings');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->addBehavior('Search.Search');

        $this->hasMany('TrainingsAssistances', [
            'foreignKey' => 'training_id',
        ]);

        // busqueda y filtros
        $this->searchManager()
            ->add('start_date', 'Search.Compare', [
                'operator' => '>=',
            ])
            ->add('end_date', 'Search.Compare', [
                'operator' => '<=',
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
            ->dateTime('start_date')
            ->notEmptyString('start_date', 'Fecha requerida');

        $validator
            ->dateTime('end_date')
            ->notEmptyString('end_date', 'Hora Fin requerida');

        $validator
            ->scalar('name')
            ->maxLength('name', 65)
            ->notEmptyString('name', 'Nombre requerido');

        $validator
            ->scalar('note')
            ->maxLength('note', 16777215)
            ->allowEmptyString('note');

        $validator
            ->scalar('trainer')
            ->maxLength('trainer', 16777215)
            ->notEmptyString('trainer', 'Capacitador requerido');

        $validator
            ->integer('active')
            ->allowEmptyString('active');

        return $validator;
    }
}

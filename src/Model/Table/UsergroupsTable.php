<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Usergroups Model
 *
 * @method \App\Model\Entity\Usergroup newEmptyEntity()
 * @method \App\Model\Entity\Usergroup newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Usergroup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Usergroup get($primaryKey, $options = [])
 * @method \App\Model\Entity\Usergroup findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Usergroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Usergroup[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Usergroup|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Usergroup saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Usergroup[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Usergroup[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Usergroup[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Usergroup[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class UsergroupsTable extends Table
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

        $this->setTable('usergroups');
        $this->setDisplayField('ID');
        $this->setPrimaryKey('ID');
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
            ->integer('ID')
            ->allowEmptyString('ID', null, 'create');

        $validator
            ->scalar('Name')
            ->maxLength('Name', 25)
            ->requirePresence('Name', 'create')
            ->notEmptyString('Name');

        return $validator;
    }
}

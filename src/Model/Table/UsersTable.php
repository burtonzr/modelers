<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table {
    
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Statuses', [
            'foreignKey' => 'status_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('Usergroups', [
            'foreignKey' => 'UserGroupID',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('Submissions', [
            'foreignKey' => 'user_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->nonNegativeInteger('forum_user')
            ->allowEmptyString('forum_user');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->boolean('public_yn')
            ->notEmptyString('public_yn');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->scalar('last_ip')
            ->maxLength('last_ip', 20)
            ->requirePresence('last_ip', 'create')
            ->notEmptyString('last_ip');

        $validator
            ->scalar('password')
            ->maxLength('password', 25)
            ->allowEmptyString('password');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker {
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['status_id'], 'Statuses'));
        $rules->add($rules->existsIn(['UserGroupID'], 'Usergroups'));

        return $rules;
    }
}

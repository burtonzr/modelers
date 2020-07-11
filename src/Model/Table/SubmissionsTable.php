<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class SubmissionsTable extends Table {
   
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('submissions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ModelTypes', [
            'foreignKey' => 'model_type_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('SubmissionCategories', [
            'foreignKey' => 'submission_category_id',
        ]);
        $this->belongsTo('Manufacturers', [
            'foreignKey' => 'manufacturer_id',
        ]);
        $this->belongsTo('Scales', [
            'foreignKey' => 'scale_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Statuses', [
            'foreignKey' => 'status_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Images', [
            'foreignKey' => 'submission_id',
        ]);
        $this->hasMany('SubmissionFieldValues', [
            'foreignKey' => 'submission_id',
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
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('subject')
            ->maxLength('subject', 255)
            ->requirePresence('subject', 'create')
            ->notEmptyString('subject');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->dateTime('approved')
            ->allowEmptyDateTime('approved');

        $validator
            ->allowEmptyFile('image_path')
            ->add( 'image_path', [
                'mimeType' => [
                    'rule' => [ 'mimeType', [ 'image/jpg', 'image/png', 'image/jpeg' ] ],
                    'message' => 'Please upload only jpg and png.',
                ],
                'fileSize' => [
                    'rule' => [ 'fileSize', '<=', '1MB' ],
                    'message' => 'Image file size must be less than 1MB.',
                ]
            ]);

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['model_type_id'], 'ModelTypes'));
        $rules->add($rules->existsIn(['submission_category_id'], 'SubmissionCategories'));
        $rules->add($rules->existsIn(['manufacturer_id'], 'Manufacturers'));
        $rules->add($rules->existsIn(['scale_id'], 'Scales'));
        $rules->add($rules->existsIn(['status_id'], 'Statuses'));

        return $rules;
    }
}

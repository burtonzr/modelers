<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use \Cake\Database\Expression\QueryExpression;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class ModelTypesController extends AppController {
    
    public function index() {
        $this->paginate = [
            'contain' => ['Statuses'],
        ];

        $this->loadModel('Submissions');
        $submissions = $this->Submissions->query('SELECT * FROM `submissions` ORDER BY ID DESC');
        $modelTypes  = $this->ModelTypes->query('SELECT * FROM `model_types` ORDER BY ID ASC');
        $submissions = $this->paginate($this->Submissions);

        $this->set('submissionsData', $submissions);
        $this->set(compact('modelTypes'));
    }

    public function view($id = null) {
        /*
        $modelType = $this->ModelTypes->get($id, [
            'contain' => ['Statuses', 'SubmissionCategories', 'SubmissionFields', 'Submissions'],
        ]);
        
        $this->loadModel('Submissions');
        $this->loadModel('SubmissionCategories');
        $count = $this->SubmissionCategories->find('all')->count();
        $top3Submissions = $this->Submissions->find('all', array(
            'order' => array('id' => 'DESC')
        ))->toList();
        $this->set(compact('modelType', 'top3Submissions'));
        */
        $this->paginate = [
            'contain' => ['ModelTypes', 'Statuses'],
        ];
        $this->loadModel('Submissions');
        $this->loadModel('Scales');
        $this->loadModel('Users');
        $this->loadModel('Manufacturers');
        $this->loadModel('SubmissionCategories');
        $submissions          = $this->Submissions->find('all')->where(['model_type_id' => '1'])->order(['Submissions.id' => 'DESC']);
        $scales               = $this->Scales->find('all')->order(['Scales.id' => 'ASC']);
        $users                = $this->Users->find('all')->order(['Users.id' => 'ASC']);
        $manufacturers        = $this->Manufacturers->find('all')->order(['Manufacturers.id' => 'ASC']);
        $submissionCategories = $this->SubmissionCategories->find('all')->where(['model_type_id' => '1'])->order(['SubmissionCategories.title' => 'ASC']);
        $filterScales         = $this->Scales->find('list', [
            'keyField' => 'id',
            'valueField' => 'scale'
        ])->where(['model_type_id' => '1'])->toArray();
        $filterManufacturer = $this->Manufacturers->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])->toArray();
        $this->set('submissions', $this->paginate($submissions, ['limit' => '25']));
        $this->set('scales', $scales);
        $this->set('users', $users);
        $this->set('manufacturers', $manufacturers);
        $this->set('filterManufacturer', $filterManufacturer);
        $this->set('filterScales', $filterScales);
        $this->set(compact('submissionCategories'));
    }

    public function search() {
        $this->request->allowMethod('ajax');
        $this->loadModel('Submissions');
        $this->loadModel('Scales');
        $this->loadModel('Users');
        $this->loadModel('Manufacturers');

        $scaleFilter        = $this->request->getQuery('scale');
        $manufacturerFilter = $this->request->getQuery('manufacturer');
        $categoryFilter     = $this->request->getQuery('category');
        $scales             = $this->Scales->find('all')->order(['Scales.id' => 'ASC']);
        $users              = $this->Users->find('all')->order(['Users.id' => 'ASC']);
        $submissions        = $this->Submissions->find('all')->order(['Submissions.id' => 'DESC']);
        $manufacturers      = $this->Manufacturers->find('all')->order(['Manufacturers.id' => 'ASC']);
        if($scaleFilter === '0' && $manufacturerFilter === '0' && $categoryFilter === '0') {
            $query = $submissions->find('all')->where(['model_type_id' => '1']); 
        } else {
            $query = $submissions->find('all')->where(function(QueryExpression $exp, Query $query) {
                $scaleFilter        = $this->request->getQuery('scale');
                $manufacturerFilter = $this->request->getQuery('manufacturer');
                $categoryFilter     = $this->request->getQuery('category');
                $count              = 0;
                if($scaleFilter !== '0') {
                    $count++;
                }
                if($manufacturerFilter !== '0') {
                    $count++;
                }
                if($categoryFilter !== '0') {
                    $count++;
                }
                $and_manufacturer = $query->newExpr()->add(['manufacturer_id = ' . $manufacturerFilter])->add(['model_type_id = ' . '1']);
                $and_filter1      = $query->newExpr()->add(['scale_id = ' . $scaleFilter])->add(['manufacturer_id = ' . $manufacturerFilter])->add(['submission_category_id = ' . $categoryFilter])->add(['model_type_id = ' . '1']);
                $and_filter2      = $query->newExpr()->add(['scale_id = ' . $scaleFilter])->add(['manufacturer_id = ' . $manufacturerFilter])->add(['model_type_id = ' . '1']);
                $and_filter3      = $query->newExpr()->add(['scale_id = ' . $scaleFilter])->add(['submission_category_id = ' . $categoryFilter])->add(['model_type_id = ' . '1']);
                $and_filter4      = $query->newExpr()->add(['manufacturer_id = ' . $manufacturerFilter])->add(['submission_category_id = ' . $categoryFilter])->add(['model_type_id = ' . '1']);
                if($count === 1) {
                    if($manufacturerFilter !== '0') {
                        return $exp->or([
                            $query->newExpr()->and([$and_manufacturer]),
                        ]);
                    }
                    if($manufacturerFilter === '0') {
                        return $exp->or([
                            'submission_category_id = ' . $categoryFilter,
                            'scale_id = ' . $scaleFilter
                        ]); 
                    }
                } else if($count === 2) {
                    if($scaleFilter !== '0' && $manufacturerFilter !== '0') {
                        return $exp->or([
                            $query->newExpr()->and([$and_filter2]),
                        ]);
                    }
                    if($scaleFilter !== '0' && $categoryFilter !== '0') {
                        return $exp->or([
                            $query->newExpr()->and([$and_filter3]),
                        ]);
                    }
                    if($manufacturerFilter !== 0 && $categoryFilter !== '0') {
                        return $exp->or([
                            $query->newExpr()->and([$and_filter4])
                        ]);
                    }
                } else if($count === 3) {
                    return $exp->or([
                        $query->newExpr()->and([$and_filter1]),
                    ]);
                }
            });
        }
        $this->set('submissions', $this->paginate($query));
        $this->set('scales', $scales);
        $this->set('users', $users);
        $this->set('manufacturers', $manufacturers);
        $this->set('_serialize', ['submissions']);
    }

    public function add() {
        if($this->Auth->user('UserGroupID') == 3) {
            $modelType = $this->ModelTypes->newEmptyEntity();
            if ($this->request->is('post')) {
                $modelType = $this->ModelTypes->patchEntity($modelType, $this->request->getData());
                if ($this->ModelTypes->save($modelType)) {
                    $this->Flash->success(__('The model type has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The model type could not be saved. Please, try again.'));
            }
            $statuses = $this->ModelTypes->Statuses->find('list', ['limit' => 200]);
            $this->set(compact('modelType', 'statuses'));
        } else {
            return $this->redirect(array('controller' => 'ModelTypes', 'action' => 'index'));
        }
    }

    public function edit($id = null) {
        if($this->Auth->user('UserGroupID') == 3) {
            $modelType = $this->ModelTypes->get($id, [
                'contain' => [],
            ]);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $modelType = $this->ModelTypes->patchEntity($modelType, $this->request->getData());
                if ($this->ModelTypes->save($modelType)) {
                    $this->Flash->success(__('The model type has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The model type could not be saved. Please, try again.'));
            }
            $statuses = $this->ModelTypes->Statuses->find('list', ['limit' => 200]);
            $this->set(compact('modelType', 'statuses'));
        } else {
            return $this->redirect(array('controller' => 'ModelTypes', 'action' => 'index'));
        }
    }

    public function beforeFilter(EventInterface $event) {
        parent::beforeFilter($event);

        $this->Auth->allow(['index', 'view']);
    }
}

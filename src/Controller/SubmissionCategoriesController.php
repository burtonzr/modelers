<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use \Cake\Database\Expression\QueryExpression;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class SubmissionCategoriesController extends AppController {
    
    public function index() {
        $this->paginate = [
            'contain' => ['ModelTypes', 'Statuses'],
        ];

        $this->loadModel('Submissions');
        $this->loadModel('Scales');
        $this->loadModel('Users');
        $this->loadModel('Manufacturers');
        $submissions          = $this->Submissions->find('all')->order(['Submissions.id' => 'DESC']);
        $scales               = $this->Scales->find('all')->order(['Scales.id' => 'ASC']);
        $users                = $this->Users->find('all')->order(['Users.id' => 'ASC']);
        $manufacturers        = $this->Manufacturers->find('all')->order(['Manufacturers.id' => 'ASC']);
        $submissionCategories = $this->SubmissionCategories->find('all')->order(['SubmissionCategories.title' => 'ASC']);
        $filterScales         = $this->Scales->find('list', [
            'keyField' => 'id',
            'valueField' => 'scale'
        ])->toArray();
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

        $scales        = $this->Scales->find('all')->order(['Scales.id' => 'ASC']);
        $users         = $this->Users->find('all')->order(['Users.id' => 'ASC']);
        $submissions   = $this->Submissions->find('all')->order(['Submissions.id' => 'ASC']);
        $manufacturers = $this->Manufacturers->find('all')->order(['Manufacturers.id' => 'ASC']);
        
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
            $and_filter1 = $query->newExpr()->add(['scale_id = ' . $scaleFilter])->add(['manufacturer_id = ' . $manufacturerFilter])->add(['submission_category_id = ' . $categoryFilter]);
            $and_filter2 = $query->newExpr()->add(['scale_id = ' . $scaleFilter])->add(['manufacturer_id = ' . $manufacturerFilter]);
            $and_filter3 = $query->newExpr()->add(['scale_id = ' . $scaleFilter])->add(['submission_category_id = ' . $categoryFilter]);
            $and_filter4 = $query->newExpr()->add(['manufacturer_id = ' . $manufacturerFilter])->add(['submission_category_id = ' . $categoryFilter]);
            if($count === 1) {
                return $exp->or([
                    'submission_category_id = ' . $categoryFilter,
                    'scale_id = ' . $scaleFilter,
                    'manufacturer_id = ' . $manufacturerFilter,
                ]); 
            } else if($count === 2) {
                return $exp->or([
                    $query->newExpr()->and([$and_filter2]),
                ]);
            } else if($count === 3) {
                return $exp->or([
                    $query->newExpr()->and([$and_filter1]),
                ]);
            } else if($count === 0) {
                return $exp;
            }
        });
        $this->set('submissions', $this->paginate($query));
        $this->set('scales', $scales);
        $this->set('users', $users);
        $this->set('manufacturers', $manufacturers);
        $this->set('_serialize', ['submissions']);
    }

    public function view($id = null) {
        $submissionCategory = $this->SubmissionCategories->get($id, [
            'contain' => ['ParentSubmissionCategories', 'ModelTypes', 'Statuses', 'ChildSubmissionCategories', 'Submissions'],
        ]);
        $now         = Time::now();
        $currentTime = $now->year."-".$now->month."-".$now->day." ".$now->hour.":".$now->minute.":".$now->second;
        $this->loadModel('Users');
        $this->loadModel('Scales');
        $sqlScales = $this->Scales->query('SELECT s.scale_id, scales.scale FROM `submission_categories` AS sc LEFT JOIN `submissions` AS s ON s.submission_category_id = sc.id LEFT JOIN `scales` ON s.scale_id = scales.id');
        $sql       = $this->Users->query("SELECT u.Name, s.user_id FROM `submission_categories` AS sc LEFT JOIN `submissions` AS s ON s.submission_category_id = sc.id LEFT JOIN `users` AS u ON u.id = s.user_id");
        $this->set('now', $now);
        $this->set('data', $sql);
        $this->set('scalesData',  $sqlScales);

        $this->set(compact('submissionCategory'));
    }

    public function add() {
        if($this->Auth->user('UserGroupID') == 3) {
            $submissionCategory = $this->SubmissionCategories->newEmptyEntity();
            if ($this->request->is('post')) {
                $submissionCategory = $this->SubmissionCategories->patchEntity($submissionCategory, $this->request->getData());
                if ($this->SubmissionCategories->save($submissionCategory)) {
                    $this->Flash->success(__('The submission category has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The submission category could not be saved. Please, try again.'));
            }
            $parentSubmissionCategories = $this->SubmissionCategories->ParentSubmissionCategories->find('list', ['limit' => 200]);
            $modelTypes                 = $this->SubmissionCategories->ModelTypes->find('list', ['limit' => 200]);
            $statuses                   = $this->SubmissionCategories->Statuses->find('list', ['limit' => 200]);
            $this->set(compact('submissionCategory', 'parentSubmissionCategories', 'modelTypes', 'statuses'));
        } else {
            return $this->redirect(array('controller' => 'ModelTypes', 'action' => 'index'));
        }
    }

    public function edit($id = null) {
        if($this->Auth->user('UserGroupID') == 3) {
            $submissionCategory = $this->SubmissionCategories->get($id, [
                'contain' => [],
            ]);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $submissionCategory = $this->SubmissionCategories->patchEntity($submissionCategory, $this->request->getData());
                if ($this->SubmissionCategories->save($submissionCategory)) {
                    $this->Flash->success(__('The submission category has been saved.'));
    
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The submission category could not be saved. Please, try again.'));
            }
            $parentSubmissionCategories = $this->SubmissionCategories->ParentSubmissionCategories->find('list', ['limit' => 200]);
            $modelTypes = $this->SubmissionCategories->ModelTypes->find('list', ['limit' => 200]);
            $statuses = $this->SubmissionCategories->Statuses->find('list', ['limit' => 200]);
            $this->set(compact('submissionCategory', 'parentSubmissionCategories', 'modelTypes', 'statuses'));
        } else {
            return $this->redirect(array('controller' => 'ModelTypes', 'action' => 'index'));
        }
    }

    public function beforeFilter(EventInterface $event) {
        parent::beforeFilter($event);

        $this->Auth->allow(['index', 'view', 'search']);
    }
}

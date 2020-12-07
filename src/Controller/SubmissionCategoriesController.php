<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
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

        $filter        = $this->request->getQuery('filter');
        $filterType    = $this->request->getQuery('type');
        $scales        = $this->Scales->find('all')->order(['Scales.id' => 'ASC']);
        $users         = $this->Users->find('all')->order(['Users.id' => 'ASC']);
        $manufacturers = $this->Manufacturers->find('all')->order(['Manufacturers.id' => 'ASC']);

        if($filterType === 'scale') {
            $query = $this->Submissions->find('all', [
                'conditions' => ['scale_id = ' . $filter],
                'order' => ['Submissions.id' => 'DESC'],
                'limit' => '25'
            ]);
        } else if($filterType === 'manufacturer') {
            $query = $this->Submissions->find('all', [
                'conditions' => ['manufacturer_id = ' . $filter],
                'order' => ['Submissions.id' => 'DESC'],
                'limit' => '25'
            ]);
        }

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

        $this->Auth->allow(['index', 'view']);
    }
}

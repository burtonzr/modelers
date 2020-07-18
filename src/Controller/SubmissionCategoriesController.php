<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\ORM\TableRegistry;

class SubmissionCategoriesController extends AppController {
    
    public function index() {
        $this->paginate = [
            'contain' => ['ParentSubmissionCategories', 'ModelTypes', 'Statuses'],
        ];
        $submissionCategories = $this->paginate($this->SubmissionCategories);

        $this->set(compact('submissionCategories'));
    }

    public function view($id = null) {
        $submissionCategory = $this->SubmissionCategories->get($id, [
            'contain' => ['ParentSubmissionCategories', 'ModelTypes', 'Statuses', 'ChildSubmissionCategories', 'Submissions'],
        ]);
        
        $this->loadModel('Users');
        $this->loadModel('Scales');
        $sqlScales = $this->Scales->query('SELECT s.scale_id, scales.scale FROM `submission_categories` AS sc LEFT JOIN `submissions` AS s ON s.submission_category_id = sc.id LEFT JOIN `scales` ON s.scale_id = scales.id');
        $sql       = $this->Users->query("SELECT u.Name, s.user_id FROM `submission_categories` AS sc LEFT JOIN `submissions` AS s ON s.submission_category_id = sc.id LEFT JOIN `users` AS u ON u.id = s.user_id");
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
            $modelTypes = $this->SubmissionCategories->ModelTypes->find('list', ['limit' => 200]);
            $statuses = $this->SubmissionCategories->Statuses->find('list', ['limit' => 200]);
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

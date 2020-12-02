<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\ORM\TableRegistry;

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

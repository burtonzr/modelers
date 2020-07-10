<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class SubmissionCategoriesController extends AppController {
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ParentSubmissionCategories', 'ModelTypes', 'Statuses'],
        ];
        $submissionCategories = $this->paginate($this->SubmissionCategories);

        $this->set(compact('submissionCategories'));
    }

    /**
     * View method
     *
     * @param string|null $id Submission Category id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $submissionCategory = $this->SubmissionCategories->get($id, [
            'contain' => ['ParentSubmissionCategories', 'ModelTypes', 'Statuses', 'ChildSubmissionCategories', 'Submissions'],
        ]);

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

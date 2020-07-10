<?php
declare(strict_types=1);

namespace App\Controller;

class SubmissionsController extends AppController {

    public function index() {
        $this->paginate = [
            'contain' => ['Users', 'ModelTypes', 'SubmissionCategories', 'Manufacturers', 'Scales', 'Statuses'],
        ];
        $submissions = $this->paginate($this->Submissions);

        $this->set(compact('submissions'));
    }

    public function view($id = null) {
        $submission = $this->Submissions->get($id, [
            'contain' => ['Users', 'ModelTypes', 'SubmissionCategories', 'Manufacturers', 'Scales', 'Statuses', 'Images', 'SubmissionFieldValues'],
        ]);

        $this->set(compact('submission'));
    }

    public function add() {
        if($this->Auth->user('email') != null) {
            $submission = $this->Submissions->newEmptyEntity();
            if ($this->request->is('post')) {
                $submission = $this->Submissions->patchEntity($submission, $this->request->getData());
                if ($this->Submissions->save($submission)) {
                    $this->Flash->success(__('The submission has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The submission could not be saved. Please, try again.'));
            }
            $users = $this->Submissions->Users->find('list', ['limit' => 200]);
            $modelTypes = $this->Submissions->ModelTypes->find('list', ['limit' => 200]);
            $submissionCategories = $this->Submissions->SubmissionCategories->find('list', ['limit' => 200]);
            $manufacturers = $this->Submissions->Manufacturers->find('list', ['limit' => 200]);
            $scales = $this->Submissions->Scales->find('list', ['limit' => 200]);
            $statuses = $this->Submissions->Statuses->find('list', ['limit' => 200]);
            $this->set(compact('submission', 'users', 'modelTypes', 'submissionCategories', 'manufacturers', 'scales', 'statuses'));
        } else {
            return $this->redirect(array('controller' => 'Users', 'action' => 'login'));
        }
    }

    public function edit($id = null) {
        $submission = $this->Submissions->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $submission = $this->Submissions->patchEntity($submission, $this->request->getData());
            if ($this->Submissions->save($submission)) {
                $this->Flash->success(__('The submission has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The submission could not be saved. Please, try again.'));
        }
        $users = $this->Submissions->Users->find('list', ['limit' => 200]);
        $modelTypes = $this->Submissions->ModelTypes->find('list', ['limit' => 200]);
        $submissionCategories = $this->Submissions->SubmissionCategories->find('list', ['limit' => 200]);
        $manufacturers = $this->Submissions->Manufacturers->find('list', ['limit' => 200]);
        $scales = $this->Submissions->Scales->find('list', ['limit' => 200]);
        $statuses = $this->Submissions->Statuses->find('list', ['limit' => 200]);
        $this->set(compact('submission', 'users', 'modelTypes', 'submissionCategories', 'manufacturers', 'scales', 'statuses'));
    }

    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $submission = $this->Submissions->get($id);
        if ($this->Submissions->delete($submission)) {
            $this->Flash->success(__('The submission has been deleted.'));
        } else {
            $this->Flash->error(__('The submission could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

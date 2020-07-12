<?php
declare(strict_types=1);

namespace App\Controller;

class ScalesController extends AppController {
    
    public function index() {
        if($this->Auth->user('UserGroupID') == 3) {
            $this->paginate = [
                'contain' => ['ModelTypes'],
            ];
            $scales = $this->paginate($this->Scales);
    
            $this->set(compact('scales'));
        } else {
            return $this->redirect(array('controller' => 'ModelTypes', 'action' => 'index'));
        }
    }

    public function view($id = null) {
        if($this->Auth->user('UserGroupID') == 3) {
            $scale = $this->Scales->get($id, [
                'contain' => ['ModelTypes', 'Submissions'],
            ]);
    
            $this->set(compact('scale'));
        } else {
            return $this->redirect(array('controller' => 'ModelTypes', 'action' => 'index'));
        }
    }

    public function add() {
        if($this->Auth->user('UserGroupID') == 3) {
            $scale = $this->Scales->newEmptyEntity();
            if ($this->request->is('post')) {
                $scale = $this->Scales->patchEntity($scale, $this->request->getData());
                if ($this->Scales->save($scale)) {
                    $this->Flash->success(__('The scale has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The scale could not be saved. Please, try again.'));
            }
            $modelTypes = $this->Scales->ModelTypes->find('list', ['limit' => 200]);
            $this->set(compact('scale', 'modelTypes'));
        } else {
            return $this->redirect(array('controller' => 'ModelTypes', 'action' => 'index'));
        }
    }

    public function edit($id = null) {
        if($this->Auth->user('UserGroupID') == 3) {
            $scale = $this->Scales->get($id, [
                'contain' => [],
            ]);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $scale = $this->Scales->patchEntity($scale, $this->request->getData());
                if ($this->Scales->save($scale)) {
                    $this->Flash->success(__('The scale has been saved.'));
    
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The scale could not be saved. Please, try again.'));
            }
            $modelTypes = $this->Scales->ModelTypes->find('list', ['limit' => 200]);
            $this->set(compact('scale', 'modelTypes'));
        } else {
            return $this->redirect(array('controller' => 'ModelTypes', 'action' => 'index'));
        }
    }

    public function delete($id = null) {
        if($this->Auth->user('UserGroupID') == 3) {
            $this->request->allowMethod(['post', 'delete']);
            $scale = $this->Scales->get($id);
            if ($this->Scales->delete($scale)) {
                $this->Flash->success(__('The scale has been deleted.'));
            } else {
                $this->Flash->error(__('The scale could not be deleted. Please, try again.'));
            }
    
            return $this->redirect(['action' => 'index']);
        } else {
            return $this->redirect(array('controller' => 'ModelTypes', 'action' => 'index'));
        }
    }
}

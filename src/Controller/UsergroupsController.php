<?php
declare(strict_types=1);

namespace App\Controller;

class UsergroupsController extends AppController {
    
    public function index() {
        if($this->Auth->user('UserGroupID') == 3) {
            $usergroups = $this->paginate($this->Usergroups);

            $this->set(compact('usergroups'));
        } else {
            return $this->redirect(array('controller' => 'ModelTypes', 'action' => 'index'));
        }
    }

    public function view($id = null) {
        if($this->Auth->user('UserGroupID') == 3) {
            $usergroup = $this->Usergroups->get($id, [
                'contain' => ['Users'],
            ]);
    
            $this->set(compact('usergroup'));
        } else {
            return $this->redirect(array('controller' => 'ModelTypes', 'action' => 'index'));
        }
    }

    public function add() {
        if($this->Auth->user('UserGroupID') == 3) {
            $usergroup = $this->Usergroups->newEmptyEntity();
            if ($this->request->is('post')) {
                $usergroup = $this->Usergroups->patchEntity($usergroup, $this->request->getData());
                if ($this->Usergroups->save($usergroup)) {
                    $this->Flash->success(__('The usergroup has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The usergroup could not be saved. Please, try again.'));
            }
            $this->set(compact('usergroup'));
        } else {
            return $this->redirect(array('controller' => 'ModelTypes', 'action' => 'index'));
        }
    }

    public function edit($id = null) {
        if($this->Auth->user('UserGroupID') == 3) { 
            $usergroup = $this->Usergroups->get($id, [
                'contain' => [],
            ]);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $usergroup = $this->Usergroups->patchEntity($usergroup, $this->request->getData());
                if ($this->Usergroups->save($usergroup)) {
                    $this->Flash->success(__('The usergroup has been saved.'));
    
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The usergroup could not be saved. Please, try again.'));
            }
            $this->set(compact('usergroup'));
        } else {
            return $this->redirect(array('controller' => 'ModelTypes', 'action' => 'index'));
        }
    }

    public function delete($id = null) {
        if($this->Auth->user('UserGroupID') == 3) { 
            $this->request->allowMethod(['post', 'delete']);
            $usergroup = $this->Usergroups->get($id);
            if ($this->Usergroups->delete($usergroup)) {
                $this->Flash->success(__('The usergroup has been deleted.'));
            } else {
                $this->Flash->error(__('The usergroup could not be deleted. Please, try again.'));
            }

            return $this->redirect(['action' => 'index']);
        } else {
            return $this->redirect(array('controller' => 'ModelTypes', 'action' => 'index'));
        }
    }
}

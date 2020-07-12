<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;

class UsersController extends AppController {
    
    public function index() {
        if($this->Auth->user('UserGroupID') == 2 || $this->Auth->user('UserGroupID') == 3) {
            $this->paginate = [
                'contain' => ['Statuses', 'Usergroups']
            ];
            $users = $this->paginate($this->Users);
    
            $this->set(compact('users'));
        } else {
            return $this->redirect(array('controller' => 'ModelTypes', 'action' => 'index'));
        }
    }

    public function view($id = null) {
        if($this->Auth->user('UserGroupID') == 3) {
            $user = $this->Users->get($id, [
                'contain' => ['Statuses', 'Submissions'],
            ]);
    
            $this->set(compact('user'));
        } else if($this->Auth->user('id') == $id) {
            $user = $this->Users->get($id, [
                'contain' => ['Statuses', 'Submissions'],
            ]);
    
            $this->set(compact('user'));
        } else {
            return $this->redirect(array('controller' => 'ModelTypes', 'action' => 'index'));
        }
    }

    public function add() {
        if($this->Auth->user('email') == null) {
            $user = $this->Users->newEmptyEntity();
            if ($this->request->is('post')) {
                $user = $this->Users->patchEntity($user, $this->request->getData());
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('The user has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
            $statuses = $this->Users->Statuses->find('list', ['limit' => 200]);
            $this->set(compact('user', 'statuses'));
        } else {
            return $this->redirect(array('controller' => 'ModelTypes', 'action' => 'index'));
        }
    }

    public function edit($id = null) {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }

        $statuses   = array('1' => 'Active', '2' => 'Removed', '3' => 'Suspended', '4' => 'Pending', '21' => 'Banned');
        $usergroups = $this->Users->Usergroups->find()->select(['Name']);
        $usergroups = $usergroups->extract('Name')->toArray();
        $this->set(compact('user', 'statuses', 'usergroups'));
    }

    public function delete($id = null) {
        if($this->Auth->user('UserGroupID') == 3) {
            $this->request->allowMethod(['post', 'delete']);
            $user = $this->Users->get($id);
            if ($this->Users->delete($user)) {
                $this->Flash->success(__('The user has been deleted.'));
            } else {
                $this->Flash->error(__('The user could not be deleted. Please, try again.'));
            }

            return $this->redirect(['action' => 'index']);
        } else {
            return $this->redirect(array('controller' => 'ModelTypes', 'action' => 'index'));
        }
    }

    // Login
    public function login() {
        if($this->Auth->user('email') == null) {
            if($this->request->is('post')) {
                $user = $this->Auth->identify();
                if($user) {
                    $this->Auth->setUser($user);
                    if($this->Auth->user('UserGroupID') == 3) {
                        return $this->redirect($this->Auth->redirectUrl());
                    } else if ($this->Auth->user('status_id') == 21) {
                        $this->Flash->error('You have been banned from logging into the application.');
                    } else {
                        return $this->redirect(array('controller' => 'ModelTypes', 'action' => 'index'));
                    }
                } else {
                    $this->Flash->error('Your email or password is incorrect. ');
                }
            }
        } else {
            return $this->redirect(array('controller' => 'ModelTypes', 'action' => 'index'));
        }
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    public function beforeFilter(EventInterface $event) {
        parent::beforeFilter($event);

        $this->Auth->allow(['add']);
    }
}

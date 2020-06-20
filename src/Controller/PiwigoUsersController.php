<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PiwigoUsers Controller
 *
 * @property \App\Model\Table\PiwigoUsersTable $PiwigoUsers
 * @method \App\Model\Entity\PiwigoUser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PiwigoUsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $piwigoUsers = $this->paginate($this->PiwigoUsers);

        $this->set(compact('piwigoUsers'));
    }

    /**
     * View method
     *
     * @param string|null $id Piwigo User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $piwigoUser = $this->PiwigoUsers->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('piwigoUser'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $piwigoUser = $this->PiwigoUsers->newEmptyEntity();
        if ($this->request->is('post')) {
            $piwigoUser = $this->PiwigoUsers->patchEntity($piwigoUser, $this->request->getData());
            if ($this->PiwigoUsers->save($piwigoUser)) {
                $this->Flash->success(__('The piwigo user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The piwigo user could not be saved. Please, try again.'));
        }
        $this->set(compact('piwigoUser'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Piwigo User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $piwigoUser = $this->PiwigoUsers->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $piwigoUser = $this->PiwigoUsers->patchEntity($piwigoUser, $this->request->getData());
            if ($this->PiwigoUsers->save($piwigoUser)) {
                $this->Flash->success(__('The piwigo user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The piwigo user could not be saved. Please, try again.'));
        }
        $this->set(compact('piwigoUser'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Piwigo User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $piwigoUser = $this->PiwigoUsers->get($id);
        if ($this->PiwigoUsers->delete($piwigoUser)) {
            $this->Flash->success(__('The piwigo user has been deleted.'));
        } else {
            $this->Flash->error(__('The piwigo user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

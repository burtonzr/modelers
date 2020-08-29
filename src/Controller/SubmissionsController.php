<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\DataSource\ConnectionManager;
use Cake\I18n\Time;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

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

        $this->loadModel('Scales');
        $sqlScales = $this->Scales->query('SELECT s.scale_id, scales.scale FROM `submissions` AS s LEFT JOIN `scales` ON s.scale_id = scales.id');
        $this->set('scalesData', $sqlScales);

        $this->set(compact('submission'));
    }

    public function add() {
        if($this->Auth->user('email') != null) {
            $submission = $this->Submissions->newEmptyEntity();
            if ($this->request->is('post')) {

                $submission = $this->Submissions->patchEntity($submission, $this->request->getData());

                if(!$submission->getErrors()) {

                    $now = Time::now();
                    if($now->month === 1) {
                        $month  = "January";
                        $folder = $month.$now->year;
                    } else if($now->month === 2) {
                        $month  = "February";
                        $folder = $month.$now->year;
                    } else if($now->month === 3) {
                        $month  = "March";
                        $folder = $month.$now->year;
                    } else if($now->month === 4) {
                        $month  = "April";
                        $folder = $month.$now->year;
                    } else if($now->month === 5) {
                        $month  = "May";
                        $folder = $month.$now->year;
                    } else if($now->month === 6) {
                        $month  = "June";
                        $folder = $month.$now->year;
                    } else if($now->month === 7) {
                        $month  = "July";
                        $folder = $month.$now->year;
                    } else if($now->month === 8) {
                        $month  = "August";
                        $folder = $month.$now->year;
                    } else if($now->month === 9) {
                        $month  = "September";
                        $folder = $month.$now->year;
                    } else if($now->month === 10) {
                        $month  = "October";
                        $folder = $month.$now->year;
                    } else if($now->month === 11) {
                        $month  = "November";
                        $folder = $month.$now->year;
                    } else if($now->month === 12) {
                        $month  = "December";
                        $folder = $month.$now->year;
                    }

                    if(!is_dir(WWW_ROOT.'img'.DS.$folder)) {
                        mkdir(WWW_ROOT.'img'.DS.$folder, 0775);
                    }

                    if(!is_dir(WWW_ROOT.'img2'.DS.$folder)) {
                        mkdir(WWW_ROOT.'img2'.DS.$folder, 0775);
                    }

                    $image  = $this->request->getData('image_file');
                    $name   = $image->getClientFilename();
                    $image->moveTo(WWW_ROOT.'img'.DS.$folder.DS.$name);
                    $submission->image_path = $folder.'/'.$name;

                    $image2 = $this->request->getData('image_path2');
                    $name2  = $image2->getClientFilename();
                    $image2->moveTo(WWW_ROOT.'img2'.DS.$folder.DS.$name2);
                    $submission->image_path2 = $folder.'/'.$name2;
                }

                if($this->Submissions->save($submission)) {
                    if($this->Auth->user('UserGroupID') == 3 || $this->Auth->user('UserGroupID') == 2) {
                        $this->Flash->success(__('The submission has been saved.'));
                        return $this->redirect(['action' => 'index']);
                    } else {
                        $this->Flash->success(__('The submission has been saved.'));
                        return $this->redirect(array('controller' => 'ModelTypes', 'action' => 'index'));
                    }
                } else {
                    $this->Flash->error(__('The submission could not be saved. Make sure that the file is an image with these file extensions (jpg, jpeg, png).'));
                }
            }

            $users                = $this->Submissions->Users->find('list', ['limit' => 200]);
            $modelTypes           = $this->Submissions->ModelTypes->find('list', ['limit' => 200]);
            $manufacturers        = $this->Submissions->Manufacturers->find('list', ['limit' => 200]);
            $statuses             = $this->Submissions->Statuses->find('list', ['limit' => 200]);
            $this->set(compact('submission', 'users', 'modelTypes', 'manufacturers', 'statuses'));
        } else {
            return $this->redirect(array('controller' => 'Users', 'action' => 'login'));
        }
    }

    public function scalesNaval() {
        $scalesAircraftIDs    = array(8, 9, 10, 11, 12, 13, 14);
        $scalesNaval          = $this->Submissions->Scales->find('all', array('conditions' => $scalesAircraftIDs))->select(['scale'])->where(['model_type_id' => 1]);
        $scalesNaval          = $scalesNaval->extract('scale')->toArray();   
        $this->set(compact('submission', 'scalesNaval'));
    }

    public function scalesAircraft() {
        $scalesAircraftIDs    = array(8, 9, 10, 11, 12, 13, 14);
        $scalesAircraft       = $this->Submissions->Scales->find('all', array('conditions' => $scalesAircraftIDs))->select(['scale'])->where(['model_type_id' => 2]);
        $scalesAircraft       = $scalesAircraft->extract('scale')->toArray();
        $this->set(compact('submission', 'scalesAircraft'));
    }

    public function scalesArmor() {
        $scalesAircraftIDs    = array(8, 9, 10, 11, 12, 13, 14);
        $scalesArmor          = $this->Submissions->Scales->find('all', array('conditions' => $scalesAircraftIDs))->select(['scale'])->where(['model_type_id' => 4]);
        $scalesArmor          = $scalesArmor->extract('scale')->toArray();
        $this->set(compact('submission', 'scalesArmor'));
    }

    public function scalesAutomotive() {
        $scalesAircraftIDs    = array(8, 9, 10, 11, 12, 13, 14);
        $scalesAutomotive     = $this->Submissions->Scales->find('all', array('conditions' => $scalesAircraftIDs))->select(['scale'])->where(['model_type_id' => 3]);
        $scalesAutomotive     = $scalesAutomotive->extract('scale')->toArray();
        $this->set(compact('submission', 'scalesAutomotive'));
    }

    public function scalesDioramas() {
        $scalesAircraftIDs    = array(8, 9, 10, 11, 12, 13, 14);
        $scalesDioramas       = $this->Submissions->Scales->find('all', array('conditions' => $scalesAircraftIDs))->select(['scale'])->where(['model_type_id' => 7]);
        $scalesDioramas       = $scalesDioramas->extract('scale')->toArray();
        $this->set(compact('submission', 'scalesDioramas'));
    }

    public function scalesTrains() {
        $scalesAircraftIDs    = array(8, 9, 10, 11, 12, 13, 14);
        $scalesTrains         = $this->Submissions->Scales->find('all', array('conditions' => $scalesAircraftIDs))->select(['scale'])->where(['model_type_id' => 6]);
        $scalesTrains         = $scalesTrains->extract('scale')->toArray();
        $this->set(compact('submission', 'scalesTrains'));
    }

    public function submissioncategoryNaval() {
        $scalesAircraftIDs  = array(8, 9, 10, 11, 12, 13, 14);
        $categoriesNaval    = $this->Submissions->SubmissionCategories->find('all', array('conditions' => $scalesAircraftIDs))->select(['title'])->where(['model_type_id' => 1]);
        $categoriesNaval    = $categoriesNaval->extract('title')->toArray();
        $this->set(compact('submission', 'categoriesNaval'));
    }

    public function submissioncategoryAircraft() {
        $scalesAircraftIDs  = array(8, 9, 10, 11, 12, 13, 14);
        $categoryAircraft   = $this->Submissions->SubmissionCategories->find('all', array('conditions' => $scalesAircraftIDs))->select(['title'])->where(['model_type_id' => 2]);
        $categoryAircraft   = $categoryAircraft->extract('title')->toArray();
        $this->set(compact('submission', 'categoryAircraft'));
    }

    public function submissioncategoryAutomotive() {
        $scalesAircraftIDs  = array(8, 9, 10, 11, 12, 13, 14);
        $categoryAutomotive = $this->Submissions->SubmissionCategories->find('all', array('conditions' => $scalesAircraftIDs))->select(['title'])->where(['model_type_id' => 3]);
        $categoryAutomotive = $categoryAutomotive->extract('title')->toArray();
        $this->set(compact('submission', 'categoryAutomotive'));
    }

    public function submissioncategoryArmor () {
        $scalesAircraftIDs  = array(8, 9, 10, 11, 12, 13, 14);
        $categoryArmor      = $this->Submissions->SubmissionCategories->find('all', array('conditions' => $scalesAircraftIDs))->select(['title'])->where(['model_type_id' => 4]);
        $categoryArmor      = $categoryArmor->extract('title')->toArray();
        $this->set(compact('submission', 'categoryArmor'));
    }

    public function submissioncategoryFigures() {
        $scalesAircraftIDs  = array(8, 9, 10, 11, 12, 13, 14);
        $categoryFigures    = $this->Submissions->SubmissionCategories->find('all', array('conditions' => $scalesAircraftIDs))->select(['title'])->where(['model_type_id' => 5]);
        $categoryFigures    = $categoryFigures->extract('title')->toArray();
        $this->set(compact('submission', 'categoryFigures'));
    }

    public function submissioncategoryTrains() {
        $scalesAircraftIDs  = array(8, 9, 10, 11, 12, 13, 14);
        $categoryTrains     = $this->Submissions->SubmissionCategories->find('all', array('conditions' => $scalesAircraftIDs))->select(['title'])->where(['model_type_id' => 6]);
        $categoryTrains     = $categoryTrains->extract('title')->toArray();
        $this->set(compact('submission', 'categoryTrains'));
    }

    public function submissioncategoryDioramas() {
        $scalesAircraftIDs    = array(8, 9, 10, 11, 12, 13, 14);
        $categoryDioramas     = $this->Submissions->SubmissionCategories->find('all', array('conditions' => $scalesAircraftIDs))->select(['title'])->where(['model_type_id' => 7]);
        $categoryDioramas     = $categoryDioramas->extract('title')->toArray();
        $this->set(compact('submission', 'categoryDioramas'));
    }

    public function submissioncategorySpacecraft() {
        $scalesAircraftIDs    = array(8, 9, 10, 11, 12, 13, 14);
        $categorySpacecraft   = $this->Submissions->SubmissionCategories->find('all', array('conditions' => $scalesAircraftIDs))->select(['title'])->where(['model_type_id' => 8]);
        $categorySpacecraft   = $categorySpacecraft->extract('title')->toArray();
        $this->set(compact('submission', 'categorySpacecraft'));
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
        $users                = $this->Submissions->Users->find('list', ['limit' => 200]);
        $modelTypes           = $this->Submissions->ModelTypes->find('list', ['limit' => 200]);
        $submissionCategories = $this->Submissions->SubmissionCategories->find('list', ['limit' => 200]);
        $manufacturers        = $this->Submissions->Manufacturers->find('list', ['limit' => 200]);
        $scales               = $this->Submissions->Scales->find()->select(['scale']);
        $scales               = $scales->extract('scale')->toArray();
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

    public function beforeFilter(EventInterface $event) {
        parent::beforeFilter($event);

        $this->Auth->allow(['index', 'view']);
    }
}
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
        $this->loadModel('Images');
        $sqlScales = $this->Scales->query('SELECT s.scale_id, scales.scale FROM `submissions` AS s LEFT JOIN `scales` ON s.scale_id = scales.id');
        $sqlImages = $this->Images->query("SELECT original_pathname, submission_id FROM `images` WHERE `submission_id` = 277");
        $this->set('scalesData', $sqlScales);
        $this->set('optionalImages', $sqlImages);
        
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

                    $submissionCategoryId = $this->request->getData('submission_category_id');
                    $scaleId              = $this->request->getData('scale_id');

                    if($submissionCategoryId === '0') {
                        $this->Flash->error(__('A submission category could not be determined. Please select a submission category.'));
                    }
                    if($scaleId === '0') {
                        $this->Flash->error(__('A scale could not be determined. Please select a scale.'));
                    }

                    $image  = $this->request->getData('image_file');
                    $name   = $image->getClientFilename();
                    if($name) {
                        // Check to see if file already exists
                        if(file_exists(WWW_ROOT.'img'.DS.$folder.'/'.$name)) {
                            $noSubmission = false;
                            $errorMessage = 'The image '.$name.' already exists in the '.$folder.' folder.';
                            $this->Flash->error(__($errorMessage));
                        } else {
                            $noSubmission = true;
                            $image->moveTo(WWW_ROOT.'img'.DS.$folder.DS.$name);
                            $submission->image_path = $folder.'/'.$name;
                        }
                    }

                    if($noSubmission) {
                        if($this->Submissions->save($submission)) {
                            if(!is_dir(WWW_ROOT.'otherImg'.DS.$folder)) {
                                mkdir(WWW_ROOT.'otherImg'.DS.$folder, 0775);
                            }
                            $otherImageUpload = false;
                            foreach($this->request->getData('data') as $otherImage) {
                                for($key = 0; $key < $otherImage['num_images']; $key++) {
                                    $submitImage = $this->Submissions->Images->newEmptyEntity();
                                    $submitImage = $this->Submissions->Images->patchEntity($submitImage, $otherImage);
                                    if(!$submitImage->getErrors()) {
                                        $otherName = $otherImage['file'][$key]->getClientFilename(); //Get file original name
                                        if($otherName !== '') {
                                            $extension   = pathinfo($otherName, PATHINFO_EXTENSION);
                                            $size        = $otherImage['file'][$key]->getSize();
                                            
                                            // Check file size
                                            if($size === 0) {
                                                $errorMessage = 'The image '.$otherName.' is greater than 1MB and can not be uploaded.';
                                                $this->Flash->error(__($errorMessage));
                                            } else if($size <= 1048576) {
                                                // Check to see if file already exists
                                                if(file_exists(WWW_ROOT.'otherImg'.DS.$folder.'/'.$otherName)) {
                                                    $errorMessage   = 'The image '.$otherName.' already exists in the '.$folder.' folder.';
                                                    $this->Flash->error(__($errorMessage));
                                                } else {
                                                    // Check file extension
                                                    if($extension === 'png' || $extension === 'jpg' || $extension === 'jpeg') {
                                                        //Add to data to save
                                                        $imgData = array(
                                                            "original_pathname" => $folder.'/'.$otherName,
                                                            "submission_id" => $submission->id
                                                        );
                                                        
                                                        if($otherName) {
                                                            $otherImage['file'][$key]->moveTo(WWW_ROOT.'otherImg'.DS.$folder.DS.$otherName); // move files to destination folder
                                                            $submitImage->original_pathname = $folder.'/'.$otherName;
                                                            $submitImage->submission_id = $submission->id;
                
                                                            if($this->Submissions->Images->save($submitImage)) {
                                                                $otherImageUpload = true;
                                                                $successMessage = 'The image '.$otherName.' has been saved.';
                                                                $this->Flash->success(__($successMessage));
                                                            } else {
                                                                $errorMessage = 'The image '.$otherName.' could not be uploaded.';
                                                                $this->Flash->error(__($errorMessage));
                                                            }
                                                        }
                                                    } else {
                                                        $errorMessage = 'The image '.$otherName.' could not be uploaded. The only allowed file extensions are .png, .jpg, and .jpeg.';
                                                        $this->Flash->error(__($errorMessage));
                                                    }
                                                }
                                            } else {
                                                $errorMessage = 'The image '.$otherName.' is greater than 1MB and can not be uploaded.';
                                                $this->Flash->error(__($errorMessage));
                                            }
                                        }
                                    }
                                }
                            }
                            
                            if($otherImageUpload === true) {
                                if($this->Auth->user('UserGroupID') == 3 || $this->Auth->user('UserGroupID') == 2) {
                                    $this->Flash->success(__('The submission has been saved.'));
                                    return $this->redirect(['action' => 'index']);
                                } else {
                                    $this->Flash->success(__('The submission has been saved.'));
                                    return $this->redirect(array('controller' => 'ModelTypes', 'action' => 'index'));
                                }
                            } else {
                                if($this->Auth->user('UserGroupID') == 3 || $this->Auth->user('UserGroupID') == 2) {
                                    $this->Flash->success(__('The submission has been saved.'));
                                    return $this->redirect(['action' => 'index']);
                                } else {
                                    $this->Flash->success(__('The submission has been saved.'));
                                    return $this->redirect(array('controller' => 'ModelTypes', 'action' => 'index'));
                                }
                            }
                        } else {
                            $this->Flash->error(__('The submission could not be saved.'));
                        }
                    }
                }
            }

            $users                = $this->Submissions->Users->find('list', ['limit' => 200]);
            $modelTypes           = $this->Submissions->ModelTypes->find('list', ['limit' => 200]);
            $manufacturers        = $this->Submissions->Manufacturers->find('list', ['limit' => 200]);
            $statuses             = $this->Submissions->Statuses->find('list', ['limit' => 200]);
            $this->set(compact('submission', 'users', 'modelTypes', 'manufacturers', 'statuses', 'categoryAircraft'));
        } else {
            return $this->redirect(array('controller' => 'Users', 'action' => 'login'));
        }
    }

    public function edit($id = null) {
        if($this->Auth->user('email') !== null) {
            $submission = $this->Submissions->get($id, [
                'contain' => [],
            ]);
            if ($this->request->is(['patch', 'post', 'put'])) {
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

                    $submissionCategoryId = $this->request->getData('submission_category_id');
                    $scaleId              = $this->request->getData('scale_id');

                    if($submissionCategoryId === '0') {
                        $this->Flash->error(__('A submission category could not be determined. Please select a submission category.'));
                    }
                    if($scaleId === '0') {
                        $this->Flash->error(__('A scale could not be determined. Please select a scale.'));
                    }

                    $image  = $this->request->getData('image_file');
                    $name   = $image->getClientFilename();
                    if($name) {
                        // Check to see if file already exists
                        if(file_exists(WWW_ROOT.'img'.DS.$folder.'/'.$name)) {
                            $errorMessage = 'The image '.$name.' already exists in the '.$folder.' folder.';
                            $this->Flash->error(__($errorMessage));
                        } else {
                            $image->moveTo(WWW_ROOT.'img'.DS.$folder.DS.$name);
                            $submission->image_path = $folder.'/'.$name;
                        }
                    }
                }
                
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
        } else {
            return $this->redirect(array('controller' => 'Users', 'action' => 'login'));
        }
    }

    public function scalesNaval() {
        $scalesNaval = $this->Submissions->Scales->find('list', [
            'keyField' => 'id',
            'valueField' => 'scale'
        ])->where(['model_type_id' => 1]);   
        $this->set(compact('submission', 'scalesNaval'));
    }

    public function scalesAircraft() {
        $scalesAircraft = $this->Submissions->Scales->find('list', [
            'keyField' => 'id',
            'valueField' => 'scale'
        ])->where(['model_type_id' => 2])->toArray();
        $this->set(compact('submission', 'scalesAircraft'));
    }

    public function scalesArmor() {
        $scalesArmor = $this->Submissions->Scales->find('list', [
            'keyField' => 'id',
            'valueField' => 'scale'
        ])->where(['model_type_id' => 4])->toArray();
        $this->set(compact('submission', 'scalesArmor'));
    }

    public function scalesAutomotive() {
        $scalesAutomotive = $this->Submissions->Scales->find('list', [
            'keyField' => 'id',
            'valueField' => 'scale'
        ])->where(['model_type_id' => 3])->toArray();
        $this->set(compact('submission', 'scalesAutomotive'));
    }

    public function scalesDioramas() {
        $scalesDioramas = $this->Submissions->Scales->find('list', [
            'keyField' => 'id',
            'valueField' => 'scale'
        ])->where(['model_type_id' => 7])->toArray();
        $this->set(compact('submission', 'scalesDioramas'));
    }

    public function scalesTrains() {
        $scalesTrains = $this->Submissions->Scales->find('list', [
            'keyField' => 'id',
            'valueField' => 'scale'
        ])->where(['model_type_id' => 6])->toArray();
        $this->set(compact('submission', 'scalesTrains'));
    }

    public function submissioncategoryNaval() {
        $categoriesNaval = $this->Submissions->SubmissionCategories->find('list', [
            'keyField' => 'id',
            'valueField' => 'title'
        ])->where(['model_type_id' => 1])->toArray();
        $this->set(compact('submission', 'categoriesNaval'));
    }

    public function submissioncategoryAircraft() {
        $categoryAircraft = $this->Submissions->SubmissionCategories->find('list', [
            'keyField' => 'id',
            'valueField' => 'title'
        ])->where(['model_type_id' => 2])->toArray();
        $this->set(compact('submission', 'categoryAircraft'));
    }

    public function submissioncategoryAutomotive() {
        $categoryAutomotive = $this->Submissions->SubmissionCategories->find('list', [
            'keyField' => 'id',
            'valueField' => 'title'
        ])->where(['model_type_id' => 3])->toArray();
        $this->set(compact('submission', 'categoryAutomotive'));
    }

    public function submissioncategoryArmor () {
        $categoryArmor = $this->Submissions->SubmissionCategories->find('list', [
            'keyField' => 'id',
            'valueField' => 'title'
        ])->where(['model_type_id' => 4])->toArray();
        $this->set(compact('submission', 'categoryArmor'));
    }

    public function submissioncategoryFigures() {
        $categoryFigures = $this->Submissions->SubmissionCategories->find('list', [
            'keyField' => 'id',
            'valueField' => 'title'
        ])->where(['model_type_id' => 5])->toArray();
        $this->set(compact('submission', 'categoryFigures'));
    }

    public function submissioncategoryTrains() {
        $categoryTrains = $this->Submissions->SubmissionCategories->find('list', [
            'keyField' => 'id',
            'valueField' => 'title'
        ])->where(['model_type_id' => 6])->toArray();
        $this->set(compact('submission', 'categoryTrains'));
    }

    public function submissioncategoryDioramas() {
        $categoryDioramas = $this->Submissions->SubmissionCategories->find('list', [
            'keyField' => 'id',
            'valueField' => 'title'
        ])->where(['model_type_id' => 7])->toArray();
        $this->set(compact('submission', 'categoryDioramas'));
    }

    public function submissioncategorySpacecraft() {
        $categorySpacecraft = $this->Submissions->SubmissionCategories->find('list', [
            'keyField' => 'id',
            'valueField' => 'title'
        ])->where(['model_type_id' => 8])->toArray();
        $this->set(compact('submission', 'categorySpacecraft'));
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
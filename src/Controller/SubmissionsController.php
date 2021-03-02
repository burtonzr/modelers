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
        if($this->Auth->user('UserGroupID') == 3 || $this->Auth->user('UserGroupID') == 2) {
            $this->paginate = [
                'contain' => ['Users', 'ModelTypes', 'SubmissionCategories', 'Manufacturers', 'Scales', 'Statuses'],
            ];
            $this->loadModel('Submissions');
            $submissions = $this->Submissions->find('all')->order(['Submissions.id' => 'DESC']);
            $Statuses    = $this->Submissions->Statuses->find('list', [
                'keyField' => 'id',
                'valueField' => 'title'
            ])->where(['type' => 'submissions']);

            if ($this->request->is(['patch', 'post', 'put'])) {
                $id = $this->request->getData('submission_id');
                $submission = $this->Submissions->get($id, [
                    'contain' => [],
                ]);
                if(!$submission->getErrors()) {
                    $statusName = "";
                    $status_id  = $this->request->getData('status_id');
                    $subject    = $this->request->getData('submissionsubject');
                    $submission = $this->Submissions->patchEntity($submission, $this->request->getData());

                    if($status_id === '15') {
                        $statusName = 'pending';
                    } else if($status_id === '16') {
                        $statusName = 'active';
                    } else if($status_id === '17') {
                        $statusName = 'removed';
                    }
                }
                if ($this->Submissions->save($submission)) {
                    $message = 'The status of ' . $subject . ' was updated to ' . $statusName . '.';
                    $this->Flash->success(__($message));
    
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The submission status could not be updated. Please, try again.'));
            }
            $this->set('submissions', $this->paginate($submissions, ['limit' => '25']));
            $this->set(compact('Statuses'));
        } else {
            return $this->redirect(array('controller' => 'SubmissionCategories', 'action' => 'index'));
        }
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
            $now        = Time::now();
            $approved   = $now->year."-".$now->month."-".$now->day." 23:59:59";
            $this->set('approved', $approved);
            if ($this->request->is('post')) {
                $submission = $this->Submissions->patchEntity($submission, $this->request->getData());
                if(!$submission->getErrors()) {
                    $folder          = $now->year . "-" . $now->month;
                    $modelTypeFolder = "";

                    $modelTypeId          = $this->request->getData('model_type_id');
                    $submissionCategoryId = $this->request->getData('submission_category_id');
                    $scaleId              = $this->request->getData('scale_id');
                    $created              = $this->request->getData('created');
                    
                    if($modelTypeId === "1") {
                        $modelTypeFolder = "Naval";
                    } else if ($modelTypeId === "2") {
                        $modelTypeFolder = "Aircraft";
                    } else if ($modelTypeId === "3") {
                        $modelTypeFolder = "Auto";
                    } else if ($modelTypeId === "4") {
                        $modelTypeFolder = "Armor";
                    } else if ($modelTypeId === "5") {
                        $modelTypeFolder = "Figures";
                    } else if ($modelTypeId === "6") {
                        $modelTypeFolder = "Trains";
                    } else if ($modelTypeId === "7") {
                        $modelTypeFolder = "Dioramas";
                    } else if ($modelTypeId === "8") {
                        $modelTypeFolder = "Space";
                    }
                
                    $ModelTypeDateFolderName = $modelTypeFolder . '-' . $folder;
                   
                    if(!is_dir(WWW_ROOT.'img'.DS.$ModelTypeDateFolderName)) {
                        mkdir(WWW_ROOT.'img'.DS.$ModelTypeDateFolderName, 0775);
                    }

                    if($modelTypeId === '') {
                        $this->Flash->error(__('A model type could not be determined. Please select a model type.'));   
                    }

                    if($submissionCategoryId === '0' || $submissionCategoryId === '') {
                        $this->Flash->error(__('A submission category could not be determined. Please select a submission category.'));
                    }

                    if($scaleId === '0' || $scaleId === '') {
                        $this->Flash->error(__('A scale could not be determined. Please select a scale.'));
                    }

                    $image  = $this->request->getData('image_file');
                    $name   = $image->getClientFilename();
                    if($name) {
                        // Check to see if file already exists
                        if(file_exists(WWW_ROOT.'img'.DS.$ModelTypeDateFolderName.'/'.$name)) {
                            $noSubmission = false;
                            $errorMessage = 'The image '.$name.' already exists in the '.$ModelTypeDateFolderName.' folder.';
                            $this->Flash->error(__($errorMessage));
                        } else {
                            $noSubmission = true;
                            $image->moveTo(WWW_ROOT.'img'.DS.$ModelTypeDateFolderName.DS.$name);
                            $submission->image_path = $ModelTypeDateFolderName.'/'."thumb_".$name;
                        }
                    }

                    if($noSubmission && $modelTypeId !== '') {
                        if($this->Submissions->save($submission)) {
                            //Create thumbnail
                            require_once(ROOT . DS . 'vendor' . DS . "phpThumb" . DS . "phpthumb.class.php");
                            $phpThumb      = new \phpThumb();
                            $phpThumb->src = WWW_ROOT.'img'.DS.$ModelTypeDateFolderName.DS.$name;
                            $phpThumb->h   = 500;
                            $phpThumb->w   = 550;
                            if($phpThumb->GenerateThumbnail()) {
                                $phpThumb->RenderToFile(WWW_ROOT.'img'.DS.$ModelTypeDateFolderName.'/'."thumb_".$name);
                            } else { 
                                die('Failed: '.$phpThumb->error); 
                                $this->Flash->error(__("Thumbnail could not be created."));
                            }
                            unset($phpThumb);
                            unlink(WWW_ROOT.'img'.DS.$ModelTypeDateFolderName.DS.$name);
                            if(!is_dir(WWW_ROOT.'otherImg'.DS.$ModelTypeDateFolderName)) {
                                mkdir(WWW_ROOT.'otherImg'.DS.$ModelTypeDateFolderName, 0775);
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
                                                if(file_exists(WWW_ROOT.'otherImg'.DS.$ModelTypeDateFolderName.'/'.$otherName)) {
                                                    $errorMessage   = 'The image '.$otherName.' already exists in the '.$ModelTypeDateFolderName.' folder.';
                                                    $this->Flash->error(__($errorMessage));
                                                } else {
                                                    // Check file extension
                                                    if($extension === 'png' || $extension === 'jpg' || $extension === 'jpeg') {
                                                        //Add to data to save
                                                        $imgData = array(
                                                            "original_pathname" => $ModelTypeDateFolderName.'/'.$otherName,
                                                            "submission_id" => $submission->id
                                                        );
                                                        
                                                        if($otherName) {
                                                            $otherImage['file'][$key]->moveTo(WWW_ROOT.'otherImg'.DS.$ModelTypeDateFolderName.DS.$otherName); // move files to destination folder
                                                            $submitImage->original_pathname = $ModelTypeDateFolderName.'/'.$otherName;
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
                } else {
                    $modelTypes  = $this->Submissions->ModelTypes->find('list', ['limit' => 200]);
                    $modelTypeId = ['0' => ''];
                    $data        = $modelTypeId + $modelTypes->toArray();
                    debug($data);
                    exit;
                    $this->set(compact('modelTypes', $data));
                    
                    //debug($this->request->getData('model_type_id'));
                    //exit;
                }
            }

            $users          = $this->Submissions->Users->find('list', ['limit' => 200]);
            $modelTypes     = $this->Submissions->ModelTypes->find('list', ['limit' => 200]);
            $manufacturers  = $this->Submissions->Manufacturers->find('list', ['limit' => 200]);
            $statuses       = $this->Submissions->Statuses->find('list', ['limit' => 200]);
            $this->set(compact('submission', 'users', 'modelTypes', 'manufacturers', 'statuses'));
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
                    $now             = Time::now();
                    $folder          = $now->year . "-" . $now->month;
                    $modelTypeFolder = "";

                    $modelTypeId          = $this->request->getData('model_type_id');
                    $submissionCategoryId = $this->request->getData('submission_category_id');
                    $scaleId              = $this->request->getData('scale_id');

                    if($modelTypeId === "1") {
                        $modelTypeFolder = "Naval";
                    } else if ($modelTypeId === "2") {
                        $modelTypeFolder = "Aircraft";
                    } else if ($modelTypeId === "3") {
                        $modelTypeFolder = "Auto";
                    } else if ($modelTypeId === "4") {
                        $modelTypeFolder = "Armor";
                    } else if ($modelTypeId === "5") {
                        $modelTypeFolder = "Figures";
                    } else if ($modelTypeId === "6") {
                        $modelTypeFolder = "Trains";
                    } else if ($modelTypeId === "7") {
                        $modelTypeFolder = "Dioramas";
                    } else if ($modelTypeId === "8") {
                        $modelTypeFolder = "Space";
                    }

                    $ModelTypeDateFolderName = $modelTypeFolder . '-' . $folder;
                   
                    if(!is_dir(WWW_ROOT.'img'.DS.$ModelTypeDateFolderName)) {
                        mkdir(WWW_ROOT.'img'.DS.$ModelTypeDateFolderName, 0775);
                    }

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
                        if(file_exists(WWW_ROOT.'img'.DS.$ModelTypeDateFolderName.'/'.$name)) {
                            $errorMessage = 'The image '.$name.' already exists in the '.$ModelTypeDateFolderName.' folder.';
                            $this->Flash->error(__($errorMessage));
                        } else {
                            $image->moveTo(WWW_ROOT.'img'.DS.$ModelTypeDateFolderName.DS.$name);
                            $submission->image_path = $ModelTypeDateFolderName.'/'.$name;
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
            $statuses              = $this->Submissions->Statuses->find('list', ['limit' => 200]);
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
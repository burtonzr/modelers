<?= $this->Html->script('submissions.js') ?>
<h1 class="pagetitle text-center">Create Submission</h1>
<div class="row">
    <div class="col-12">
        <?= $this->Html->link(__('List Submissions'), ['action' => 'index'], ['class' => 'model_types_view p-3 mt-4 btn btn-info']) ?>
    </div>
</div>
<div class="container content mt-5">
    <?= $this->Form->create($submission, array('enctype' => 'multipart/form-data')); ?>
    <div class="row">
        <div class="col-12 col-sm-6 mt-3">
            <?php
                echo $this->Form->control('subject');
            ?>
        </div>
        <div class="col-12 col-sm-6 mt-3">
            <?php
                echo $this->Form->control('model_type_id', ['id' => 'model-type-id', 'options' => $modelTypes, 'empty' => true]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-6 mt-3" id="submission-category-hidden">
            <?php
                echo $this->Form->control('submission_category_id', ['options' => $submissionCategories, 'empty' => true]);
            ?>
        </div>
        <div class="col-12 col-sm-6 mt-3">
            <div id="scales-naval"></div>
        </div>
        <?php
                    echo $this->Element('scales_naval');
                ?>
        <!--
        <div class="col-12 col-sm-6 mt-3" id="scale-hidden">-->
            <?php  
                
                
                    
                        /*
                        if($output['id'] == "1") {
                            echo $this->Form->control('scale_id', ['options' => $scalesNaval, 'empty' => true]);
                        }
                        if($output['id'] == "2") {
                            echo $this->Form->control('scale_id', ['options' => $scalesAircraft, 'empty' => true]);
                        }
                        if($output['id'] == "3") {
                            echo $this->Form->control('scale_id', ['options' => $scalesAutomotive, 'empty' => true]);
                        }
                        if($output['id'] == "4") {
                            echo $this->Form->control('scale_id', ['options' => $scalesArmor, 'empty' => true]);
                        }   
                        if($output['id'] == "6") {
                            echo $this->Form->control('scale_id', ['options' => $scalesTrains, 'empty' => true]);
                        }
                        if($output['id'] == "7") {
                            echo $this->Form->control('scale_id', ['options' => $scalesDioramas, 'empty' => true]);
                        }
                    
               */
            ?>
        <!--</div>-->
    </div>
    <div class="row">
        <div class="col-12 col-sm-6 mt-3">
            <?php
                echo $this->Form->control('description');
            ?>
        </div>
        <div class="col-12 col-sm-6 mt-3">
            <?php
                echo $this->Form->control('manufacturer_id', ['options' => $manufacturers, 'empty' => true]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-6 mt-3">
            <?php
                echo $this->Form->control('image_path', array('type' => 'file'));
            ?>
        </div>
        <div class="col-12 col-sm-6 mt-3">
            <?php
                echo $this->Form->control('approved', ['empty' => true]);
            ?>
        </div>
    </div>
    <?php
        echo $this->Form->control('user_id', ['default' => $id, 'type' => 'hidden']);
        echo $this->Form->control('status_id', ['default' => 15, 'type' => 'hidden']);
    ?>
    <?= $this->Form->button(__('Add Submission'), ['class' => 'loginButton btn btn-success btn-block mt-3']) ?>
    <?= $this->Form->end() ?>
</div>


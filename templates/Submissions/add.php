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
                echo $this->Form->control('user_id', ['options' => $users]);
            ?>
        </div>
        <div class="col-12 col-sm-6 mt-3">
            <?php
                echo $this->Form->control('subject');
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-6 mt-3">
            <?php
                echo $this->Form->control('model_type_id', ['options' => $modelTypes]);
            ?>
        </div>
        <div class="col-12 col-sm-6 mt-3">
            <?php
                echo $this->Form->control('submission_category_id', ['options' => $submissionCategories, 'empty' => true]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-6 mt-3">
            <?php
                echo $this->Form->control('manufacturer_id', ['options' => $manufacturers]);
            ?>
        </div><div class="col-12 col-sm-6 mt-3">
            <?php
                echo $this->Form->control('description');
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-6 mt-3">
            <?php  
                echo $this->Form->control('scale_id', ['options' => $scales]);
            ?>
        </div>
        <div class="col-12 col-sm-6 mt-3">
            <?php
                echo $this->Form->control('image_path', array('type' => 'file'));
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-6 mt-3">
            <?php  
                echo $this->Form->control('status_id', ['options' => $statuses]);
            ?>
        </div>
        <div class="col-12 col-sm-6 mt-3">
            <?php
                echo $this->Form->control('approved', ['empty' => true]);
            ?>
        </div>
    </div>
    <?= $this->Form->button(__('Add Submission'), ['class' => 'loginButton btn btn-success btn-block mt-3']) ?>
    <?= $this->Form->end() ?>
</div>



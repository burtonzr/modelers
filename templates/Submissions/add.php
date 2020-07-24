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
            <div id="scales-aircraft"></div>
            <div id="scales-automotive"></div>
            <div id="scales-armor"></div>
            <div id="scales-figures" class="mt-5 pt-3"></div>
            <div id="scales-trains"></div>
            <div id="scales-dioramas"></div>
            <div id="scales-space" class="mt-5 pt-3"></div>
        </div>
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


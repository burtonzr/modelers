<h1 class="pagetitle text-center">Edit <?= h($submission->subject) ?></h1>
<div class="container content mt-5">
    <?= $this->Form->create($submission) ?>
    <?php if($UserGroupID == 3) { ?>
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
                    echo $this->Form->control('manufacturer_id', ['options' => $manufacturers, 'empty' => true]);
                ?>
            </div>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-12 col-sm-6 mt-3">
            <?php
                echo $this->Form->control('submission_category_id', ['options' => $submissionCategories, 'empty' => true]);
            ?>
        </div>
        <div class="col-12 col-sm-6 mt-3">
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
                echo $this->Form->control('status_id', ['options' => $statuses]);
            ?>
        </div>
    </div>
    <div class="row">
        <?php if ($UserGroupID == 3) { ?>
            <div class="col-12 col-sm-6 mt-3">
                <?php
                    echo $this->Form->control('image_path');
                ?>
            </div>
        <?php } ?>
        <?php if($UserGroupID >= 2) { ?>
            <div class="col-12 col-sm-6 mt-3">
                <?php
                    echo $this->Form->control('approved', ['empty' => true]);
                ?>
            </div>
        <?php } ?>
    </div>
    <?= $this->Form->button(__('Update Submission'), ['class' => 'loginButton btn btn-success btn-block mt-3']) ?>
    <?= $this->Form->end() ?>
</div>
<div class="row text-center">
    <div class="col-12 col-sm-3 mt-3">
        <?= $this->Html->link(__('List Submissions'), ['action' => 'index'], ['class' => 'model_types_view p-3 mt-4 btn btn-info']) ?>
    </div>
</div>

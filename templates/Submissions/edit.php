<?= $this->Html->script('submissions.js') ?>
<div class="text-center">
    <h1 class="pagetitle">Edit <?= h($submission->subject) ?></h1>
    <img src="../../img/<?= h($submission->image_path) ?>" width="35%" class="img-fluid mt-2" />
</div>
<div class="container content mt-5">
    <?= $this->Form->create($submission, array('enctype' => 'multipart/form-data')) ?>
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
            <div class="col-12 col-sm-6 mt-4">
                <button type="button" id="changeImageButton" style="text-transform: capitalize; font-size: 15px;" class="btn btn-info btn-block">Update Current Image</button>
                <div class="d-none" id="changeImage">
                    <?php
                        echo $this->Form->control('image_file', array('id' => 'mainImage', 'label' => 'Main Image', 'type' => 'file', 'formnovalidate' => true));
                    ?>
                    <p id="newImagePath"></p>
                    <button type="button" id="cancelMainImage" class="btn btn-danger btn-block" style="text-transform: capitalize; font-size: 15px;">Cancel</button>
                    <input type="hidden" id="mainImageHidden" value="<?= h($submission->image_path) ?>" />
                </div>
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
    <?= $this->Form->button(__('Update Submission'), ['type' => 'submit', 'class' => 'loginButton btn btn-success btn-block mt-3']) ?>
    <?= $this->Form->end() ?>
</div>
<div class="row text-center">
    <div class="col-12 col-sm-3 mt-3">
        <?= $this->Html->link(__('List Submissions'), ['action' => 'index'], ['class' => 'model_types_view p-3 mt-4 btn btn-info']) ?>
    </div>
</div>

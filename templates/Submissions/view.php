<h2 class="pagetitle text-center"><?= h($submission->subject) ?> by <?= h($submission->user->name) ?></h2>
<div class="portrait">
    <a href="../../img/<?= h($submission->image_path) ?>" data-lightbox="submissiongallery">
        <img src="../../img/<?= h($submission->image_path) ?>" class="portrait-img img-fluid mt-3" />
    </a>
</div>
<div class="container mt-5">
    <h3 class="text-center">
        <?php 
            foreach($scalesData as $scale) {
                if($submission->scale->id == $scale['id']) {
                    echo $scale['scale'];
                }
            }
        ?>
        <?= h($submission->subject) ?>
        <?php if($submission->manufacturer->name === "Other Manufacturer") { ?>
            (<?= h($submission->Custom_Manufacturer) ?>)
        <?php } ?>
        <?php if($submission->manufacturer->name !== "Other Manufacturer") { ?>
            (<?= h($submission->manufacturer->name) ?>)
        <?php } ?>
    </h3>
    <p class="mt-5">
        <?= $this->Text->autoParagraph(h($submission->description)); ?>
    </p>
    <div class="row mt-3">
        <?php
            foreach($optionalImages as $image) {
                if($submission->id == $image['submission_id']) {
        ?>
        <div class="col-sm-6 col-md-4 text-center">
            <a href="../../otherImg/<?= $image['original_pathname']; ?>" data-lightbox="submissiongallery">
                <img src="../../otherImg/<?= $image['original_pathname']; ?>" class="img-thumbnail img-fluid mt-3" />
            </a>
        </div>
        <?php 
                }
            }
        ?>
    </div>
    <h4 style="color: mediumblue;" class="text-center mt-5"><?php echo $this->Html->link($submission->user->name, array('controller' => 'users', 'action' => 'view/', $submission->user->id), array('class' => 'nav-link'));?></h4>
    <hr />
    <h4 class="text-center mt-5">Gallery Updated On <?= h(date('m/d/Y', strtotime($submission->modified))) ?></h4>
    <div class="row">
        <?php
            if($UserGroupID == 2 || $UserGroupID == 3 || $submission->user_id === $id) { 
        ?>
            <div class="col-12 col-sm-3 mt-3">
                <?= $this->Html->link(__('Edit Submission'), ['action' => 'edit', $submission->id], ['class' => 'model_types_view p-3 mt-4 btn btn-warning']) ?>
            </div>
        <?php } ?>
    </div>
    <!---
    <div class="related">
        <h4><?= __('Related Submission Field Values') ?></h4>
        <?php if (!empty($submission->submission_field_values)) : ?>
            <div class="table-responsive">
                <table>
                    <tr>
                        <th><?= __('Id') ?></th>
                        <th><?= __('Submission Id') ?></th>
                        <th><?= __('Submission Field Id') ?></th>
                        <th><?= __('Value') ?></th>
                        <th><?= __('Created') ?></th>
                        <th><?= __('Modified') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($submission->submission_field_values as $submissionFieldValues) : ?>
                    <tr>
                        <td><?= h($submissionFieldValues->id) ?></td>
                        <td><?= h($submissionFieldValues->submission_id) ?></td>
                        <td><?= h($submissionFieldValues->submission_field_id) ?></td>
                        <td><?= h($submissionFieldValues->value) ?></td>
                        <td><?= h($submissionFieldValues->created) ?></td>
                        <td><?= h($submissionFieldValues->modified) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['controller' => 'SubmissionFieldValues', 'action' => 'view', $submissionFieldValues->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['controller' => 'SubmissionFieldValues', 'action' => 'edit', $submissionFieldValues->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['controller' => 'SubmissionFieldValues', 'action' => 'delete', $submissionFieldValues->id], ['confirm' => __('Are you sure you want to delete # {0}?', $submissionFieldValues->id)]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <div class="row text-center">
        <div class="col-12 col-sm-3 mt-3">
            <?= $this->Html->link(__('Go Back'), array('controller' => 'SubmissionCategories', 'action' => 'view', $submission->submission_category->id), ['class' => 'model_types_view p-3 mt-4 btn btn-info']) ?>
        </div>
        <?php if($email) { ?>
            <div class="col-12 col-sm-3 mt-3">
                <?= $this->Html->link(__('New Submission'), ['action' => 'add'], ['class' => 'model_types_view p-3 mt-4 btn btn-success']) ?>
            </div>
        <?php } ?>
        <?php
            if($UserGroupID == 2 || $UserGroupID == 3) { 
        ?>
            <div class="col-12 col-sm-3 mt-3">
                <?= $this->Html->link(__('Edit Submission'), ['action' => 'edit', $submission->id], ['class' => 'model_types_view p-3 mt-4 btn btn-warning']) ?>
            </div>
        <?php } ?>
        <?php
            if($UserGroupID == 3) {
        ?>
            <div class="col-12 col-sm-3 mt-3">
                <?= $this->Form->postLink(__('Delete Submission'), ['action' => 'delete', $submission->id], ['confirm' => __('Are you sure you want to delete # {0}?', $submission->id), 'class' => 'model_types_view p-3 mt-4 btn btn-danger']) ?>
            </div>
        <?php } ?>
    </div>
    --->
</div>

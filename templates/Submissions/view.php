<h2 class="pagetitle text-center"><?= h($submission->subject) ?> by <?= h($submission->user->name) ?></h2>
<div class="row text-center">
    <?php if($email) { ?>
        <div class="col-12 col-sm-4 mt-3">
            <?= $this->Html->link(__('New Submission'), ['action' => 'add'], ['class' => 'model_types_view p-3 mt-4 btn btn-success']) ?>
        </div>
    <?php } ?>
    <?php
        if($UserGroupID == 2 || $UserGroupID == 3) { 
    ?>
        <div class="col-12 col-sm-4 mt-3">
            <?= $this->Html->link(__('Edit Submission'), ['action' => 'edit', $submission->id], ['class' => 'model_types_view p-3 mt-4 btn btn-warning']) ?>
        </div>
    <?php } ?>
    <?php
        if($UserGroupID == 3) {
    ?>
        <div class="col-12 col-sm-4 mt-3">
            <?= $this->Form->postLink(__('Delete Submission'), ['action' => 'delete', $submission->id], ['confirm' => __('Are you sure you want to delete # {0}?', $submission->id), 'class' => 'model_types_view p-3 mt-4 btn btn-danger']) ?>
        </div>
    <?php } ?>
</div>
<div class="text-center">
    <img src="../../img/<?= h($submission->image_path) ?>" width="70%" class="img-fluid mt-3" />
</div>
<div class="container mt-3">
    <h3 class="text-center">
        <?= h($submission->model_type->title) ?>
        <span class="mx-3"><i class="fa fa-angle-left"></i></span>
        <?= h($submission->submission_category->title) ?>
        <span class="mx-3"><i class="fa fa-angle-left"></i></span>
        <?php 
            foreach($scalesData as $scale) {
                if($submission->scale->id == $scale['id']) {
                    echo $scale['scale'];
                }
            }
        ?>
        <span class="mx-3"><i class="fa fa-angle-left"></i></span>
        <?= h($submission->manufacturer->name) ?>
    </h3>
    <p class="mt-5">
        <?= $this->Text->autoParagraph(h($submission->description)); ?>
    </p>
    <h4 class="text-center mt-5">Gallery Updated On <?= h(date('d/m/Y', strtotime($submission->modified))) ?></h4>
    <!---
    <div class="related">
        <h4><?= __('Related Images') ?></h4>
        <?php if (!empty($submission->images)) : ?>
        <div class="table-responsive">
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <th><?= __('Original Filename') ?></th>
                    <th><?= __('Storage Filename') ?></th>
                    <th><?= __('Mime Type') ?></th>
                    <th><?= __('Filesize') ?></th>
                    <th><?= __('Title') ?></th>
                    <th><?= __('Description') ?></th>
                    <th><?= __('Submission Id') ?></th>
                    <th><?= __('Status Id') ?></th>
                    <th><?= __('Created') ?></th>
                    <th><?= __('Modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($submission->images as $images) : ?>
                <tr>
                    <td><?= h($images->id) ?></td>
                    <td><?= h($images->original_filename) ?></td>
                    <td><?= h($images->storage_filename) ?></td>
                    <td><?= h($images->mime_type) ?></td>
                    <td><?= h($images->filesize) ?></td>
                    <td><?= h($images->title) ?></td>
                    <td><?= h($images->description) ?></td>
                    <td><?= h($images->submission_id) ?></td>
                    <td><?= h($images->status_id) ?></td>
                    <td><?= h($images->created) ?></td>
                    <td><?= h($images->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'Images', 'action' => 'view', $images->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'Images', 'action' => 'edit', $images->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Images', 'action' => 'delete', $images->id], ['confirm' => __('Are you sure you want to delete # {0}?', $images->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
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
    --->
    <div class="col-12 col-sm-3 mt-3">
        <?= $this->Html->link(__('Go Back'), array('controller' => 'SubmissionCategories', 'action' => 'view', $submission->submission_category->id), ['class' => 'model_types_view p-3 mt-4 btn btn-info']) ?>
    </div>
</div>

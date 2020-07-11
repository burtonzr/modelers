<div class="container-fluid">
    <h1 class="pagetitle text-center"><?= h($submissionCategory->title) ?></h1>
    <div class="row text-center">
        <div class="col-12 col-sm-4">
            <?= $this->Html->link(__('Go Back'), array('controller' => 'ModelTypes', 'action' => 'view', $submissionCategory->model_type_id), ['class' => 'model_types_view p-3 mt-4 btn btn-info']) ?>
        </div>
        <div class="col-12 col-sm-3">
            <?= $this->Html->link(__('New Submission'), array('controller' => 'Submissions', 'action' => 'add'), ['class' => 'model_types_view p-3 mt-4 btn btn-success']) ?>
        </div>
        <?php 
            if($UserGroupID == 3) {
        ?>
            <div class="col-12 col-sm-4">
                <?= $this->Html->link(__('Edit Category'), ['action' => 'edit'], ['class' => 'model_types_view p-3 mt-4 btn btn-warning']) ?>
            </div>
        <?php } ?>
        <?php if (!empty($submissionCategory->submissions)) : ?>
            <div class="container mt-5">
                <?php foreach ($submissionCategory->submissions as $submissions) : ?>
                    <div class="col-sm-12 col-md-6 content mt-5 grid modeltypes">
                        <div class="inner">
                            <h3 class="text-center" style="text-transform: capitalize;"><?= $this->Html->link(__(h($submissions->manufacturer_id)), ['controller' => 'Submissions', 'action' => 'view', $submissions->id]) ?></h3>
                            <div class="img-container">
                                <?php if (!empty($submission->images)) : ?>
                                    <h1>hello</h1>
                                <?php endif; ?>
                                <img src="<?= h($submissions->main_image) ?>" class="img-fluid" />
                            </div>
                            <!---
                            <?= h($submissions->id) ?>
                            <td><?= h($submissions->user_id) ?></td>
                            <td><?= h($submissions->subject) ?></td>
                            <td><?= h($submissions->model_type_id) ?></td>
                            <td><?= h($submissions->submission_category_id) ?></td>
                            <td></td>
                            <td><?= h($submissions->description) ?></td>
                            <td><?= h($submissions->scale_id) ?></td>
                            <td></td>
                            <td><?= h($submissions->status_id) ?></td>
                            <td><?= h($submissions->created) ?></td>
                            <td><?= h($submissions->approved) ?></td>
                            <td><?= h($submissions->modified) ?></td>
                            <td class="actions">
                                
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Submissions', 'action' => 'edit', $submissions->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Submissions', 'action' => 'delete', $submissions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $submissions->id)]) ?>
                            </td>
                            --->
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="container-fluid">
    <h1 class="pagetitle text-center"><?= h($submissionCategory->title) ?></h1>
    <div class="row text-center">
        <div class="col-12 col-sm-4">
            <?= $this->Html->link(__('Go Back'), array('controller' => 'ModelTypes', 'action' => 'view', $submissionCategory->model_type_id), ['class' => 'model_types_view p-3 mt-4 btn btn-info']) ?>
        </div>
        <div class="col-12 col-sm-4">
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
            <div class="row mt-5">
                <?php foreach ($submissionCategory->submissions as $submissions) : ?>
                    <div class="col-sm-12 col-md-6 content mt-5 grid modeltypes">
                        <div class="inner">
                            <h4 class="text-center" style="text-transform: capitalize;"><?= h($submissions->scale_id) ?> <?= $this->Html->link(__(h($submissions->subject)), ['controller' => 'Submissions', 'action' => 'view', $submissions->id]) ?> by <?= h($submissions->user_id) ?></h4>
                            <div class="img-container">
                                <img src="../../img/<?= h($submissions->image_path) ?>" class="img-fluid" />
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<!---
<?= $this->Html->link(__('Edit'), ['controller' => 'Submissions', 'action' => 'edit', $submissions->id]) ?>
<?= $this->Form->postLink(__('Delete'), ['controller' => 'Submissions', 'action' => 'delete', $submissions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $submissions->id)]) ?>
--->

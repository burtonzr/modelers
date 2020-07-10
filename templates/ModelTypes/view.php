<div class="container-fluid">
    <h1 class="pagetitle text-center"><?= h($modelType->title) ?> Categories</h1>
        <div class="row text-center">
            <div class="col-12 col-sm-4">
                <?= $this->Html->link(__('Model Types'), ['action' => 'index'], ['class' => 'model_types_view p-3 mt-4 btn btn-info']) ?>
            </div>
            <?php
                if($UserGroupID == 3) { 
            ?>
                <div class="col-12 col-sm-4">
                    <?= $this->Html->link(__('New Category'), array('controller' => 'SubmissionCategories', 'action' => 'add'), ['class' => 'model_types_view p-3 mt-4 btn btn-success']) ?>
                </div>
                <div class="col-12 col-sm-4">
                    <?= $this->Html->link(__('Edit Model Type'), ['action' => 'edit', $modelType->id], ['class' => 'model_types_view p-3 mt-4 btn btn-warning']) ?>
                </div>
            <?php } ?>
        </div>
    <div class="row mt-5">
        <?php if (!empty($modelType->submission_categories)) : ?>
            <?php foreach ($modelType->submission_categories as $submissionCategories): ?>
                <div class="col-sm-12 col-md-6 content mt-5 gridSubmissions modeltypes">
                    <div class="inner">
                        <h3 class="text-center" style="text-transform: capitalize; margin-top: 40px;"><?= $this->Html->link(h($submissionCategories->title), ['controller' => 'SubmissionCategories', 'action' => 'view', $submissionCategories->id]) ?></h3>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

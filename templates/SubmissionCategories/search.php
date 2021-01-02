<div class="row">
    <div class="col-sm-6">
        <?php foreach($submissions as $submission): ?>
            <div class="col-sm-12 mt-2 gridSubmissions d-flex justify-content-center">
                <img src="../../img/<?= $submission['image_path']; ?>" class="img-thumbnail img-fluid" />
                <div class="overlay">
                    <div class="text"><?= h($submission->subject); ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="col-sm-6">
        <?php foreach($submissions as $submission): ?>
            <div class="col-sm-12 content mt-2 gridSubmissions d-flex justify-content-center">
                <div class="inner">
                    <h4>
                        <?php foreach($scales as $scale): ?>
                            <?php if($scale->id === $submission->scale_id): ?>
                                <?= h($scale->scale) ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?= $this->Html->link(__(h($submission->subject)), ['controller' => 'Submissions', 'action' => 'view', $submission->id]) ?>
                        <?php foreach($manufacturers as $manufacturer): ?>
                            <?php if($manufacturer->id === $submission->manufacturer_id): ?>
                                (<?= h($manufacturer->name); ?>)
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <span>by</span>
                        <?php foreach($users as $user): ?>
                            <?php if($user->id === $submission->user_id): ?>
                                <?= h($user->name) ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </h4>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
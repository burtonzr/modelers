<div class="container-fluid">
    <h1 class="pagetitle text-center"><?= __('Model Ship Gallery') ?></h1>
    <?php 
        if($UserGroupID == 3) { 
    ?><!--
        <div class="row mt-5">
            <div class="col-12 col-sm-4">
                <?= $this->Html->link(__('New Model Type'), ['action' => 'add'], ['class' => 'model_types_view p-3 mt-4 btn btn-success']) ?>
            </div>
        </div>-->
    <?php } ?>
    <div class="row mt-5">
        <div class="col-sm-6">
            <?php foreach ($modelTypes as $modelType): ?>
                <h3 class="text-center mt-3" style="text-transform: capitalize;"><?= $this->Html->link(__(h($modelType->code)), ['action' => 'view', $modelType->id]) ?></h3>
                <div class="img-container text-center">
                    <?php if($modelType->id == 1) { ?>
                        <img src="img/naval.jpg" class="img-fluid" />
                    <?php } else if ($modelType->id == 2) { ?>
                        <img src="img/aircraft.jpg" class="img-fluid" />
                    <?php } else if ($modelType->id == 3) { ?>
                        <img src="img/automotive.jpg" class="img-fluid" />
                    <?php } else if ($modelType->id == 4) { ?>
                        <img src="img/armor.jpg" class="img-fluid" />
                    <?php } else if ($modelType->id == 5) { ?>
                        <img src="img/figures.jpg" class="img-fluid" />
                    <?php } else if ($modelType->id == 6) { ?>
                        <img src="img/trains.jpg" class="img-fluid" />
                    <?php } else if ($modelType->id == 7) { ?>
                        <img src="img/dioramas.jpg" class="img-fluid" />
                    <?php } else if ($modelType->id == 8) { ?>
                        <img src="img/spacecraft.jpg" class="img-fluid" />
                    <?php } ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="col-sm-6 mt-5 pt-2">
            <ul class="list-group">
                <?php foreach($submissionsData as $submission): ?>
                    <li class="list-group-item"><a href="http://localhost:8765/submissions/view/<?= h($submission->id) ?>"><?= h($submission->subject) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="paginator mt-5">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>

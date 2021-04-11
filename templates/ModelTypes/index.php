<div class="container-fluid">
    <h1 class="pagetitle text-center"><?= __('Model Ship Gallery') ?></h1>
    <div class="row mt-5">
        <?php foreach ($modelTypes as $modelType): ?>
            <div class="col-sm-6">
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
            </div>
        <?php endforeach; ?>
    </div>
</div>

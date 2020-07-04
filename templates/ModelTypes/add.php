<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h1 class="pagetitle text-center">Create Model Type</h1>
        </div>
    </aside>
    <div class="container content">
        <?= $this->Form->create($modelType) ?>
        <div class="row">
            <div class="col-12 col-sm-6">
                <?php
                    echo $this->Form->control('code');
                ?>
            </div>
            <div class="col-12 col-sm-6">
                <?php 
                    echo $this->Form->control('title');
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-6">
                <?php
                    echo $this->Form->control('description');
                ?>
            </div>
            <div class="col-12 col-sm-6">
                <?php
                    echo $this->Form->control('status_id', ['options' => $statuses]);
                ?>
            </div>
        </div>
        <?= $this->Form->button(__('Create Model Type'), ['class' => 'loginButton btn btn-success btn-block mt-3']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>

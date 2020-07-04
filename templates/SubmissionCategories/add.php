<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h1 class="pagetitle text-center">Create Category</h1>
        </div>
    </aside>
    <?= $this->Html->link(__('View Categories'), array('controller' => 'ModelTypes', 'action' => 'index'), ['class' => 'model_types_view p-3 mt-4 btn btn-info']) ?>
    <div class="container content mt-5">
        <?= $this->Form->create($submissionCategory) ?>
        <div class="row">
            <div class="col-12 col-sm-6">
                <?php
                    echo $this->Form->control('parent_id', ['options' => $parentSubmissionCategories, 'empty' => true]);
                ?>
            </div>
            <div class="col-12 col-sm-6">
                <?php
                    echo $this->Form->control('model_type_id', ['options' => $modelTypes]);
                ?>
            </div>
        </div>
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
                    echo $this->Form->control('status_id', ['options' => $statuses]);
                ?>
            </div>
            <div class="col-12 col-sm-6 mt-5">
                <?php
                    echo $this->Form->control('approved_yn');
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <?php
                    echo $this->Form->control('description');
                ?>
            </div>
        </div>
        <?= $this->Form->button(__('Create Category'), ['class' => 'loginButton btn btn-success btn-block mt-3']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>

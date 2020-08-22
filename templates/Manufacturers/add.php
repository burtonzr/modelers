<h2 class="pagetitle text-center">Add Manufacturer</h2>
<div class="container mt-5">
    <div class="row mb-5">
        <div class="col-12">
            <?= $this->Html->link(__('List Manufacturers'), ['action' => 'index'], ['class' => 'model_types_view p-3 mt-4 btn btn-info']) ?>
        </div>
    </div>
    <?= $this->Form->create($manufacturer) ?>
    <div class="row">
        <div class="col-12 col-sm-6 mt-3">
            <?php
                echo $this->Form->control('name', ['required' => true]);
            ?>
        </div>
        <div class="col-12 col-sm-6 mt-3">
            <?php
                echo $this->Form->control('description', ['required' => true]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-3">
            <?php
                echo $this->Form->control('website', ['type' => 'url', 'required' => true]);
            ?>
        </div>
    </div>
    <?php
        echo $this->Form->control('status_id', ['default' => 13, 'type' => 'hidden']);
        echo $this->Form->control('approved_yn', ['default' => 1, 'type' => 'hidden']);
    ?>
    <?= $this->Form->button(__('Add Manufacturer'), ['class' => 'loginButton btn btn-success btn-block mt-3']) ?>
    <?= $this->Form->end() ?>
</div>

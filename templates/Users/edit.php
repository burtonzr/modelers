<h2 class="pagetitle text-center">Edit <?= h($user->name) ?></h2>
<div class="row text-center">
    <?php if($UserGroupID == 3) { ?>
        <div class="col-12 col-sm-6 mt-3">
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $user->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'model_types_view p-3 mt-4 btn btn-danger']
            ) ?>
        </div>
    <?php } ?>
    <div class="col-12 col-sm-6 mt-3">
        <?= $this->Html->link(__('View Users'), ['action' => 'index'], ['class' => 'model_types_view p-3 mt-4 btn btn-info']) ?>
    </div>
</div>   
<div class="container content mt-5">
    <?= $this->Form->create($user) ?>
    <?php if($UserGroupID == 3) { ?>
        <div class="row">
            <div class="col-12 col-sm-6 mt-3">
                <?php
                    echo $this->Form->control('name');
                ?>
            </div>
            <div class="col-12 col-sm-6 mt-3">
                <?php
                    echo $this->Form->control('email');
                ?>
            </div>
        </div>
    <?php } ?>
    <div class="row">
        <?php if($UserGroupID == 3) { ?>
            <div class="col-12 col-sm-6 mt-3">
                <?php
                    echo $this->Form->control('password');
                ?>
            </div>
            <div class="col-12 col-sm-6 mt-3">
                <?php
                    echo $this->Form->control('UserGroupID', array('label' => 'Usergroup', 'options' => $usergroups));
                ?>
            </div>
        <?php } ?>
    </div>
    <?php if($UserGroupID == 3) { ?>
        <div class="row">
            <div class="col-12 col-sm-6 mt-3">
                <?php
                    echo $this->Form->control('status_id', ['options' => $statuses]);
                ?>
            </div>
            <div class="col-12 col-sm-6 mt-3">
                <?php
                    echo $this->Form->control('last_ip');
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-6 mt-3">
                    <?php
                        echo $this->Form->control('forum_user');
                    ?>
                </div>
            <div class="col-12 col-sm-6 mt-5">
                <?php
                    echo $this->Form->control('public_yn');
                ?>
            </div>
        </div>
    <?php } ?>
    <?= $this->Form->button(__('Update User'), ['class' => 'loginButton btn btn-success btn-block mt-3']) ?>
    <?= $this->Form->end() ?>
</div>


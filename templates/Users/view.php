<h1 class="pagetitle text-center"><?= h($user->name) ?></h1>
<!---
    <?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'side-nav-item']) ?>
    <?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'side-nav-item']) ?>
--->
<div class="container content">
    <table>
        <tr>
            <th><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($user->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Last Ip') ?></th>
            <td><?= h($user->last_ip) ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= $user->has('status') ? $this->Html->link($user->status->title, ['controller' => 'Statuses', 'action' => 'view', $user->status->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Forum User') ?></th>
            <td><?= $this->Number->format($user->forum_user) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($user->modified) ?></td>
        </tr>
        <tr>
            <th><?= __('Public Yn') ?></th>
            <td><?= $user->public_yn ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
<h2 class="pagetitle text-center mt-5"><?= __('Related Submissions') ?></h2>
<div class="row mt-5">
    <?php if (!empty($user->submissions)) : ?>
        <?php foreach ($user->submissions as $submissions) : ?>
            <div class="col-sm-12 col-md-6 content mt-5 grid modeltypes">
                <div class="inner">
                    <h3 class="text-center" style="text-transform: capitalize;"><?= $this->Html->link(__(h($submissions->subject)), ['controller' => 'Submissions', 'action' => 'view', $submissions->id]) ?></h3>
                    <div class="img-container">
                        <img src="../../img/<?= h($submissions->image_path) ?>" class="img-fluid" />
                    </div>
                    
                    <!---
                    <?= h($submissions->description) ?>
                    <?= h($submissions->user_id) ?>
                    <?= h($submissions->model_type_id) ?>
                    <?= h($submissions->submission_category_id) ?>
                    <?= h($submissions->manufacturer_id) ?>
                    <?= h($submissions->scale_id) ?>
                    <?= h($submissions->status_id) ?>
                    <?= h($submissions->created) ?>
                    <?= h($submissions->approved) ?>
                    <?= h($submissions->modified) ?>
                    --->
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
<!---
<?= $this->Html->link(__('Edit'), ['controller' => 'Submissions', 'action' => 'edit', $submissions->id]) ?>
<?= $this->Form->postLink(__('Delete'), ['controller' => 'Submissions', 'action' => 'delete', $submissions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $submissions->id)]) ?>
--->

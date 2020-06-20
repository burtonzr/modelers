<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PiwigoUser $piwigoUser
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Piwigo User'), ['action' => 'edit', $piwigoUser->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Piwigo User'), ['action' => 'delete', $piwigoUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $piwigoUser->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Piwigo Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Piwigo User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="piwigoUsers view content">
            <h3><?= h($piwigoUser->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Username') ?></th>
                    <td><?= h($piwigoUser->username) ?></td>
                </tr>
                <tr>
                    <th><?= __('Password') ?></th>
                    <td><?= h($piwigoUser->password) ?></td>
                </tr>
                <tr>
                    <th><?= __('Mail Address') ?></th>
                    <td><?= h($piwigoUser->mail_address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($piwigoUser->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

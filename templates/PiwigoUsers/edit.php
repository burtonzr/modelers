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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $piwigoUser->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $piwigoUser->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Piwigo Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="piwigoUsers form content">
            <?= $this->Form->create($piwigoUser) ?>
            <fieldset>
                <legend><?= __('Edit Piwigo User') ?></legend>
                <?php
                    echo $this->Form->control('username');
                    echo $this->Form->control('password');
                    echo $this->Form->control('mail_address');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

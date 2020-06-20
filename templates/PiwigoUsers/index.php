<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PiwigoUser[]|\Cake\Collection\CollectionInterface $piwigoUsers
 */
?>
<div class="piwigoUsers index content">
    <?= $this->Html->link(__('New Piwigo User'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Piwigo Users') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('username') ?></th>
                    <th><?= $this->Paginator->sort('password') ?></th>
                    <th><?= $this->Paginator->sort('mail_address') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($piwigoUsers as $piwigoUser): ?>
                <tr>
                    <td><?= $this->Number->format($piwigoUser->id) ?></td>
                    <td><?= h($piwigoUser->username) ?></td>
                    <td><?= h($piwigoUser->password) ?></td>
                    <td><?= h($piwigoUser->mail_address) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $piwigoUser->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $piwigoUser->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $piwigoUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $piwigoUser->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
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

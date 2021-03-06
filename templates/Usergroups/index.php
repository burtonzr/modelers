<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Usergroup[]|\Cake\Collection\CollectionInterface $usergroups
 */
?>
<div class="usergroups index content">
    <?= $this->Html->link(__('New Usergroup'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Usergroups') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('ID') ?></th>
                    <th><?= $this->Paginator->sort('Name') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usergroups as $usergroup): ?>
                <tr>
                    <td><?= $this->Number->format($usergroup->ID) ?></td>
                    <td><?= h($usergroup->Name) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $usergroup->ID]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $usergroup->ID]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $usergroup->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $usergroup->ID)]) ?>
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

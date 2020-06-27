<div class="container-fluid">
    <h1 style="font-weight: 400;" class="text-center"><?= __('Model Types') ?></h1>
    <div class="row mt-5">
        <?php foreach ($modelTypes as $modelType): ?>
            <div class="col-12 col-sm-6 content">
                <h3 class="text-center" style="text-transform: capitalize;"><?= $this->Html->link(__(h($modelType->code)), ['action' => 'view', $modelType->id]) ?></h3>
                <img src="http://www.modelersgallery.com/dev-alcapwin/img/gallery/defaults/spacecraft.jpg" />
            </div>
        <?php endforeach; ?>
    </div>
    <div class="paginator mt-5">
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

    <?php /* ?>
    <?= $this->Html->link(__('New Model Type'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Model Types') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('code') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('status_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($modelTypes as $modelType): ?>
                <tr>
                    <td><?= $this->Number->format($modelType->id) ?></td>
                    <td><?= h($modelType->code) ?></td>
                    <td><?= h($modelType->title) ?></td>
                    <td><?= $modelType->has('status') ? $this->Html->link($modelType->status->title, ['controller' => 'Statuses', 'action' => 'view', $modelType->status->id]) : '' ?></td>
                    <td><?= h($modelType->created) ?></td>
                    <td><?= h($modelType->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $modelType->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $modelType->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $modelType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $modelType->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php // */ ?>


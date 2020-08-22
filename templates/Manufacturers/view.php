<h2 class="text-center"><?= h($manufacturer->name) ?></h2>
<div class="row">
    <!---
    <?= $this->Html->link(__('Edit Manufacturer'), ['action' => 'edit', $manufacturer->id], ['class' => 'side-nav-item']) ?>
    <?= $this->Form->postLink(__('Delete Manufacturer'), ['action' => 'delete', $manufacturer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $manufacturer->id), 'class' => 'side-nav-item']) ?>
    <?= $this->Html->link(__('List Manufacturers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
     --->
    <div class="col-12 col-sm-4">
        <?= $this->Html->link(__('New Manufacturer'), ['action' => 'add'], ['class' => 'model_types_view p-3 mt-2 btn btn-success']) ?>
    </div>
</div>
<div style="margin-left: 10px; margin-right: 10px;" class="mt-3">
    <?php if (!empty($manufacturer->submissions)) : ?>
    <div class="table-responsive">
        <table>
            <tr>
                <th style="display: none;"><?= __('Id') ?></th>
                <th><?= __('User') ?></th>
                <th><?= __('Subject') ?></th>
                <th><?= __('Model Type') ?></th>
                <th><?= __('Submission Category') ?></th>
                <th><?= __('Manufacturer') ?></th>
                <th><?= __('Custom Manufacturer') ?></th>
                <th><?= __('Description') ?></th>
                <th><?= __('Scale') ?></th>
                <th><?= __('Status') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Approved') ?></th>
                <th><?= __('Modified') ?></th>
                <th><?= __('Image Path') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($manufacturer->submissions as $submissions) : ?>
            <tr>
                <td style="display: none;"><?= h($submissions->id) ?></td>
                <td><?= h($submissions->user_id) ?></td>
                <td><?= h($submissions->subject) ?></td>
                <td><?= h($submissions->model_type_id) ?></td>
                <td><?= h($submissions->submission_category_id) ?></td>
                <td><?= h($submissions->manufacturer_id) ?></td>
                <td><?= h($submissions->Custom_Manufacturer) ?></td>
                <td><?= h($submissions->description) ?></td>
                <td><?= h($submissions->scale_id) ?></td>
                <td><?= h($submissions->status_id) ?></td>
                <td><?= h($submissions->created) ?></td>
                <td><?= h($submissions->approved) ?></td>
                <td><?= h($submissions->modified) ?></td>
                <td><?= h($submissions->image_path) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Submissions', 'action' => 'view', $submissions->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Submissions', 'action' => 'edit', $submissions->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Submissions', 'action' => 'delete', $submissions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $submissions->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php endif; ?>
</div>


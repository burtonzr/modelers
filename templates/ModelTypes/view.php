<div class="container-fluid">
    <h1 class="pagetitle text-center"><?= h($modelType->title) ?> Categories</h1>
    <div class="row text-center">
        <div class="col-12 col-sm-4">
            <?= $this->Html->link(__('Edit Model Type'), ['action' => 'edit', $modelType->id], ['class' => 'model_types_view p-3 mt-4 btn btn-warning']) ?>
        </div>
        <div class="col-12 col-sm-4">
            <?= $this->Html->link(__('Model Types'), ['action' => 'index'], ['class' => 'model_types_view p-3 mt-4 btn btn-info']) ?>
        </div>
        <div class="col-12 col-sm-4">
            <?= $this->Html->link(__('New Model Type'), ['action' => 'add'], ['class' => 'model_types_view p-3 mt-4 btn btn-success']) ?>
        </div>
    </div>
    <div class="row mt-5">
        <?php if (!empty($modelType->submission_categories)) : ?>
            <?php foreach ($modelType->submission_categories as $submissionCategories): ?>
                <div class="col-sm-12 col-md-6 content mt-5 gridSubmissions modeltypes">
                    <div class="inner">
                        <h3 class="text-center" style="text-transform: capitalize; margin-top: 40px;"><?= $this->Html->link(h($submissionCategories->title), ['controller' => 'SubmissionCategories', 'action' => 'view', $submissionCategories->id]) ?></h3>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="column-responsive column-80 mt-5">
        <div class="modelTypes view content">
            <div class="related">
                <?php if (!empty($modelType->submission_categories)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Parent Id') ?></th>
                            <th><?= __('Model Type Id') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Status Id') ?></th>
                            <th><?= __('Approved Yn') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($modelType->submission_categories as $submissionCategories) : ?>
                        <tr>
                            <td><?= h($submissionCategories->id) ?></td>
                            <td><?= h($submissionCategories->parent_id) ?></td>
                            <td><?= h($submissionCategories->model_type_id) ?></td>
                            <td><?= h($submissionCategories->code) ?></td>
                            <td><?= h($submissionCategories->title) ?></td>
                            <td><?= h($submissionCategories->description) ?></td>
                            <td><?= h($submissionCategories->status_id) ?></td>
                            <td><?= h($submissionCategories->approved_yn) ?></td>
                            <td><?= h($submissionCategories->created) ?></td>
                            <td><?= h($submissionCategories->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'SubmissionCategories', 'action' => 'view', $submissionCategories->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'SubmissionCategories', 'action' => 'edit', $submissionCategories->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'SubmissionCategories', 'action' => 'delete', $submissionCategories->id], ['confirm' => __('Are you sure you want to delete # {0}?', $submissionCategories->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Submission Fields') ?></h4>
                <?php if (!empty($modelType->submission_fields)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Model Type Id') ?></th>
                            <th><?= __('Field Name') ?></th>
                            <th><?= __('Label') ?></th>
                            <th><?= __('Element Type') ?></th>
                            <th><?= __('Enum Options') ?></th>
                            <th><?= __('Required Yn') ?></th>
                            <th><?= __('Admin Yn') ?></th>
                            <th><?= __('Status Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($modelType->submission_fields as $submissionFields) : ?>
                        <tr>
                            <td><?= h($submissionFields->id) ?></td>
                            <td><?= h($submissionFields->model_type_id) ?></td>
                            <td><?= h($submissionFields->field_name) ?></td>
                            <td><?= h($submissionFields->label) ?></td>
                            <td><?= h($submissionFields->element_type) ?></td>
                            <td><?= h($submissionFields->enum_options) ?></td>
                            <td><?= h($submissionFields->required_yn) ?></td>
                            <td><?= h($submissionFields->admin_yn) ?></td>
                            <td><?= h($submissionFields->status_id) ?></td>
                            <td><?= h($submissionFields->created) ?></td>
                            <td><?= h($submissionFields->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'SubmissionFields', 'action' => 'view', $submissionFields->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'SubmissionFields', 'action' => 'edit', $submissionFields->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'SubmissionFields', 'action' => 'delete', $submissionFields->id], ['confirm' => __('Are you sure you want to delete # {0}?', $submissionFields->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Submissions') ?></h4>
                <?php if (!empty($modelType->submissions)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Subject') ?></th>
                            <th><?= __('Model Type Id') ?></th>
                            <th><?= __('Submission Category Id') ?></th>
                            <th><?= __('Manufacturer Id') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Scale Id') ?></th>
                            <th><?= __('Main Image') ?></th>
                            <th><?= __('Status Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Approved') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($modelType->submissions as $submissions) : ?>
                        <tr>
                            <td><?= h($submissions->id) ?></td>
                            <td><?= h($submissions->user_id) ?></td>
                            <td><?= h($submissions->subject) ?></td>
                            <td><?= h($submissions->model_type_id) ?></td>
                            <td><?= h($submissions->submission_category_id) ?></td>
                            <td><?= h($submissions->manufacturer_id) ?></td>
                            <td><?= h($submissions->description) ?></td>
                            <td><?= h($submissions->scale_id) ?></td>
                            <td><?= h($submissions->main_image) ?></td>
                            <td><?= h($submissions->status_id) ?></td>
                            <td><?= h($submissions->created) ?></td>
                            <td><?= h($submissions->approved) ?></td>
                            <td><?= h($submissions->modified) ?></td>
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
        </div>
    </div>
</div>

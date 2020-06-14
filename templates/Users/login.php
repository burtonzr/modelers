<div class="users form">
    <?= $this->Flash->render() ?>
    <h3>Login</h3>
    <?= $this->Form->create(null, array('class' => 'class', 'autocomplete' => false)) ?>
    <fieldset>
        <legend><?= __('Please enter your username and password') ?></legend>
        <?= $this->Form->control('email', ['required' => true]) ?>
        <?= $this->Form->control('password', ['required' => true, 'autocomplete' => false]) ?>
    </fieldset>
    <?= $this->Form->submit(__('Login')); ?>
    <?= $this->Form->end() ?>

    <?= $this->Html->link("Add User", ['action' => 'add']) ?>
</div>
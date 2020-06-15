<div class="users form">
    <?= $this->Flash->render() ?>
    <h1 style="text-align: center;">Login</h1>
    <?= $this->Form->create(null, array('class' => 'class', 'autocomplete' => false)) ?>
    <fieldset>
        <legend style="font-size: 18px;"><?= __('Please enter your username and password') ?></legend>
        <?= $this->Form->control('email', ['required' => true]) ?>
        <?= $this->Form->control('password', ['required' => true, 'autocomplete' => false]) ?>
    </fieldset>
    <?php
        echo $this->Form->button('Login', ['class' => 'loginButton btn btn-danger btn-block']);
        /*echo $this->Html->link('Register', ['action' => 'add', ['class' => 'btn btn-success']]);*/
        echo $this->Form->end();
    ?>
</div>
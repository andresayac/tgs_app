<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var \Cake\Collection\CollectionInterface|string[] $roles
 * @var \Cake\Collection\CollectionInterface|string[] $departaments
 * @var \Cake\Collection\CollectionInterface|string[] $branchs
 * @var \Cake\Collection\CollectionInterface|string[] $designations
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Add User') ?></legend>
                <?php
                    echo $this->Form->control('rol_id', ['options' => $roles, 'empty' => true]);
                    echo $this->Form->control('username');
                    echo $this->Form->control('password');
                    echo $this->Form->control('name');
                    echo $this->Form->control('lastname');
                    echo $this->Form->control('document_type');
                    echo $this->Form->control('document');
                    echo $this->Form->control('date_birthday', ['empty' => true]);
                    echo $this->Form->control('telephone');
                    echo $this->Form->control('active');
                    echo $this->Form->control('dep_id', ['options' => $departaments, 'empty' => true]);
                    echo $this->Form->control('branch_id', ['options' => $branchs, 'empty' => true]);
                    echo $this->Form->control('designation_id', ['options' => $designations, 'empty' => true]);
                    echo $this->Form->control('fingerprint');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

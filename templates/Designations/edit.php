<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Designation $designation
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $designation->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $designation->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Designations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="designations form content">
            <?= $this->Form->create($designation) ?>
            <fieldset>
                <legend><?= __('Edit Designation') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('active');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

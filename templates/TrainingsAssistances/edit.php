<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TrainingsAssistance $trainingsAssistance
 * @var string[]|\Cake\Collection\CollectionInterface $trainings
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $trainingsAssistance->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $trainingsAssistance->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Trainings Assistances'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="trainingsAssistances form content">
            <?= $this->Form->create($trainingsAssistance) ?>
            <fieldset>
                <legend><?= __('Edit Trainings Assistance') ?></legend>
                <?php
                    echo $this->Form->control('training_id', ['options' => $trainings, 'empty' => true]);
                    echo $this->Form->control('users');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

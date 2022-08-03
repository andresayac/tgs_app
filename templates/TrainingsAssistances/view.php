<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TrainingsAssistance $trainingsAssistance
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Trainings Assistance'), ['action' => 'edit', $trainingsAssistance->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Trainings Assistance'), ['action' => 'delete', $trainingsAssistance->id], ['confirm' => __('Are you sure you want to delete # {0}?', $trainingsAssistance->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Trainings Assistances'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Trainings Assistance'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="trainingsAssistances view content">
            <h3><?= h($trainingsAssistance->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Training') ?></th>
                    <td><?= $trainingsAssistance->has('training') ? $this->Html->link($trainingsAssistance->training->name, ['controller' => 'Trainings', 'action' => 'view', $trainingsAssistance->training->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($trainingsAssistance->id) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Users') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($trainingsAssistance->users)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>

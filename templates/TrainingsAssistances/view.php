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
                    <th><?= __('User') ?></th>
                    <td><?= $trainingsAssistance->has('user') ? $this->Html->link($trainingsAssistance->user->fullname, ['controller' => 'Users', 'action' => 'view', $trainingsAssistance->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Type Check') ?></th>
                    <td><?= h($trainingsAssistance->type_check) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($trainingsAssistance->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Checked') ?></th>
                    <td><?= $trainingsAssistance->checked === null ? '' : $this->Number->format($trainingsAssistance->checked) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created By') ?></th>
                    <td><?= $trainingsAssistance->created_by === null ? '' : $this->Number->format($trainingsAssistance->created_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified By') ?></th>
                    <td><?= $trainingsAssistance->modified_by === null ? '' : $this->Number->format($trainingsAssistance->modified_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($trainingsAssistance->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($trainingsAssistance->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

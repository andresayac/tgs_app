<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Training $training
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Training'), ['action' => 'edit', $training->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Training'), ['action' => 'delete', $training->id], ['confirm' => __('Are you sure you want to delete # {0}?', $training->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Trainings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Training'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="trainings view content">
            <h3><?= h($training->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($training->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Designations') ?></th>
                    <td><?= h($training->designations) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($training->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Start Date') ?></th>
                    <td><?= h($training->start_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('End Date') ?></th>
                    <td><?= h($training->end_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($training->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($training->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Note') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($training->note)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Trainings Assistances') ?></h4>
                <?php if (!empty($training->trainings_assistances)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Training Id') ?></th>
                            <th><?= __('Users') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($training->trainings_assistances as $trainingsAssistances) : ?>
                        <tr>
                            <td><?= h($trainingsAssistances->id) ?></td>
                            <td><?= h($trainingsAssistances->training_id) ?></td>
                            <td><?= h($trainingsAssistances->users) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'TrainingsAssistances', 'action' => 'view', $trainingsAssistances->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'TrainingsAssistances', 'action' => 'edit', $trainingsAssistances->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'TrainingsAssistances', 'action' => 'delete', $trainingsAssistances->id], ['confirm' => __('Are you sure you want to delete # {0}?', $trainingsAssistances->id)]) ?>
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

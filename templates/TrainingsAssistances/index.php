<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TrainingsAssistance[]|\Cake\Collection\CollectionInterface $trainingsAssistances
 */
?>
<div class="trainingsAssistances index content">
    <?= $this->Html->link(__('New Trainings Assistance'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Trainings Assistances') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('training_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trainingsAssistances as $trainingsAssistance): ?>
                <tr>
                    <td><?= $this->Number->format($trainingsAssistance->id) ?></td>
                    <td><?= $trainingsAssistance->has('training') ? $this->Html->link($trainingsAssistance->training->name, ['controller' => 'Trainings', 'action' => 'view', $trainingsAssistance->training->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $trainingsAssistance->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $trainingsAssistance->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $trainingsAssistance->id], ['confirm' => __('Are you sure you want to delete # {0}?', $trainingsAssistance->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>

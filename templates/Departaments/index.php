<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Departament[]|\Cake\Collection\CollectionInterface $departaments
 */
?>
<div class="departaments index content">
    <?= $this->Html->link(__('New Departament'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Departaments') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('active') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($departaments as $departament): ?>
                <tr>
                    <td><?= $this->Number->format($departament->id) ?></td>
                    <td><?= h($departament->name) ?></td>
                    <td><?= $departament->active === null ? '' : $this->Number->format($departament->active) ?></td>
                    <td><?= h($departament->created) ?></td>
                    <td><?= h($departament->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $departament->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $departament->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $departament->id], ['confirm' => __('Are you sure you want to delete # {0}?', $departament->id)]) ?>
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

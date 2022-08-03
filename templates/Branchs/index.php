<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Branch[]|\Cake\Collection\CollectionInterface $branchs
 */
?>
<div class="branchs index content">
    <?= $this->Html->link(__('New Branch'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Branchs') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('active') ?></th>
                    <th><?= $this->Paginator->sort('com_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($branchs as $branch): ?>
                <tr>
                    <td><?= $this->Number->format($branch->id) ?></td>
                    <td><?= h($branch->name) ?></td>
                    <td><?= $branch->active === null ? '' : $this->Number->format($branch->active) ?></td>
                    <td><?= $branch->has('company') ? $this->Html->link($branch->company->name, ['controller' => 'Companies', 'action' => 'view', $branch->company->id]) : '' ?></td>
                    <td><?= h($branch->created) ?></td>
                    <td><?= h($branch->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $branch->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $branch->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $branch->id], ['confirm' => __('Are you sure you want to delete # {0}?', $branch->id)]) ?>
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

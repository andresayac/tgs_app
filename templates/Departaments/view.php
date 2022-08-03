<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Departament $departament
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Departament'), ['action' => 'edit', $departament->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Departament'), ['action' => 'delete', $departament->id], ['confirm' => __('Are you sure you want to delete # {0}?', $departament->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Departaments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Departament'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="departaments view content">
            <h3><?= h($departament->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($departament->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($departament->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Active') ?></th>
                    <td><?= $departament->active === null ? '' : $this->Number->format($departament->active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($departament->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($departament->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

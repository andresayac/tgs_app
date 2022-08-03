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
            <?= $this->Html->link(__('Edit Designation'), ['action' => 'edit', $designation->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Designation'), ['action' => 'delete', $designation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $designation->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Designations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Designation'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="designations view content">
            <h3><?= h($designation->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($designation->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($designation->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Active') ?></th>
                    <td><?= $designation->active === null ? '' : $this->Number->format($designation->active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($designation->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($designation->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Users') ?></h4>
                <?php if (!empty($designation->users)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Rol Id') ?></th>
                            <th><?= __('Username') ?></th>
                            <th><?= __('Password') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Lastname') ?></th>
                            <th><?= __('Document Type') ?></th>
                            <th><?= __('Document') ?></th>
                            <th><?= __('Date Birthday') ?></th>
                            <th><?= __('Telephone') ?></th>
                            <th><?= __('Active') ?></th>
                            <th><?= __('Dep Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Designation Id') ?></th>
                            <th><?= __('Fingerprint') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($designation->users as $users) : ?>
                        <tr>
                            <td><?= h($users->id) ?></td>
                            <td><?= h($users->rol_id) ?></td>
                            <td><?= h($users->username) ?></td>
                            <td><?= h($users->password) ?></td>
                            <td><?= h($users->name) ?></td>
                            <td><?= h($users->lastname) ?></td>
                            <td><?= h($users->document_type) ?></td>
                            <td><?= h($users->document) ?></td>
                            <td><?= h($users->date_birthday) ?></td>
                            <td><?= h($users->telephone) ?></td>
                            <td><?= h($users->active) ?></td>
                            <td><?= h($users->dep_id) ?></td>
                            <td><?= h($users->branch_id) ?></td>
                            <td><?= h($users->designation_id) ?></td>
                            <td><?= h($users->fingerprint) ?></td>
                            <td><?= h($users->created) ?></td>
                            <td><?= h($users->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $users->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $users->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Are you sure you want to delete # {0}?', $users->id)]) ?>
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

<?php
$c = $this->request->getParam('controller');
$a = $this->request->getParam('action');


$active = ["class" => "active"];

?>

<div class="left-side-bar">
    <div class="brand-logo">
        <a href="/">
            <img src="/img/mti-logo-dark.png" alt="" class="dark-logo">
            <img src="/img/mti-logo-light.png" alt="" class="light-logo">
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
            <?php if (!empty($_permisos_user_['dashboard']['index'])) : ?>
                <li>
                    <a href="/" class="dropdown-toggle no-arrow <?= ($c === 'Dashboard' && $a === 'index') ?  'active' : ''; ?>">
                        <span class="micon dw dw-house-1"></span><span class="mtext">Inicio</span>
                    </a>
                </li>
                <?php endif ?>
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon dw dw-presentation-2"></span><span class="mtext">Capacitación</span>
                    </a>
                    <ul class="submenu">
                        <li><?= $this->Html->link('Mis Capacitaciónes', ['controller' => 'Trainings', 'action' => 'me'], ($c === 'Trainings' && $a === 'me') ? ["class" => "active"] : []) ?></li>
                        <li><?= $this->Html->link('Capacitaciones', ['controller' => 'Trainings', 'action' => 'index'], ($c === 'Trainings' && $a === 'index') ? ["class" => "active"] : []) ?></li>

                    </ul>
                </li>
                <li>
                    <a href="/trainings/calendar" class="dropdown-toggle no-arrow <?= ($c === 'Trainings' && $a === 'calendar') ?  'active' : ''; ?>">
                        <span class="micon bi bi-calendar4-week"></span><span class="mtext">Calendario</span>
                    </a>
                </li>

                <?php if (!empty($_permisos_user_['users']['index'])) : ?>
                <li>
                    <a href="/users" class="dropdown-toggle no-arrow <?= ($c === 'Users') ?  'active' : ''; ?>">
                        <span class="micon dw dw-user"></span><span class="mtext">Usuarios</span>
                    </a>
                </li>
                <?php endif ?>

                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <?php if (!empty($_permisos_user_['companies']['index'])) : ?>
                <li>
                    <div class="sidebar-small-cap">Extra</div>
                </li>
                <li>
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon dw dw-building1"></span><span class="mtext">Empresa</span>
                    </a>
                    <ul class="submenu">
                        <li><?php if (isset($_permisos_user_['companies'])) echo $this->Html->link('Empresa', ['controller' => 'Companies', 'action' => 'index'], ($c === 'Companies') ? ["class" => "active"] : []); ?></li>
                        <li><?php if (isset($_permisos_user_['branchs'])) echo $this->Html->link('Sucursal', ['controller' => 'Branchs', 'action' => 'index'], ($c === 'Branchs') ? ["class" => "active"] : []); ?></li>
                        <li><?php if (isset($_permisos_user_['departaments'])) echo $this->Html->link('Areas', ['controller' => 'Departaments', 'action' => 'index'], ($c === 'Departaments') ? ["class" => "active"] : []); ?></li>
                        <li><?php if (isset($_permisos_user_['designations'])) echo $this->Html->link('Cargos', ['controller' => 'Designations', 'action' => 'index'], ($c === 'Designations') ? ["class" => "active"] : []); ?></li>
                    </ul>
                   
                </li>
                <?php endif ?>

                <li>
                    <?php if (!empty($_permisos_user_['roles']['index'])) : ?>
                        <a href="/roles" class="dropdown-toggle no-arrow <?= ($c === 'Roles') ?  'active' : ''; ?>">
                            <span class="micon dw dw-user-11"></span><span class="mtext">Roles</span>
                        </a>
                    <?php endif ?>
                </li>
            </ul>
        </div>
    </div>
</div>
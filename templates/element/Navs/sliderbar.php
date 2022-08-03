<?php
$c = $this->request->getParam('controller');
$a = $this->request->getParam('action');

$active = ["class" => "active"];

?>

<div class="left-side-bar">
    <div class="brand-logo">
        <a href="/">
            <img src="/img/tgs-logo-dark.png"  alt="" class="dark-logo">
            <img src="/img/tgs-logo-light.png" alt="" class="light-logo">
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon dw dw-house-1"></span><span class="mtext">Inicio</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="/">Dashboard style 1</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon dw dw-presentation-2"></span><span class="mtext">Capacitación</span>
                    </a>
                    <ul class="submenu">
                        <li><?= $this->Html->link('Capacitaciónes', ['controller' => 'Trainings', 'action' => 'index'], ($c === 'Trainings') ? ["class" => "active"] : []) ?></li>
                        <li><?= $this->Html->link('Asistencia Capacitación', ['controller' => 'TrainingsAssistances', 'action' => 'index'], ($c === 'TrainingsAssistances') ? ["class" => "active"] : []) ?></li>
                    </ul>
                </li>
                <li>
                    <a href="/users" class="dropdown-toggle no-arrow <?= ($c === 'Users') ?  'active' : ''; ?>">
                        <span class="micon dw dw-user"></span><span class="mtext">Usuarios</span>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <div class="sidebar-small-cap">Extra</div>
                </li>
                <li>
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon dw dw-building1"></span><span class="mtext">Empresa</span>
                    </a>
                    <ul class="submenu">
                        <li><?= $this->Html->link('Compañia', ['controller' => 'Companies', 'action' => 'index'], ($c === 'Companies') ? ["class" => "active"] : []) ?></li>
                        <li><?= $this->Html->link('Sucursal', ['controller' => 'Branchs', 'action' => 'index'], ($c === 'Branchs') ? ["class" => "active"] : []) ?></li>
                        <li><?= $this->Html->link('Areas', ['controller' => 'Departaments', 'action' => 'index'], ($c === 'Departaments') ? ["class" => "active"] : []) ?></li>
                        <li><?= $this->Html->link('Cargos', ['controller' => 'Designations', 'action' => 'index'], ($c === 'Designations') ? ["class" => "active"] : []) ?></li>
                    </ul>
                </li>

                <li>
                    <a href="/roles" class="dropdown-toggle no-arrow <?= ($c === 'Roles') ?  'active' : ''; ?>">
                        <span class="micon dw dw-user-11"></span><span class="mtext">Roles</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
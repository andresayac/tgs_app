<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>

<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>

    <!-- General CSS Files -->
    <?php echo $this->Html->css("/vendors/styles/core.css"); ?>
    <?php echo $this->Html->css("/vendors/styles/icon-font.min.css"); ?>
    <?php echo $this->Html->css("/src/plugins/datatables/css/dataTables.bootstrap4.min.css"); ?>
    <?php echo $this->Html->css("/src/plugins/datatables/css/responsive.bootstrap4.min.css"); ?>
    <?php echo $this->Html->css("/vendors/styles/style.css"); ?>
    <?php echo $this->Html->css("/css/iziToast.min.css"); ?>


    <!-- pace js -->
    <?php echo $this->Html->script("/vendors/scripts/core.js"); ?>
    <?php echo $this->Html->script("/vendors/scripts/script.min.js"); ?>
    <?php echo $this->Html->script("/vendors/scripts/process.js"); ?>
    <?php echo $this->Html->script("/vendors/scripts/layout-settings.js"); ?>
    <?php echo $this->Html->script("/src/plugins/datatables/js/jquery.dataTables.min.js"); ?>
    <?php echo $this->Html->script("/src/plugins/datatables/js/dataTables.bootstrap4.min.js"); ?>
    <?php echo $this->Html->script("/src/plugins/datatables/js/dataTables.responsive.min.js"); ?>
    <?php echo $this->Html->script("/src/plugins/datatables/js/responsive.bootstrap4.min.js"); ?>
    <?php echo $this->Html->script("/vendors/scripts/dashboard.js"); ?>
    <?php echo $this->Html->script("/src/scripts/iziToast.min.js"); ?>



    <?= $this->Html->meta('icon') ?>


    <?php
    // $this->Html->css(['normalize.min', 'milligram.min', 'cake']) 


    //$this->fetch('meta') 
    //$this->fetch('css') 
    //$this->fetch('script') 
    ?>
</head>

<body>

    <?php echo $this->element('Navs\navbar');  ?>
    <?php echo $this->element('Navs\sliderbar');  ?>


    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="pd-ltr-20">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
            <div class="row">
                <div class="footer-wrap pd-20 mb-20 card-box">
                    HRM TGS <a href="/" target="_blank">Colombia</a>
                </div>
            </div>
        </div>

        <footer>
        </footer>

</body>

</html>
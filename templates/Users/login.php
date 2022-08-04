<!DOCTYPE html>
<html>

<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= 'Login' ?>:
        <?= $this->fetch('title') ?>
    </title>

    <!-- General CSS Files -->
    <?php echo $this->Html->css("/vendors/styles/core.css"); ?>
    <?php echo $this->Html->css("/vendors/styles/icon-font.min.css"); ?>
    <?php echo $this->Html->css("/src/plugins/datatables/css/dataTables.bootstrap4.min.css"); ?>
    <?php echo $this->Html->css("/src/plugins/datatables/css/responsive.bootstrap4.min.css"); ?>
    <?php echo $this->Html->css("/vendors/styles/style.css"); ?>


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


    <?= $this->Html->meta('icon') ?>

</head>

<body class="login-page">
    <div class="login-header box-shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <a href="/">
                    <?= $this->Html->image('/img/tgs-logo-dark.png'); ?>
                </a>
            </div>
        </div>
    </div>
    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7">
                    <?= $this->Html->image('/vendors/images/login-page-img.png'); ?>
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <div class="login-title">
                            <h2 class="text-center text-primary">Ingreso</h2>
                        </div>
                        <?php echo $this->Flash->render() ?>
                        <?php echo $this->Form->create(null) ?>
                        <div class="input-group custom">
                            <?php echo $this->Form->input('username', ['required' => true, 'autofocus' => true, 'label' => false, 'class' => 'form-control form-control-lg', 'type' => 'text']) ?>
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                            </div>
                        </div>
                        <div class="input-group custom">
                            <?php echo $this->Form->input('password', ['required' => true, 'label' => false, 'class' => 'form-control form-control-lg', 'type' => 'password']) ?>
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                            </div>
                        </div>
                        <div class="row pb-30">
                            <div class="col-6">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1" />
                                    <label class="custom-control-label" for="customCheck1">Recordar</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="forgot-password">
                                    <a href="#">Olvido su Contraseña<a href=""></a></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-group mb-0">
                                    <?php echo  $this->Form->button('Iniciar Sesion', ['class' => "btn btn-primary btn-lg btn-block"]); ?>
                                </div>
                            </div>
                        </div>
                        <?php echo $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
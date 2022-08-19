<!DOCTYPE html>
<html>

<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= 'TGS' ?>:
        <?= 'Login' ?>
    </title>

    <!-- General CSS Files -->
    <?php echo $this->Html->css("/vendors/styles/core.css"); ?>
    <?php echo $this->Html->css("/vendors/styles/icon-font.min.css"); ?>
    <?php echo $this->Html->css("/src/plugins/datatables/css/dataTables.bootstrap4.min.css"); ?>
    <?php echo $this->Html->css("/src/plugins/datatables/css/responsive.bootstrap4.min.css"); ?>
    <?php echo $this->Html->css("/vendors/styles/style.css"); ?>
    <!-- pace js -->

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

</head>

<body class="login-page">
    <div class="login-header box-shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <a href="/">
                    <img src="/img/tgs-logo-dark.png" alt="">
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
                            <?php echo $this->Form->input('username', ['required' => true, 'autofocus' => true, 'label' => false, 'class' => 'form-control form-control-lg', 'type' => 'text', 'placeholder' => "Usuario"]) ?>
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                            </div>
                        </div>
                        <div class="input-group custom">
                            <?php echo $this->Form->input('password', ['required' => true, 'label' => false, 'class' => 'form-control form-control-lg', 'type' => 'password', 'placeholder' => "********"]) ?>
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

    <?php echo $this->Html->css("/css/iziToast.min.css"); ?>
    <?php echo $this->Html->script("/src/scripts/iziToast.min.js"); ?>
</body>

</html>
<?php /** @var ViewTheme $this */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title_for_layout; ?> - <?php echo __d('croogo', 'Croogo'); ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php
    echo $this->Html->css([
        '/bower_components/bootstrap/dist/css/bootstrap.min',
        '/bower_components/font-awesome/css/font-awesome.min',
        '/bower_components/Ionicons/css/ionicons.min',
        'adminlte.min',
        '/plugins/iCheck/square/blue',
    ]);
    echo $this->fetch('css'); ?>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <?php echo $this->Html->link(
            __d('croogo', 'Back to') . " " . $this->Html->tag('b', Configure::read('Site.title')),
            '/'
        ); ?>
    </div>
    <div class="login-box-body">
        <?php
        echo $this->Layout->sessionFlash();
        echo $this->fetch('content');
        ?>
    </div>
</div>

<?php
echo $this->Html->script([
    '/bower_components/jquery/dist/jquery.min',
    '/bower_components/bootstrap/dist/js/bootstrap.min',
    '/plugins/iCheck/icheck.min',
]);
echo $this->fetch('script'); ?>
</body>
</html>

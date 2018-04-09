<?php /** @var ViewIDE $this */ ?>
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
    ]);
    echo $this->fetch('bowerComponentCss');
    echo $this->Html->css(['adminlte.min', 'skins/skin-red.min', 'style',]);
    echo $this->fetch('css');
    echo $this->Layout->js(); ?>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">
    <div class="content-wrapper">
        <section class="content">
            <?php echo $this->Flash->render(); ?>
            <?php echo $this->fetch('content'); ?>
        </section>
    </div>
</div>

<?php
echo $this->Html->script([
    '/bower_components/jquery/dist/jquery.min', //stable
    '/bower_components/jquery-ui/jquery-ui.min', //stable
    '/bower_components/bootstrap/dist/js/bootstrap.min',
    '/bower_components/jquery-slimscroll/jquery.slimscroll.min',
    '/bower_components/fastclick/lib/fastclick',
]);
echo $this->fetch('bowerComponentJs');
echo $this->Html->script(['adminlte.min', 'app']);
echo $this->fetch('script');
echo "<!-- Croogo Section -->";
echo $this->element('admin/initializers');
echo $this->Blocks->get('scriptBottom');
echo $this->Js->writeBuffer(); ?>
</body>
</html>

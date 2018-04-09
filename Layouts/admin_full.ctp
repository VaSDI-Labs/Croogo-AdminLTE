<?php /** @var ViewTheme $this */ ?>
<!DOCTYPE html>
<html>
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
        'skins/skin-blue.min',
    ]);
    echo $this->fetch('css'); ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <?php $user = $this->Session->read('Auth.User');
    echo $this->element('admin/header', ['user' => $user]);
    echo $this->element('admin/navigation', ['user' => $user]); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <?php $title = $title_for_layout;
            if($this->Blocks->exists('page_description')){
                $title .= $this->Html->tag('span', $this->fetch('page_description'));
            }
            echo $this->Html->tag('h1', $title);

            echo $this->element('admin/breadcrumb');?>
        </section>
        <section class="content container-fluid">
            <?php echo $this->Flash->render(); ?>
            <?php echo $this->fetch('content'); ?>
        </section>
    </div>
    <!-- /.content-wrapper -->

    <?php echo $this->element('admin/footer'); ?>
    <?php echo $this->element('admin/control-sidebar'); ?>
</div>
<!-- ./wrapper -->
<?php
echo $this->Layout->js();
echo $this->Html->script([
    '/bower_components/jquery/dist/jquery.min',
    '/bower_components/bootstrap/dist/js/bootstrap.min',
    '/bower_components/jquery-slimscroll/jquery.slimscroll.min',
    '/bower_components/fastclick/lib/fastclick',
    'adminlte.min',
]);
echo $this->fetch('script');
//echo $this->fetch('bowerComponentJs');

//echo $this->Html->script(['adminlte.min', 'app', 'choose']);

//echo "<!-- Croogo Section -->";
//echo $this->element('admin/initializers');
//echo $this->Blocks->get('scriptBottom');
//echo $this->Js->writeBuffer(); ?>
</body>
</html>

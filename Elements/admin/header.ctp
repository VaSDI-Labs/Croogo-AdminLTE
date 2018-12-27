<?php /** @var ViewAnnotation $this */ ?>
<!-- Main Header -->
<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo Router::url(Configure::read('Croogo.dashboardUrl')); ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>C</b>MS</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><?php echo Configure::read('Site.title'); ?></span>
    </a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li>
                    <a href="/" target="_blank" title="<?php echo __d('croogo', 'Visit website'); ?>">
                        <i class="fa fa-external-link"></i>
                    </a>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <?php $imagePath = '//www.gravatar.com/avatar/' . md5($user['email']) . '?s=160'; ?>
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="<?php echo $imagePath; ?>" class="user-image" alt="<?php echo $user['username']; ?>">
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs"><?php echo $user['username']; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?php echo $imagePath; ?>" class="img-circle" alt="<?php echo $user['username']; ?>">

                            <p><?php echo $user['username'] . " - Group: " . $user['Role']['title']; ?><small><?php echo __d('croogo', 'Member since %s', $this->Time->format('M. Y', $user['created']));?></small></p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="row">
                                <div class="col-xs-4 text-center">
                                    <?php echo $this->Html->link(__d('croogo', 'Edit Profile'), [
                                        'plugin' => 'users',
                                        'controller' => 'users',
                                        'action' => 'edit',
                                        $user['id']
                                    ]); ?>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Example</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Example</a>
                                </div>
                            </div>
                            <!-- /.row -->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?php echo $this->Html->link(__d('croogo', 'Profile'), [
                                    'plugin' => 'users',
                                    'controller' => 'users',
                                    'action' => 'view',
                                    $user['id']
                                ], [
                                    'class' => 'btn btn-default btn-flat'
                                ]); ?>
                            </div>
                            <div class="pull-right">
                                <?php echo $this->Html->link(__d('croogo', "Log out"), [
                                    'plugin' => 'users',
                                    'controller' => 'users',
                                    'action' => 'logout'
                                ], [
                                    'class' => 'btn btn-default btn-flat'
                                ]); ?>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar">
                        <i class="fa fa-gears"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>

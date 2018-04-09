<?php /** @var ViewTheme $this */ ?>
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo '//www.gravatar.com/avatar/' . md5($user['email']) . '?s=160'; ?>" class="img-circle" alt="<?php echo $user['username']; ?>">
            </div>
            <div class="pull-left info">
                <p><?php echo $user['username'] ?></p>
                <!-- Status -->
                <?php $config = ($user['status']) ? ['class' => 'text-success', 'text' => 'Online'] : ['class' => 'text-danger', 'text' => 'Offline']; ?>
                <a href="#"><i class="fa fa-circle <?php echo $config['class']; ?>"></i> <?php echo __d('croogo', $config['text']); ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <?php
        $cacheKey = 'adminnav_' . Configure::read('Config.language') . '_' .
            $this->Layout->getRoleId() . '_' . $this->request->url . '_' .
            md5(serialize($this->request->query));
        $navItems = Cache::read($cacheKey, 'croogo_menus');
        if ($navItems === false) {
            $navItems = $this->Croogo->adminMenus(CroogoNav::items(), [
                'htmlAttributes' => [
                    'class' => 'sidebar-menu',
                    'data-widget' => 'tree'
                ],
                'navigationHeader' => 'MAIN NAVIGATION',
                'childClass' => 'treeview-menu'
            ]);
            Cache::write($cacheKey, $navItems, 'croogo_menus');
        }
        echo $navItems; ?>
    </section>
</aside>
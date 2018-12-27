<?php /** @var ViewAnnotation $this */

$this->extend('/Common/admin_index');
$this->name = 'acl_permissions';
$this->Croogo->adminScript('Acl.acl_permissions');

$this->Html
	->addCrumb('', '/admin', ['icon' => $this->Theme->getIcon('home')])
	->addCrumb(__d('croogo', 'Users'), ['plugin' => 'users', 'controller' => 'users', 'action' => 'index'])
	->addCrumb(__d('croogo', 'Permissions'));

$this->start('actions');
    $dropdownBtn = $this->Form->button(__d('croogo', 'Tools') . ' <span class="caret"></span>', [
        'type' => 'button',
        'button' => 'default',
        'class' => 'dropdown-toggle',
        'data-toggle' => 'dropdown',
        'aria-haspopup' => 'true',
        'aria-expanded' => 'false'
    ]);
    $generateUrl = [
        'plugin' => 'acl',
        'controller' => 'acl_actions',
        'action' => 'generate',
        'permissions' => 1
    ];
    $out = $this->Croogo->adminAction(__d('croogo', 'Generate'), $generateUrl, [
        'button' => false,
        'list' => true,
        'method' => 'post',
        'tooltip' => [
            'data-title' => __d('croogo', 'Create new actions (no removal)'),
            'data-placement' => 'right',
        ],
    ]);
    $out .= $this->Croogo->adminAction(__d('croogo', 'Synchronize'), $generateUrl + ['sync' => 1], [
        'button' => false,
        'list' => true,
        'method' => 'post',
        'tooltip' => [
            'data-title' => __d('croogo', 'Create new & remove orphaned actions'),
            'data-placement' => 'right',
        ],
    ]);
    $dropdownBtn .= $this->Html->tag('ul', $out, ['class' => 'dropdown-menu']);

    echo $this->Html->div('btn-group', $dropdownBtn);

    echo $this->Croogo->adminAction(__d('croogo', 'Edit Actions'),
        ['controller' => 'acl_actions', 'action' => 'index', 'permissions' => 1]
    );
$this->end(); ?>

<div class="<?php echo $this->Theme->getCssClass('row'); ?>">
	<div class="<?php echo $this->Theme->getCssClass('columnFull'); ?>">

        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs" id="permissions-tab"><?php echo $this->Croogo->adminTabs(); ?></ul>
            <div class="tab-content"><?php echo $this->Croogo->adminTabs(); ?></div>
        </div>
	</div>
</div>

<?php $this->Js->buffer('AclPermissions.tabSwitcher();');

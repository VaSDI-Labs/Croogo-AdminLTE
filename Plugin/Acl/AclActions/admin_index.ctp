<?php
/** 
 * @var ViewAnnotation $this
 * @var array $acos
 */

$this->extend('/Common/admin_index');

$this->name = 'acos';
$this->Croogo->adminScript('Acl.acl_permissions');

$this->Html
	->addCrumb('', '/admin', ['icon' => $this->Theme->getIcon('home')])
	->addCrumb(__d('croogo', 'Users'), ['plugin' => 'users', 'controller' => 'users', 'action' => 'index'])
	->addCrumb(__d('croogo', 'Permissions'), ['plugin' => 'acl', 'controller' => 'acl_permissions',])
	->addCrumb(__d('croogo', 'Actions'));

$this->append('actions');
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
$this->end();

$this->set('tableClass', 'table permission-table');

$this->start('table-heading');
	$tableHeaders = $this->Html->tableHeaders([
		__d('croogo', 'Id'),
		__d('croogo', 'Alias'),
		__d('croogo', 'Actions'),
    ]);
	echo $tableHeaders;
$this->end();

$this->append('table-body');
	$currentController = '';
	$icon = '<i class="pull-right"></i>';
	foreach ($acos as $acoIndex => $aco) {
		$id = $aco['Aco']['id'];
		$alias = $aco['Aco']['alias'];
		$class = '';
		if (substr($alias, 0, 1) == '_') {
			$level = 1;
			$class .= 'level-' . $level;
			$oddOptions = ['class' => 'hidden controller-' . $currentController];
			$evenOptions = ['class' => 'hidden controller-' . $currentController];
			$alias = substr_replace($alias, '', 0, 1);
		} else {
			$level = 0;
			$class .= ' controller';
			if ($aco['Aco']['children'] > 0) {
				$class .= ' perm-expand';
			}
			$oddOptions = [];
			$evenOptions = [];
			$currentController = $alias;
		}

		$actions = [];
		$actions[] = $this->Html->link('',
			['action' => 'move', $id, 'up'],
			['icon' => $this->Theme->getIcon('move-up'), 'tooltip' => __d('croogo', 'Move up')]
		);
		$actions[] = $this->Html->link('',
			['action' => 'move', $id, 'down'],
			['icon' => $this->Theme->getIcon('move-down'), 'tooltip' => __d('croogo', 'Move down')]
		);

		$actions[] = $this->Html->link('',
			['action' => 'edit', $id],
			['icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('croogo', 'Edit this item')]
		);
		$actions[] = $this->Form->postLink('',
			['action' => 'delete',	$id],
			[
				'icon' => $this->Theme->getIcon('delete'),
				'tooltip' => __d('croogo', 'Remove this item'),
				'escapeTitle' => false,
				'escape' => true,
            ],
			__d('croogo', 'Are you sure?')
		);

		$row = [
			$id,
			$this->Html->div(trim($class), $alias . $icon, [
				'data-id' => $id,
				'data-alias' => $alias,
				'data-level' => $level,
            ]),
            $this->Html->div('btn-group item-actions', implode(' ', $actions)),
        ];

		echo $this->Html->tableCells([$row], $oddOptions, $evenOptions);
	}
	echo $tableHeaders;
$this->end();

$this->Js->buffer('AclPermissions.documentReady();');

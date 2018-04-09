<?php
/**
 * @var ViewIDE $this
 * @var array $menu
 * @var array $linksTree
 * @var array $linksStatus
 */

$this->extend('/Common/admin_index');
$this->Croogo->adminscript('Menus.admin');

$this->Html
	->addCrumb('', '/admin', ['icon' => $this->Theme->getIcon('home')])
	->addCrumb(__d('croogo', 'Menus'), ['plugin' => 'menus', 'controller' => 'menus', 'action' => 'index'])
	->addCrumb(__d('croogo', $menu['Menu']['title']));

$this->append('actions');
	echo $this->Croogo->adminAction(
		__d('croogo', 'New %s', __d('croogo', Inflector::singularize($this->name))),
		['action' => 'add', $menu['Menu']['id']],
		['button' => 'success']
	);
$this->end();

if (isset($this->request->params['named'])) {
    foreach ($this->request->params['named'] as $nn => $nv) {
        $this->Paginator->options['url'][] = $nn . ':' . $nv;
    }
}

$this->append('form-start', $this->Form->create('Link', [
    'url' => ['action' => 'process', $menu['Menu']['id']],
    'class' => 'form-inline'
]));

$this->start('table-heading');
	$tableHeaders = $this->Html->tableHeaders([
        $this->Form->button('', ['type' => 'button', 'button' => 'default', 'class' => 'btn-sm checkbox-toggle', 'icon' => 'square-o']),
        __d('croogo', 'Id'),
		__d('croogo', 'Title'),
		__d('croogo', 'Status'),
		__d('croogo', 'Actions'),
    ]);
	echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->append('table-body');
	$rows = [];
	foreach ($linksTree as $linkId => $linkTitle){
		$actions = [];
		$actions[] = $this->Croogo->adminRowAction('',
            ['controller' => 'links', 'action' => 'moveup', $linkId],
            ['icon' => $this->Theme->getIcon('move-up'), 'tooltip' => __d('croogo', 'Move up')]
        );
		$actions[] = $this->Croogo->adminRowAction('',
            ['controller' => 'links', 'action' => 'movedown', $linkId],
            ['icon' => $this->Theme->getIcon('move-down'), 'tooltip' => __d('croogo', 'Move down')]
        );
		$actions[] = $this->Croogo->adminRowActions($linkId);
		$actions[] = $this->Croogo->adminRowAction('',
            ['controller' => 'links', 'action' => 'edit', $linkId],
            ['icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('croogo', 'Edit this item')]
        );
        $actions[] = $this->Croogo->adminRowAction('',
            '#Link' . $linkId . 'Id',
            [
                'icon' => $this->Theme->getIcon('copy'),
                'tooltip' => __d('croogo', 'Create a copy'),
                'rowAction' => 'copy'
            ],
            __d('croogo', 'Create a copy of this Link?')
        );

        $actions[] = $this->Croogo->adminRowAction('',
            '#Link' . $linkId . 'Id',
            [
                'icon' => $this->Theme->getIcon('delete'),
                'class' => 'delete',
                'tooltip' => __d('croogo', 'Delete this item'),
                'rowAction' => 'delete',
            ],
            __d('croogo', 'Are you sure?')
        );

		if ($linksStatus[$linkId] == CroogoStatus::PREVIEW) {
            $linkTitle .= $this->Html->tag('span', __d('croogo', 'preview'), [
                'class' => 'label label-warning'
            ]);
		}

		$rows[] = [
			$this->Form->checkbox('Link.' . $linkId . '.id', ['class' => 'row-select iCheck']),
			$linkId,
			$linkTitle,
			$this->element('admin/toggle', ['id' => $linkId, 'status' => (int)$linksStatus[$linkId]]),
            $this->Html->div('btn-group item-actions', implode(' ', $actions)),
        ];
    }

    echo $this->Html->tableCells($rows);
$this->end();

$this->start('bulk-action');
	echo $this->Form->input('Link.action', [
		'label' => false,
        'div' => 'form-group',
        'class' => 'form-control',
        'data-placeholder' => __d('croogo', 'Applying to selected'),
		'options' => [
			'publish' => __d('croogo', 'Publish'),
			'unpublish' => __d('croogo', 'Unpublish'),
			'delete' => __d('croogo', 'Delete'),
			'copy' => [
				'value' => 'copy',
				'name' => __d('croogo', 'Copy'),
				'hidden' => true,
            ],
        ],
		'empty' => true,
    ]);

    echo $this->Form->button(__d('croogo', 'Submit'), [
		'type' => 'submit',
		'value' => 'submit',
    ]);
$this->end();

$this->append('form-end',$this->Form->end());

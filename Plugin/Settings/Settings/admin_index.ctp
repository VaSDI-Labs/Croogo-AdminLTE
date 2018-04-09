<?php /** @var ViewIDE $this */
$this->extend('/Common/admin_index');

$this->Html
	->addCrumb('', '/admin', ['icon' => $this->Theme->getIcon('home')])
	->addCrumb(__d('croogo', 'Settings'));

$this->start('table-heading');
	$tableHeaders = $this->Html->tableHeaders([
		$this->Paginator->sort('id', __d('croogo', 'Id')),
		$this->Paginator->sort('key', __d('croogo', 'Key')),
		$this->Paginator->sort('value', __d('croogo', 'Value')),
		$this->Paginator->sort('editable', __d('croogo', 'Editable')),
		__d('croogo', 'Actions'),
    ]);
	echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->append('table-body');
	$rows = [];
	foreach ($settings as $setting){
        $actions = [];
        $actions[] = $this->Croogo->adminRowAction('',
            ['controller' => 'settings', 'action' => 'moveup', $setting['Setting']['id']],
            ['icon' => $this->Theme->getIcon('move-up'), 'tooltip' => __d('croogo', 'Move up')]
        );
        $actions[] = $this->Croogo->adminRowAction('',
            ['controller' => 'settings', 'action' => 'movedown', $setting['Setting']['id']],
            ['icon' => $this->Theme->getIcon('move-down'), 'tooltip' => __d('croogo', 'Move down')]
        );
        $actions[] = $this->Croogo->adminRowAction('',
            ['controller' => 'settings', 'action' => 'edit', $setting['Setting']['id']],
            ['icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('croogo', 'Edit this item')]
        );
        $actions[] = $this->Croogo->adminRowActions($setting['Setting']['id']);
        $actions[] = $this->Croogo->adminRowAction('',
            ['controller' => 'settings', 'action' => 'delete', $setting['Setting']['id']],
            ['icon' => $this->Theme->getIcon('delete'), 'tooltip' => __d('croogo', 'Remove this item')],
            __d('croogo', 'Are you sure?'));


        $key = $setting['Setting']['key'];
		$keyE = explode('.', $key);
		$keyPrefix = $keyE['0'];
		if (isset($keyE['1'])) {
			$keyTitle = '.' . $keyE['1'];
		} else {
			$keyTitle = '';
		}
		$rows[] = [
			$setting['Setting']['id'],
			$this->Html->link($keyPrefix, ['controller' => 'settings', 'action' => 'index', '?' => ['key' => $keyPrefix]]) . $keyTitle,
			$this->Text->truncate($setting['Setting']['value'], 20),
			$this->Html->status($setting['Setting']['editable']),
            $this->Html->div('btn-group item-actions', implode(' ', $actions)),
        ];
    }

	echo $this->Html->tableCells($rows);
$this->end();

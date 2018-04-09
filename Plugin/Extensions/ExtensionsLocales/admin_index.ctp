<?php
/**
 * @var ViewIDE $this
 * @var array $locales
 * @var array $languages
 */

$this->extend('Common/admin_index');

$this->Html
	->addCrumb('', '/admin', ['icon' => $this->Theme->getIcon('home')])
	->addCrumb(__d('croogo', 'Extensions'), ['plugin' => 'extensions', 'controller' => 'extensions_plugins', 'action' => 'index'])
	->addCrumb(__d('croogo', 'Locales'));

$this->append('actions');
    echo $this->Croogo->adminAction(__d('croogo', 'Upload'),
        ['action' => 'add'],
        ['button' => 'success']
    );
    echo $this->Croogo->adminAction('Reset Locale',
        ['action' => 'reset_locale'],
        ['method' => 'post', 'button' => 'danger']
    );
$this->end();

$this->start('table-heading');
	$tableHeaders = $this->Html->tableHeaders([
		__d('croogo', 'Locale'),
		__d('croogo', 'Default'),
		__d('croogo', 'Status'),
		__d('croogo', 'Actions'),
    ]);
	echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->append('table-body');
	$rows = [];
	foreach ($locales as $i => $locale):
		$actions = [];
		$actions[] = $this->Croogo->adminRowAction('',
			['action' => 'activate', $locale],
			['icon' => $this->Theme->getIcon('power-on'), 'tooltip' => __d('croogo', 'Activate'), 'method' => 'post']
		);
		$actions[] = $this->Croogo->adminRowAction('',
			['action' => 'edit', $locale],
			['icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('croogo', 'Edit this item')]
		);
		$actions[] = $this->Croogo->adminRowAction('',
			['action' => 'delete', $locale],
			['icon' => $this->Theme->getIcon('delete'), 'tooltip' => __d('croogo', 'Remove this item')],
			__d('croogo', 'Are you sure?')
		);

		$rows[] = [
			$locale,
            (isset($languages[$i]['language'])) ? $languages[$i]['language'] : null,
            ($locale == Configure::read('Site.locale') ? $this->Html->status(1) : $this->Html->status(0) ),
            $this->Html->div('btn-group item-actions', implode(' ', $actions)),
        ];
	endforeach;

	echo $this->Html->tableCells($rows);
$this->end();

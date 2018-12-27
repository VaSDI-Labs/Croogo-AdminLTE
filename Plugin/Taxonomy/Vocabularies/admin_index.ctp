
<?php
/**
 * @var ViewAnnotation $this
 * @var array $vocabularies
 */

$this->extend('/Common/admin_index');

$this->Html
	->addCrumb($this->Html->icon('home'), '/admin')
	->addCrumb(__d('croogo', 'Content'), ['plugin' => 'nodes', 'controller' => 'nodes', 'action' => 'index'])
	->addCrumb(__d('croogo', 'Vocabularies'));

$this->start('table-heading');

	$tableHeaders = $this->Html->tableHeaders([
		$this->Paginator->sort('id', __d('croogo', 'Id')),
		$this->Paginator->sort('title', __d('croogo', 'Title')),
		$this->Paginator->sort('alias', __d('croogo', 'Alias')),
		$this->Paginator->sort('plugin', __d('croogo', 'Plugin')),
		__d('croogo', 'Actions'),
    ]);

	echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->append('table-body');

	$rows = [];
	foreach ($vocabularies as $vocabulary) :
		$actions = [];
		$actions[] = $this->Croogo->adminRowAction('',
			['controller' => 'terms', 'action' => 'index', $vocabulary['Vocabulary']['id']],
			['icon' => $this->Theme->getIcon('inspect'), 'tooltip' => __d('croogo', 'View terms')]
		);
		$actions[] = $this->Croogo->adminRowAction('',
			['action' => 'moveup', $vocabulary['Vocabulary']['id']],
			['icon' => $this->Theme->getIcon('move-up'), 'tooltip' => __d('croogo', 'Move up')]
		);
		$actions[] = $this->Croogo->adminRowAction('',
			['action' => 'movedown', $vocabulary['Vocabulary']['id']],
			['icon' => $this->Theme->getIcon('move-down'), 'tooltip' => __d('croogo', 'Move down')]
		);
		$actions[] = $this->Croogo->adminRowActions($vocabulary['Vocabulary']['id']);
		$actions[] = $this->Croogo->adminRowAction('',
			['action' => 'edit', $vocabulary['Vocabulary']['id']],
			['icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('croogo', 'Edit this item')]
		);
		$actions[] = $this->Croogo->adminRowAction('',
			['controller' => 'vocabularies', 'action' => 'delete', $vocabulary['Vocabulary']['id']],
			['icon' => $this->Theme->getIcon('delete'), 'tooltip' => __d('croogo', 'Remove this item')],
			__d('croogo', 'Are you sure?'));
		$rows[] = [
			$vocabulary['Vocabulary']['id'],
			$this->Html->link($vocabulary['Vocabulary']['title'], ['controller' => 'terms', 'action' => 'index', $vocabulary['Vocabulary']['id']]),
			$vocabulary['Vocabulary']['alias'],
			$vocabulary['Vocabulary']['plugin'],
            $this->Html->div('btn-group item-actions', implode(' ', $actions)),
        ];
	endforeach;

	echo $this->Html->tableCells($rows);

$this->end();

<?php
/**
 * @var ViewIDE $this
 * @var string $modelAlias
 * @var string $displayField
 * @var integer $id
 * @var array $fields
 */

$this->extend('/Common/admin_edit');
$this->set('className', 'translate');

$plugin = $controller = 'nodes';
if (isset($this->request->params['models'][$modelAlias])){
    $plugin = $this->request->params['models'][$modelAlias]['plugin'];
    $controller = strtolower(Inflector::pluralize($modelAlias));
}

$this->Html
	->addCrumb($this->Html->icon('home'), '/admin')
    ->addCrumb(Inflector::humanize(Inflector::pluralize($modelAlias)))
	->addCrumb(Inflector::humanize(Inflector::pluralize($modelAlias)), ['plugin' => Inflector::underscore($plugin), 'controller' => Inflector::underscore($controller), 'action' => 'index'])
	->addCrumb($this->request->data[$modelAlias][$displayField], ['plugin' => Inflector::underscore($plugin), 'controller' =>  Inflector::underscore($controller), 'action' => 'edit', $id])
	->addCrumb(__d('croogo', 'Translations'), ['plugin' => 'translate', 'controller' => 'translate', 'action' => 'index', $id, $modelAlias])
	->addCrumb(__d('croogo', 'Translate'));

$this->append('form-start', $this->Form->create($modelAlias, [
	'url' => [
		'plugin' => 'translate',
		'controller' => 'translate',
		'action' => 'edit',
		$id,
		$modelAlias,
		'locale' => $this->request->params['named']['locale'],
    ]
]));

$this->append('tab-heading');
	echo $this->Croogo->adminTab(__d('croogo', 'Translate'), '#translate-main');
	echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');

	echo $this->Html->tabStart('translate-main');
		foreach ($fields as $field):
            echo $this->Form->input($modelAlias . '.' . $field);
        endforeach;
	echo $this->Html->tabEnd();

	echo $this->Croogo->adminTabs();
$this->end();

$this->start('panels');
	echo $this->Html->beginBox(__d('croogo', 'Publishing'));
        echo $this->Html->div('btn-group');
            echo $this->Form->button(__d('croogo', 'Apply'), ['name' => 'apply']);
            echo $this->Form->button(__d('croogo', 'Save'), ['button' => 'success']);
            echo $this->Html->link(__d('croogo', 'Cancel'), ['action' => 'index', $this->request->params['pass'][0], $this->request->params['pass'][1]], ['button' => 'danger']);
        echo $this->Html->useTag('tagend', 'div');
	echo $this->Html->endBox();

    echo $this->Croogo->adminBoxes();
$this->end();

$this->append('form-end', $this->Form->end());

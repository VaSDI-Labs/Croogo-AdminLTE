
<?php /** @var ViewAnnotation $this */

$this->extend('/Common/admin_edit');

$this->Html
    ->addCrumb('', '/admin', ['icon' => $this->Theme->getIcon('home')])
    ->addCrumb(__d('croogo', 'Extensions'), ['plugin' => 'extensions', 'controller' => 'extensions_plugins', 'action' => 'index'])
    ->addCrumb(__d('croogo', 'Plugins'), ['plugin' => 'extensions', 'controller' => 'extensions_plugins', 'action' => 'index'])
    ->addCrumb(__d('croogo', 'Upload'));

$this->append('form-start', $this->Form->create('Theme', [
	'url' => [
		'plugin' => 'extensions',
		'controller' => 'extensions_themes',
		'action' => 'add',
    ],
	'type' => 'file',
]));

$this->append('tab-heading');
	echo $this->Croogo->adminTab(__d('croogo', 'Upload'), '#themes-upload');
	echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');
	echo $this->Html->tabStart('themes-upload');
	    echo $this->Form->input('Theme.file', ['type' => 'file', 'class' => '']);
	echo $this->Html->tabEnd();

	echo $this->Croogo->adminTabs();
$this->end();

$this->append('panels');
    echo $this->Html->beginBox(__d('croogo', 'Publishing'));
        echo $this->Html->div('btn-group');
            echo $this->Form->button(__d('croogo', 'Upload'));
            echo $this->Html->link(__d('croogo', 'Cancel'), ['action' => 'index'], ['button' => 'danger']);
        echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->endBox();

	echo $this->Croogo->adminBoxes();
$this->end();

$this->append('form-end', $this->Form->end());

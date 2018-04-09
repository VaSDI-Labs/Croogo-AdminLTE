<?php
/**
 * @var ViewIDE $this
 * @var string $locale
 * @var string $content
 */

$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb('', '/admin', ['icon' => $this->Theme->getIcon('home')])
	->addCrumb(__d('croogo', 'Extensions'), ['plugin' => 'extensions', 'controller' => 'extensions_plugins', 'action' => 'index'])
	->addCrumb(__d('croogo', 'Extensions') . ": " . __d('croogo', 'Locales'), ['plugin' => 'extensions', 'controller' => 'extensions_locales', 'action' => 'index'])
	->addCrumb($this->request->params['pass'][0]);

$this->append('form-start', $this->Form->create('Locale', [
	'url' => [
		'plugin' => 'extensions',
		'controller' => 'extensions_locales',
		'action' => 'edit',
		$locale
    ]
]));

$this->append('tab-heading');
	echo $this->Croogo->adminTab(__d('croogo', 'Content'), '#locale-content');
	echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');
    echo $this->Html->tabStart('locale-content');
        echo $this->Form->input('Locale.content', [
            'label' => __d('croogo', 'Content'),
            'data-placement' => 'top',
            'value' => $content,
            'type' => 'textarea',
        ]);
    echo $this->Html->tabEnd();

	echo $this->Croogo->adminTabs();
$this->end();

$this->append('panels');
    echo $this->Html->beginBox(__d('croogo', 'Publishing'));
        echo $this->Html->div('btn-group');
            echo $this->Form->button(__d('croogo', 'Save'));
            echo $this->Html->link(__d('croogo', 'Cancel'), ['action' => 'index'], ['button' => 'danger']);
        echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->endBox();

	echo $this->Croogo->adminBoxes();
$this->end();

$this->append('form-end', $this->Form->end());

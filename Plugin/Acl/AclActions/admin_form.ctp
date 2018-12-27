<?php
/**
 * @var ViewAnnotation $this
 * @var array $acos
 */

$this->extend('/Common/admin_edit');
$this->set('className', 'acl_actions');
$this->Html
	->addCrumb('', '/admin', ['icon' => $this->Theme->getIcon('home')])
	->addCrumb(__d('croogo', 'Users'), ['plugin' => 'users', 'controller' => 'users', 'action' => 'index'])
	->addCrumb(__d('croogo', 'Permissions'), ['plugin' => 'acl', 'controller' => 'acl_permissions'])
	->addCrumb(__d('croogo', 'Actions'), ['plugin' => 'acl', 'controller' => 'acl_actions', 'action' => 'index']);

if ($this->request->params['action'] == 'admin_edit') {
	$this->Html->addCrumb($this->request->data['Aco']['id'] . ': ' . $this->request->data['Aco']['alias']);
}

if ($this->request->params['action'] == 'admin_add') {
	$this->Html->addCrumb(__d('croogo', 'Add'));
}

$this->append('form-start', $this->Form->create('Aco', [
	'url' => ['controller' => 'acl_actions', 'action' => 'add']
]));

$this->start('tab-heading');
	echo $this->Croogo->adminTab(__d('croogo', 'Action'), '#action-main');
	echo $this->Croogo->adminTabs();
$this->end();

$this->start('tab-content');

    echo $this->Html->tabStart('action-main');
        echo $this->Form->input('id');
        echo $this->Form->input('parent_id', [
            'options' => $acos,
            'empty' => true,
            'label' => __d('croogo', 'Parent'),
            'help' => __d('croogo', 'Choose none if the Aco is a controller.'),
        ]);
        echo $this->Form->input('alias', [
            'label' => __d('croogo', 'Alias'),
        ]);
    echo $this->Html->tabEnd();

	echo $this->Croogo->adminTabs();
$this->end();

$this->start('panels');
    echo $this->Html->beginBox(__d('croogo', 'Publishing'));
        echo $this->Html->div('btn-group');
            echo $this->Form->button(__d('croogo', 'Apply'), ['name' => 'apply']);
            echo $this->Form->button(__d('croogo', 'Save'), ['button' => 'success']);
            echo $this->Html->link(__d('croogo', 'Cancel'), ['action' => 'index'], ['button' => 'danger']);
        echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->endBox();

	echo $this->Croogo->adminBoxes();
$this->end();

$this->append('form-end', $this->Form->end());

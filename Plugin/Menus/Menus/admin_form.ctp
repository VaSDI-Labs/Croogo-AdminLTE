<?php /** @var ViewIDE $this */

$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb($this->Html->icon('home'), '/admin')
	->addCrumb(__d('croogo', 'Menus'), ['plugin' => 'menus', 'controller' => 'menus', 'action' => 'index']);

if ($this->request->params['action'] == 'admin_edit') {
	$this->Html->addCrumb($this->request->data['Menu']['title']);
}

if ($this->request->params['action'] == 'admin_add') {
	$this->Html->addCrumb(__d('croogo', 'Add'));
}

$this->append('form-start', $this->Form->create('Menu'));
$inputDefaults = $this->Form->inputDefaults();
$inputClass = isset($inputDefaults['class']) ? $inputDefaults['class'] : null;

$this->append('tab-heading');
	echo $this->Croogo->adminTab(__d('croogo', 'Menu'), '#menu-basic');
	echo $this->Croogo->adminTab(__d('croogo', 'Misc.'), '#menu-misc');
	echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');

    echo $this->Html->tabStart('menu-basic');
        echo $this->Form->input('id');
        echo $this->Form->input('title', ['label' => __d('croogo', 'Title')]);
        echo $this->Form->input('alias', ['label' => __d('croogo', 'Alias')]);
        echo $this->Form->input('description', ['label' => __d('croogo', 'Description')]);
    echo $this->Html->tabEnd();

    echo $this->Html->tabStart('menu-misc');
        echo $this->Form->input('params', ['label' => __d('croogo', 'Params')]);
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

        echo $this->Form->input('status', [
            'type' => 'radio',
            'legend' => false,
            'label' => false,
            'default' => CroogoStatus::UNPUBLISHED,
            'options' => $this->Croogo->statuses(),
            'class' => '',
            'before' => '<div class=\'radio\'><label>',
            'separator' => '</label></div><div class=\'radio\'><label>',
            'after' => '</label></div>'
        ]);
        echo $this->Form->input('publish_start', [
            'label' => false,
            'placeholder' => __d('croogo', 'Publish Start'),
            'tooltip' => false,
            'type' => 'text',
            'class' => trim($inputClass . ' input-datetime'),
            'prepend' => true,
            'prependClass' => 'datetimepicker date',
            'addon' => $this->Html->icon('calendar'),
        ]);
        echo $this->Form->input('publish_end', [
            'label' => false,
            'placeholder' => __d('croogo', 'Publish End'),
            'tooltip' => false,
            'type' => 'text',
            'class' => trim($inputClass . ' input-datetime'),
            'prepend' => true,
            'prependClass' => 'datetimepicker date',
            'addon' => $this->Html->icon('calendar'),
        ]);
    echo $this->Html->endBox();

    echo $this->Croogo->adminBoxes();
$this->end();

$this->append('form-end', $this->Form->end());

<?php
/**
 * @var ViewAnnotation $this
 * @var array $menus
 * @var integer $menuId
 * @var array $parentLinks
 */

$this->extend('/Common/admin_edit');
$this->Croogo->adminScript('Menus.admin');

$this->Html
	->addCrumb('', '/admin', ['icon' => $this->Theme->getIcon('home')])
	->addCrumb(__d('croogo', 'Menus'), ['plugin' => 'menus', 'controller' => 'menus', 'action' => 'index'])
    ->addCrumb($menus[$menuId], ['plugin' => 'menus', 'controller' => 'links', 'action' => 'index', '?' => ['menu_id' => $menuId]]);

if ($this->request->params['action'] == 'admin_add') {
	$this->Html->addCrumb(__d('croogo', 'Add'));
	$formUrl = ['controller' => 'links', 'action' => 'add', 'menu' => $menuId];
}

if ($this->request->params['action'] == 'admin_edit') {
	$this->Html->addCrumb($this->request->data['Link']['title']);
	$formUrl = ['controller' => 'links', 'action' => 'edit', '?' => ['menu_id' => $menuId,]];
}

$this->append('form-start', $this->Form->create('Link', ['url' => $formUrl]));
$inputDefaults = $this->Form->inputDefaults();
$inputClass = isset($inputDefaults['class']) ? $inputDefaults['class'] : null;

$this->append('tab-heading');
	echo $this->Croogo->adminTab(__d('croogo', 'Link'), '#link-basic');
	echo $this->Croogo->adminTab(__d('croogo', 'Access'), '#link-access');
	echo $this->Croogo->adminTab(__d('croogo', 'Misc.'), '#link-misc');
	echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');

    echo $this->Html->tabStart('link-basic', ['class' => 'tab-pane active']);
        echo $this->Form->input('id');

        echo $this->Form->input('menu_id', [
            'label' => __d('croogo', 'Menu'),
            'selected' => $menuId,
        ]);
        echo $this->Form->input('parent_id', [
            'label' =>   __d('croogo', 'Parent'),
            'options' => $parentLinks,
            'empty' => true,
        ]);
        echo $this->Form->input('title', ['label' => __d('croogo', 'Title')]);

        echo $this->Form->input('link', [
            'label' => __d('croogo', 'Link'),
            'append' => true,
            'addonBtn' => $this->Html->link('', 'javascript:;', [
                'button' => 'default',
                'icon' => $this->Theme->getIcon('link'),
                'iconSize' => 'small',
                'title' => __d('croogo', 'Link Chooser'),
                'class' => 'linkChooser',
                'data-link-chooser' => $this->Html->url([
                    'admin' => true,
                    'plugin' => 'menus',
                    'controllers' => 'links',
                    'action' => 'link_chooser',
                ]),
            ]),
        ]);
    echo $this->Html->tabEnd();

	echo $this->Html->tabStart('link-access');
	    echo $this->Form->input('Role.Role', ['label' => __d('croogo', 'Role')]);
	echo $this->Html->tabEnd();

    echo $this->Html->tabStart('link-misc');
        echo $this->Form->input('class', [
            'label' => __d('croogo', 'Class'),
            'class' => trim($inputClass . ' class'),
        ]);
        echo $this->Form->input('description', ['label' => __d('croogo', 'Description')]);
        echo $this->Form->input('rel', ['label' => __d('croogo', 'Rel')]);
        echo $this->Form->input('target', ['label' => __d('croogo', 'Target')]);
        echo $this->Form->input('params', ['label' => __d('croogo', 'Params')]);
    echo $this->Html->tabEnd();

	echo $this->Croogo->adminTabs();
$this->end();

$this->start('panels');
	echo $this->Html->beginBox(__d('croogo', 'Publishing'));
        echo $this->Html->div('btn-group');
            echo $this->Form->button(__d('croogo', 'Apply'), ['name' => 'apply']);
            echo $this->Form->button(__d('croogo', 'Save'), ['button' => 'success']);
            echo $this->Html->link(__d('croogo', 'Cancel'), ['action' => 'index', '?' => ['menu_id' => $menuId]], ['button' => 'danger']);
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

$this->append('page-footer');
	echo $this->element('admin/modal', ['id' => 'link_choosers', 'title' => __d('croogo', 'Choose Link'),]);
$this->end();

<?php /** @var ViewIDE $this */

$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb($this->Html->icon('home'), '/admin')
	->addCrumb(__d('croogo', 'Users'), ['plugin' => 'users', 'controller' => 'users', 'action' => 'index'])
	->addCrumb($this->request->data['User']['name'], ['action' => 'edit', $this->request->data['User']['id']])
	->addCrumb(__d('croogo', 'Reset Password'));

$this->set('title_for_layout', __d('croogo', 'Reset Password: %s', $this->request->data['User']['username']));

$this->append('form-start', $this->Form->create('User', [
	'url' => [
		'action' => 'reset_password',
    ]
]));

$this->append('tab-heading');
	echo $this->Croogo->adminTab(__d('croogo', 'Reset Password'), '#reset-password');
	echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');

    echo $this->Html->tabStart('reset-password');
        echo $this->Form->input('id');
        echo $this->Form->input('password', ['label' => __d('croogo', 'New Password'), 'value' => '']);
        echo $this->Form->input('verify_password', ['label' => __d('croogo', 'Verify Password'), 'type' => 'password', 'value' => '']);
    echo $this->Html->tabEnd();

	echo $this->Croogo->adminTabs();
$this->end();

$this->append('panels');
	echo $this->Html->beginBox(__d('croogo', 'Publishing'));
        echo $this->Html->div('btn-group');
            echo $this->Form->button(__d('croogo', 'Reset'));
            echo $this->Html->link(__d('croogo', 'Cancel'), ['action' => 'index'], ['button' => 'primary']);
        echo $this->Html->useTag('tagend', 'div');
	echo $this->Html->endBox();

	echo $this->Croogo->adminBoxes();
$this->end();

$this->append('form-end', $this->Form->end());

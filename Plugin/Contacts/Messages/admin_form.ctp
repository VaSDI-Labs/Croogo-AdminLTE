<?php /** @var ViewIDE $this */

$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb($this->Theme->getIcon('home'), '/admin')
	->addCrumb(__d('croogo', 'Contacts'), ['plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'index'])
	->addCrumb(__d('croogo', 'Messages'), ['plugin' => 'contacts', 'controller' => 'messages', 'action' => 'index']);

if ($this->request->params['action'] == 'admin_edit') {
	$this->Html->addCrumb($this->request->data['Message']['id'] . ': ' . $this->request->data['Message']['title']);
}

$this->append('form-start', $this->Form->create('Message'));

$this->append('tab-heading');
	echo $this->Croogo->adminTab(__d('croogo', 'Message'), '#message-main');
	echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');

    echo $this->Html->tabStart('message-main');
        echo $this->Form->input('id');
        echo $this->Form->input('name', ['label' => __d('croogo', 'Name'),]);
        echo $this->Form->input('email', ['label' => __d('croogo', 'Email'),]);
        echo $this->Form->input('title', ['label' => __d('croogo', 'Title'),]);
        echo $this->Form->input('body', ['label' => __d('croogo', 'Body'),]);
        echo $this->Form->input('phone', ['label' => __d('croogo', 'Phone'),]);
        echo $this->Form->input('address', ['label' => __d('croogo', 'Address'),]);
    echo $this->Html->tabEnd();

	echo $this->Croogo->adminTabs();
$this->end();

$this->start('panels');
	echo $this->Html->beginBox(__d('croogo', 'Publishing'));
        echo $this->Html->div('btn-group');
            echo $this->Form->button(__d('croogo', 'Save'), ['button' => 'success']);
            echo $this->Html->link(__d('croogo', 'Cancel'), ['action' => 'index'], ['button' => 'danger']);
        echo $this->Html->useTag('tagend', 'div');
	echo $this->Html->endBox();

	echo $this->Croogo->adminBoxes();
$this->end();

$this->append('form-end', $this->Form->end());
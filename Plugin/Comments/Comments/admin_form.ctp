<?php /** @var ViewIDE $this */

$this->extend('/Common/admin_edit');

$this->Html
    ->addCrumb($this->Html->icon('home'), '/admin')
	->addCrumb(__d('croogo', 'Content'), ['plugin' => 'nodes', 'controller' => 'nodes', 'action' => 'index'])
	->addCrumb(__d('croogo', 'Comments'), ['plugin' => 'comments', 'controller' => 'comments', 'action' => 'index'])
	->addCrumb($this->request->data['Comment']['id']);

$this->append('form-start', $this->Form->create('Comment'));

$this->append('tab-heading');
	echo $this->Croogo->adminTab(__d('croogo', 'Comment'), '#comment-main');
	echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');

    echo $this->Html->tabStart('comment-main');
        echo $this->Form->input('id');
        echo $this->Form->input('title', ['label' => __d('croogo', 'Title'),]);
        echo $this->Form->input('body', ['label' => __d('croogo', 'Body')]);
    echo $this->Html->tabEnd();

    echo $this->Croogo->adminTabs();

$this->end();

$this->start('panels');
    echo $this->Html->beginBox(__d('croogo', 'Publishing'));
        echo $this->Html->div('btn-group');
            echo $this->Form->button(__d('croogo', 'Save'), ['button' => 'success']);
            echo $this->Html->link(__d('croogo', 'Cancel'), ['action' => 'index'], ['button' => 'danger']);
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Form->input('status', [
            'label' => false,
            'class' => '',
            'before' => '<div class=\'checkbox\'><label>',
            'after' => __d('croogo', 'Published') . '</label></div>'
        ]);
    echo $this->Html->endBox();


    echo $this->Html->beginBox(__d('croogo', 'Contact'));
        echo $this->Form->input('name', ['label' => __d('croogo', 'Name')]);
        echo $this->Form->input('email', ['label' => __d('croogo', 'Email')]);
        echo $this->Form->input('website', ['label' => __d('croogo', 'Website')]);
        echo $this->Form->input('ip', ['disabled' => 'disabled', 'label' => __d('croogo', 'Ip')]);
    echo $this->Html->endBox();

	echo $this->Croogo->adminBoxes();
$this->end();

$this->append('form-end', $this->Form->end());

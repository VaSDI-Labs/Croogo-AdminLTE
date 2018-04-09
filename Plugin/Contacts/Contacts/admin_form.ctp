<?php /** @var ViewIDE $this */

$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb('', '/admin', ['icon' => $this->Theme->getIcon('home')])
	->addCrumb(__d('croogo', 'Contacts'), ['controller' => 'contacts', 'action' => 'index']);

if ($this->request->params['action'] == 'admin_edit') {
	$this->Html->addCrumb($this->request->data['Contact']['title']);
}

if ($this->request->params['action'] == 'admin_add') {
	$this->Html->addCrumb(__d('croogo', 'Add'));
}

$this->append('form-start', $this->Form->create('Contact'));

$this->append('tab-heading');
	echo $this->Croogo->adminTab(__d('croogo', 'Contact'), '#contact-basic');
	echo $this->Croogo->adminTab(__d('croogo', 'Details'), '#contact-details');
	echo $this->Croogo->adminTab(__d('croogo', 'Message'), '#contact-message');
	echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');

    echo $this->Html->tabStart('contact-basic');
        echo $this->Form->input('id');
        echo $this->Form->input('title', ['label' => __d('croogo', 'Title'),]);
        echo $this->Form->input('alias', ['label' => __d('croogo', 'Alias'),]);
        echo $this->Form->input('email', ['label' => __d('croogo', 'Email')]);
        echo $this->Form->input('body', ['label' => __d('croogo', 'Body'),]);
    echo $this->Html->tabEnd();


    echo $this->Html->tabStart('contact-details');
        echo $this->Form->input('name', ['label' => __d('croogo', 'Name'),]);
        echo $this->Form->input('position', ['label' => __d('croogo', 'Position'),]);
        echo $this->Form->input('address', ['label' => __d('croogo', 'Address'),]);
        echo $this->Form->input('address2', ['label' => __d('croogo', 'Address2'),]);
        echo $this->Form->input('state', ['label' => __d('croogo', 'State'),]);
        echo $this->Form->input('country', ['label' => __d('croogo', 'Country'),]);
        echo $this->Form->input('postcode', ['label' => __d('croogo', 'Post Code'),]);
        echo $this->Form->input('phone', ['label' => __d('croogo', 'Phone'),]);
        echo $this->Form->input('fax', ['label' => __d('croogo', 'Fax'),]);
    echo $this->Html->tabEnd();

    echo $this->Html->tabStart('contact-message');
        echo $this->Form->input('message_status', [
            'label' => false,
            'class' => '',
            'before' => '<div class=\'checkbox\'><label>',
            'after' => __d('croogo', 'Let users leave a message') . '</label></div>'
        ]);
        echo $this->Form->input('message_archive', [
            'label' => false,
            'class' => '',
            'before' => '<div class=\'checkbox\'><label>',
            'after' => __d('croogo', 'Save messages in database') . '</label></div>'
        ]);
        echo $this->Form->input('message_notify', [
            'label' => false,
            'class' => '',
            'before' => '<div class=\'checkbox\'><label>',
            'after' => __d('croogo', 'Notify by email instantly') . '</label></div>'
        ]);
        echo $this->Form->input('message_spam_protection', [
            'label' => false,
            'class' => '',
            'before' => '<div class=\'checkbox\'><label>',
            'after' => __d('croogo', 'Spam protection (requires Akismet API key)') . '</label></div>'
        ]);
        echo $this->Form->input('message_captcha', [
            'label' => false,
            'class' => '',
            'before' => '<div class=\'checkbox\'><label>',
            'after' => __d('croogo', 'Use captcha? (requires Recaptcha API key)') . '</label></div>'
        ]);

        echo $this->Html->link(__d('croogo', 'You can manage your API keys here.'), [
            'plugin' => 'settings',
            'controller' => 'settings',
            'action' => 'prefix',
            'Service',
        ]);
    echo $this->Html->tabEnd();

	echo $this->Croogo->adminTabs();
$this->end();

$this->append('panels');
	echo $this->Html->beginBox(__d('croogo', 'Publishing'));
        echo $this->Html->div('btn-group');
            echo $this->Form->button(__d('croogo', 'Apply'), ['name' => 'apply']);
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

	echo $this->Croogo->adminBoxes();
$this->end();

$this->append('form-end', $this->Form->end());

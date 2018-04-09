<?php /** @var ViewIDE $this */

$this->extend('/Common/admin_edit');

$this->Html->addCrumb('', '/admin', ['icon' => $this->Theme->getIcon('home')])
	->addCrumb(__d('croogo', 'Content'), ['plugin' => 'nodes', 'controller' => 'nodes', 'action' => 'index'])
	->addCrumb(__d('croogo', 'Types'), ['plugin' => 'taxonomy', 'controller' => 'types', 'action' => 'index']);

if ($this->request->params['action'] == 'admin_edit') {
	$this->Html->addCrumb($this->request->data['Type']['title']);
}

if ($this->request->params['action'] == 'admin_add') {
	$this->Html->addCrumb(__d('croogo', 'Add'));
}

$this->append('form-start', $this->Form->create('Type'));
$this->Form->inputDefaults([
    'div' => 'form-group',
    'class' => 'form-control',
]);

$this->append('tab-heading');
	echo $this->Croogo->adminTab(__d('croogo', 'Type'), '#type-main');
	echo $this->Croogo->adminTab(__d('croogo', 'Taxonomy'), '#type-taxonomy');
	echo $this->Croogo->adminTab(__d('croogo', 'Comments'), '#type-comments');
	echo $this->Croogo->adminTab(__d('croogo', 'Params'), '#type-params');
	echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');

    echo $this->Html->tabStart('type-main');
        echo $this->Form->input('id');
        echo $this->Form->input('title', ['label' => __d('croogo', 'Title')]);
        echo $this->Form->input('alias', ['label' => __d('croogo', 'Alias')]);
        echo $this->Form->input('description', ['label' => __d('croogo', 'Description')]);
        echo $this->Form->input('format_use_wysiwyg', [
            'label' => false,
            'class' => '',
            'before' => '<div class=\'checkbox\'><label>',
            'after' => __d('croogo', 'Enable Wysiwyg Editor') . '</label></div>'
        ]);
    echo $this->Html->tabEnd();

    echo $this->Html->tabStart('type-taxonomy');
        echo $this->Form->input('Vocabulary.Vocabulary', ['label' => __d('croogo', 'Vocabulary')]);
    echo $this->Html->tabEnd();

    echo $this->Html->tabStart('type-comments');
        echo $this->Form->input('comment_status', [
            'type' => 'radio',
            'options' => [
                '0' => __d('croogo', 'Disabled'),
                '1' => __d('croogo', 'Read only'),
                '2' => __d('croogo', 'Read/Write'),
            ],
            'default' => 2,
            'legend' => false,
            'label' => false,
            'class' => '',
            'before' => '<div class=\'radio\'><label>',
            'after' => '</label></div>',
            'separator' => '</label></div><div class=\'radio\'><label>'
        ]);
        echo $this->Form->input('comment_approve', [
            'label' => false,
            'class' => '',
            'before' => '<div class=\'checkbox\'><label>',
            'after' => __d('croogo', 'Auto approve comments') . '</label></div>'
        ]);
        echo $this->Form->input('comment_spam_protection', [
            'label' => false,
            'class' => '',
            'before' => '<div class=\'checkbox\'><label>',
            'after' => __d('croogo', 'Spam protection (requires Akismet API key)') . '</label></div>'
        ]);
        echo $this->Form->input('comment_captcha', [
            'label' => false,
            'class' => '',
            'before' => '<div class=\'checkbox\'><label>',
            'after' => __d('croogo', 'Use captcha? (requires Recaptcha API key)') . '</label></div>'
        ]);
        echo $this->Html->link(__d('croogo', 'You can manage your API keys here.'), [
            'plugin' => 'settings',
            'controller' => 'settings',
            'action' => 'prefix',
            'Service'
        ]);
    echo $this->Html->tabEnd();

    echo $this->Html->tabStart('type-params');
        echo $this->Form->input('Type.params', ['label' => __d('croogo', 'Params')]);
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

        echo $this->Form->input('format_show_author', [
            'label' => false,
            'class' => '',
            'before' => '<div class=\'checkbox\'><label>',
            'after' => __d('croogo', 'Show author\'s name') . '</label></div>'
        ]);
        echo $this->Form->input('format_show_date', [
            'label' => false,
            'class' => '',
            'before' => '<div class=\'checkbox\'><label>',
            'after' => __d('croogo', 'Show date') . '</label></div>'
        ]);

    echo $this->Html->endBox();

    echo $this->Croogo->adminBoxes();
$this->end();

$this->append('form-end', $this->Form->end());

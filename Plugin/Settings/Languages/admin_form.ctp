
<?php /** @var ViewAnnotation $this */

$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb($this->Html->icon('home'), '/admin')
	->addCrumb(__d('croogo', 'Settings'), ['plugin' => 'settings', 'controller' => 'settings', 'action' => 'prefix', 'Site'])
	->addCrumb(__d('croogo', 'Language'), ['plugin' => 'settings', 'controller' => 'languages', 'action' => 'index']);

if ($this->request->params['action'] == 'admin_edit') {
	$this->Html->addCrumb($this->request->data['Language']['title']);
}

if ($this->request->params['action'] == 'admin_add') {
	$this->Html->addCrumb(__d('croogo', 'Add'));
}
$this->append('form-start', $this->Form->create('Language'));

$this->start('tab-heading');
    echo $this->Croogo->adminTab(__d('croogo', 'Language'), '#language-main');
    echo $this->Croogo->adminTabs();
$this->end();

$this->start('tab-content');
    echo $this->Html->tabStart('language-main');
        echo $this->Form->input('id');
        echo $this->Form->input('title', ['label' => __d('croogo', 'Title')]);
        echo $this->Form->input('native', ['label' => __d('croogo', 'Native')]);
        echo $this->Form->input('alias', ['label' => __d('croogo', 'Alias')]);
    echo $this->Html->tabEnd();

    echo $this->Croogo->adminTabs();
$this->end();

$this->start('panels');
    echo $this->Html->beginBox(__d('croogo', 'Publishing'));
        echo $this->Html->div('btn-group');
            echo $this->Form->button(__d('croogo', 'Save'), ['button' => 'default']);
            echo $this->Html->link(__d('croogo', 'Cancel'), ['action' => 'index'], ['button' => 'danger']);
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Form->input('status', [
            'label' => false,
            'class' => '',
            'before' => '<div class=\'checkbox\'><label>',
            'after' => __d('croogo', 'Status') . '</label></div>'
        ]);

    echo $this->Html->endBox();

    echo $this->Croogo->adminBoxes();
$this->end();

$this->append('form-end', $this->Form->end());

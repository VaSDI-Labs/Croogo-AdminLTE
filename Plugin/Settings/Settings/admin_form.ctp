
<?php /** @var ViewAnnotation $this */
$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb($this->Html->icon('home'), '/admin')
	->addCrumb(__d('croogo', 'Settings'), [ 'action' => 'index']);

if ($this->request->params['action'] == 'admin_edit') {
	$this->Html->addCrumb($this->request->data['Setting']['key']);
}

if ($this->request->params['action'] == 'admin_add') {
	$this->Html->addCrumb(__d('croogo', 'Add'));
}

$this->append('form-start', $this->Form->create('Setting', [
    'class' => 'protected-form',
]));

$this->start('tab-heading');
	echo $this->Croogo->adminTab(__d('croogo', 'Settings'), '#setting-basic');
	echo $this->Croogo->adminTab(__d('croogo', 'Misc'), '#setting-misc');
    echo $this->Croogo->adminTabs();
$this->end();

$this->start('tab-content');
    echo $this->Html->tabStart('setting-basic');
        echo $this->Form->input('id');
        echo $this->Form->input('key', [
            'help' => __d('croogo', "e.g., 'Site.title'"),
            'label' => __d('croogo', 'Key')
        ]);
        echo $this->Form->input('value', [
            'label' => __d('croogo', 'Value')
        ]);
    echo $this->Html->tabEnd();

    echo $this->Html->tabStart('setting-misc');
        echo $this->Form->input('title', ['label' => __d('croogo', 'Title')]);
        echo $this->Form->input('description', ['label' => __d('croogo', 'Description')]);
        echo $this->Form->input('input_type', [
            'label' => __d('croogo', 'Input Type'),
            'help' => __d('croogo', "e.g., 'text' or 'textarea'"),
        ]);
        echo $this->Form->input('editable', [
            'label' => false,
            'class' => '',
            'before' => '<div class=\'checkbox\'><label>',
            'after' => __d('croogo', 'Editable') . '</label></div>'
        ]);
        echo $this->Form->input('params', ['label' => __d('croogo', 'Params')]);
    echo $this->Html->tabEnd();

    echo $this->Croogo->adminTabs();
$this->end();

$this->start('panels');
    echo $this->Html->beginBox(__d('croogo', 'Publishing'));
        echo $this->Html->div('btn-group');
            echo $this->Form->button(__d('croogo', 'Save'), ['button' => 'default']);
            echo $this->Html->link(__d('croogo', 'Cancel'), ['action' => 'index'], ['button' => 'danger']);
        echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->endBox();

    echo $this->Croogo->adminBoxes();
$this->end();

$this->append('form-end', $this->Form->end());

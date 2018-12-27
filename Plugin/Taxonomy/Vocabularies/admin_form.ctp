
<?php /** @var ViewAnnotation $this */

$this->extend('/Common/admin_edit');
$this->Croogo->adminScript('Taxonomy.vocabularies');

$this->Html
	->addCrumb($this->Html->icon('home'), '/admin')
	->addCrumb(__d('croogo', 'Content'), ['plugin' => 'nodes', 'controller' => 'nodes', 'action' => 'index'])
    ->addCrumb(__d('croogo', 'Vocabularies'), ['plugin' => 'taxonomy', 'controller' => 'vocabularies', 'action' => 'index']);

if ($this->request->params['action'] == 'admin_edit') {
	$this->Html->addCrumb($this->request->data['Vocabulary']['title']);
}

if ($this->request->params['action'] == 'admin_add') {
	$this->Html->addCrumb(__d('croogo', 'Add'));
}

$this->append('form-start', $this->Form->create('Vocabulary'));
$inputDefaults = $this->Form->inputDefaults();
$inputClass = isset($inputDefaults['class']) ? $inputDefaults['class'] : null;

$this->append('tab-heading');
	echo $this->Croogo->adminTab(__d('croogo', 'Vocabulary'), '#vocabulary-basic');
	echo $this->Croogo->adminTab(__d('croogo', 'Options'), '#vocabulary-options');
	echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');

    echo $this->Html->tabStart('vocabulary-basic', ['class' => "tab-pane active"]);
        echo $this->Form->input('id');
        echo $this->Form->input('title', ['label' => __d('croogo', 'Title'),]);
        echo $this->Form->input('alias', ['class' => trim($inputClass . ' alias'), 'label' => __d('croogo', 'Alias'),]);
        echo $this->Form->input('description', ['label' => __d('croogo', 'Description'),]);
        echo $this->Form->input('Type.Type', ['label' => __d('croogo', 'Type'),]);
    echo $this->Html->tabEnd();

    echo $this->Html->tabStart('vocabulary-options');
        echo $this->Form->input('required', [
            'label' => false,
            'class' => "",
            'before' => '<div class=\'checkbox\'><label>',
            'after' => __d('croogo', 'Required') . '</label></div>'
        ]);
        echo $this->Form->input('multiple', [
            'label' => false,
            'class' => "",
            'before' => '<div class=\'checkbox\'><label>',
            'after' => __d('croogo', 'Multiple') . '</label></div>'
        ]);
        echo $this->Form->input('tags', [
            'label' => false,
            'class' => "",
            'before' => '<div class=\'checkbox\'><label>',
            'after' => __d('croogo', 'Tags') . '</label></div>'
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

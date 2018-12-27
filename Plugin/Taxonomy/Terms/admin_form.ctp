
<?php
/**
 * @var ViewAnnotation $this
 * @var array $vocabulary
 * @var array $parentTree
 * @var string|integer $vocabularyId
 */

$this->extend('/Common/admin_edit');
$this->Croogo->adminScript('Taxonomy.terms');

$this->Html
	->addCrumb($this->Html->icon('home'), '/admin')
	->addCrumb(__d('croogo', 'Content'), ['plugin' => 'nodes', 'controller' => 'nodes', 'action' => 'index'])
    ->addCrumb(__d('croogo', 'Vocabularies'), ['plugin' => 'taxonomy', 'controller' => 'vocabularies', 'action' => 'index'])
    ->addCrumb($vocabulary['Vocabulary']['title'], ['plugin' => 'taxonomy', 'controller' => 'terms', 'action' => 'index']);

if ($this->request->params['action'] == 'admin_edit') {
	$this->Html->addCrumb($this->request->data['Term']['title']);
}

if ($this->request->params['action'] == 'admin_add') {
	$this->Html->addCrumb(__d('croogo', 'Add'));
}

$this->Form->create('Term', ['url' => '/' . $this->request->url]);
$inputDefaults = $this->Form->inputDefaults();
$inputClass = isset($inputDefaults['class']) ? $inputDefaults['class'] : null;

$this->append('tab-heading');
	echo $this->Croogo->adminTab(__d('croogo', 'Term'), '#term-basic');
	echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');
    echo $this->Html->tabStart('term-basic');
        echo $this->Form->input('Taxonomy.parent_id', ['options' => $parentTree, 'empty' => true, 'label' => __d('croogo', 'Parent'),]);
        echo $this->Form->hidden('Taxonomy.id');
        echo $this->Form->hidden('id');
        echo $this->Form->input('title', ['label' => __d('croogo', 'Title'),]);
        echo $this->Form->input('slug', ['label' => __d('croogo', 'Slug'), 'class' => trim($inputClass . ' slug'),]);
        echo $this->Form->input('description', ['label' => __d('croogo', 'Description'),]);
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

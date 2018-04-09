<?php /** @var ViewIDE $this */

$this->extend('/Common/admin_edit');

$this->Html
    ->addCrumb('', '/admin', ['icon' => $this->Theme->getIcon('home')])
    ->addCrumb(__d('croogo', 'Blocks'), ['plugin' => 'blocks', 'controller' => 'blocks', 'action' => 'index'])
    ->addCrumb(__d('croogo', 'Regions'), ['plugin' => 'blocks', 'controller' => 'regions', 'action' => 'index']);

if ($this->request->params['action'] == 'admin_edit') {
    $this->Html->addCrumb($this->request->data['Region']['title']);
}

if ($this->request->params['action'] == 'admin_add') {
    $this->Html->addCrumb(__d('croogo', 'Add'));
}

$this->append('form-start', $this->Form->create('Region'));

$this->append('tab-heading');
    echo $this->Croogo->adminTab(__d('croogo', 'Region'), '#region-main');
    echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');

    echo $this->Html->tabStart('region-main');
        echo $this->Form->input('id');
        echo $this->Form->input('title', ['label' => __d('croogo', 'Title'),]);
        echo $this->Form->input('alias', ['label' => __d('croogo', 'Alias'),]);
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
    echo $this->Html->endBox();

    echo $this->Croogo->adminBoxes();
$this->end();

$this->append('form-end', $this->Form->end());

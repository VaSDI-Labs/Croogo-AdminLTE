<?php /** @var ViewIDE $this */

$this->extend('/Common/admin_edit');

$this->Html
    ->addCrumb('', '/admin', ['icon' => $this->Theme->getIcon('home')])
    ->addCrumb(__d('croogo', 'Attachments'), ['plugin' => 'file_manager', 'controller' => 'attachments', 'action' => 'index'])
    ->addCrumb(__d('croogo', 'Upload'));

$formUrl = ['controller' => 'attachments', 'action' => 'add'];
if (isset($this->request->params['named']['editor'])) {
    $formUrl['editor'] = 1;
}

$this->append('form-start', $this->Form->create('Attachment', [
    'url' => $formUrl,
    'type' => 'file',
]));

$this->append('tab-heading');
    echo $this->Croogo->adminTab(__d('croogo', 'Upload'), '#attachment-upload');
    echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');
if(isset($this->request->params['named']['editor'])): ?>
    <style>
        .content-wrapper {
            margin-left: 0 !important;
        }
    </style>
<?php
endif;

    echo $this->Html->tabStart('attachment-upload');
        echo $this->Form->input('file', [
            'type' => 'file',
            'label' => __d('croogo', 'Upload'),
            'class' => ''
        ]);
    echo $this->Html->tabEnd();

    echo $this->Croogo->adminTabs();
$this->end();

$this->start('panels');
    $redirect = ['action' => 'index'];
    if ($this->Session->check('Wysiwyg.redirect')) {
        $redirect = $this->Session->read('Wysiwyg.redirect');
    }

    echo $this->Html->beginBox(__d('croogo', 'Publishing'));
        echo $this->Html->div('btn-group');
            echo $this->Form->button(__d('croogo', 'Upload'));
            echo $this->Html->link(__d('croogo', 'Cancel'), $redirect, ['button' => 'danger']);
        echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->endBox();

    echo $this->Croogo->adminBoxes();
$this->end();

$this->append('form-end', $this->Form->end());
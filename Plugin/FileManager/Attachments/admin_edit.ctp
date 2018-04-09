<?php /** @var ViewIDE $this */

$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb('', '/admin', ['icon' => $this->Theme->getIcon('home')])
	->addCrumb(__d('croogo', 'Attachments'), ['plugin' => 'file_manager', 'controller' => 'attachments', 'action' => 'index'])
	->addCrumb($this->request->data['Attachment']['title']);

$this->append('form-start', $this->Form->create('Attachment', [
	'url' => [
		'controller' => 'attachments',
		'action' => 'edit',
    ]
]));

$this->append('tab-heading');
	echo $this->Croogo->adminTab(__d('croogo', 'Attachment'), '#attachment-main');
	echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');

    echo $this->Html->tabStart('attachment-main');
        echo $this->Form->input('id');
        echo $this->Form->input('title', [
            'label' => __d('croogo', 'Title'),
        ]);
        echo $this->Form->input('excerpt', [
            'label' => __d('croogo', 'Caption'),
        ]);
        echo $this->Form->input('file_url', [
            'label' => __d('croogo', 'File URL'),
            'value' => Router::url($this->request->data['Attachment']['path'], true),
            'readonly' => 'readonly',
        ]);
        echo $this->Form->input('file_type', [
            'label' => __d('croogo', 'Mime Type'),
            'value' => $this->request->data['Attachment']['mime_type'],
            'readonly' => 'readonly',
        ]);
    echo $this->Html->tabEnd();

	echo $this->Croogo->adminTabs();
$this->end();

$this->append('panels');
	$redirect = ['action' => 'index'];
	if ($this->Session->check('Wysiwyg.redirect')) {
		$redirect = $this->Session->read('Wysiwyg.redirect');
	}

    echo $this->Html->beginBox(__d('croogo', 'Publishing'));
        echo $this->Html->div('btn-group');
            echo $this->Form->button(__d('croogo', 'Apply'), ['name' => 'apply']);
            echo $this->Form->button(__d('croogo', 'Save'), ['button' => 'success']);
            echo $this->Html->link(__d('croogo', 'Cancel'), $redirect, ['button' => 'danger']);
        echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->endBox();

	$fileType = explode('/', $this->request->data['Attachment']['mime_type']);
	$fileType = $fileType['0'];
	if ($fileType == 'image'):
		$imgUrl = $this->Image->resize('/uploads/' . $this->request->data['Attachment']['slug'], 200, 300, true);
	else:
		$imgUrl = $this->Html->thumbnail('/croogo/img/icons/' . $this->FileManager->mimeTypeToImage($this->request->data['Attachment']['mime_type'])) . ' ' . $this->request->data['Attachment']['mime_type'];
	endif;

	echo $this->Html->beginBox(__d('croogo', 'Preview'));
	    echo $this->Html->link($imgUrl, $this->request->data['Attachment']['path']);
	echo $this->Html->endBox();

$this->end();

$this->append('form-end', $this->Form->end());
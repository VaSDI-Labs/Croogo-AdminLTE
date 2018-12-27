<?php /** @var ViewAnnotation $this */

$this->extend('/Common/admin_index');

$this->Html
	->addCrumb('', '/admin', ['icon' => $this->Theme->getIcon('home')])
	->addCrumb('Example', ['controller' => 'example', 'action' => 'index'])
	->addCrumb('Chooser Example');

$this->append('form-start', $this->Form->create(null));

$this->append('main');
echo $this->Form->input('node_id', [
	'type' => 'text',
	'append' => true,
	'addonBtn' => $this->Html->link('Choose Node',
		[
			'plugin' => 'nodes',
			'controller' => 'nodes',
			'action' => 'index',
			'?' => ['chooser' => true],
        ],
		['button' => 'default', 'class' => 'blockChooser']
	)
]);

echo $this->Form->input('node_url', [
	'type' => 'text',
	'append' => true,
	'addonBtn' => $this->Html->link('Choose Node',
		[
			'plugin' => 'nodes',
			'controller' => 'nodes',
			'action' => 'index',
			'?' => ['chooser' => true],
        ],
		['button' => 'default', 'class' => 'blockChooser',]
	)
]);

echo $this->Form->input('block_id', [
	'type' => 'text',
	'append' => true,
	'addonBtn' => $this->Html->link('Choose Block Id',
		[
			'plugin' => 'blocks',
			'controller' => 'blocks',
			'action' => 'index',
			'?' => ['chooser' => true],
        ],
		['button' => 'default', 'class' => 'blockChooser']
	)
]);

echo $this->Form->input('block_title', [
	'type' => 'text',
	'append' => true,
	'addonBtn' => $this->Html->link('Choose Block Title',
		[
			'plugin' => 'blocks',
			'controller' => 'blocks',
			'action' => 'index',
			'?' => ['chooser' => true],
        ],
		['button' => 'default', 'class' => 'blockChooser']
	)
]);

echo $this->Form->input('user_id', [
	'type' => 'text',
	'append' => true,
	'addonBtn' => $this->Html->link('Choose User Id',
		[
			'plugin' => 'users',
			'controller' => 'users',
			'action' => 'index',
			'?' => ['chooser' => true],
        ],
		['button' => 'default', 'class' => 'blockChooser']
	)
]);
$this->end();

$this->append('form-end', $this->Form->end());

$this->append('page-footer');
    echo $this->element('admin/modal', ['id' => 'modalExample', 'title' => __d('croogo', 'Choose Link'),]);
$this->end();

$script = <<<EOF
$('.blockChooser').itemChooser({
	fields: [
		{ type: "Node", target: '#SettingNodeId', attr: 'data-chooser_id' },
		{ type: "Node", target: '#SettingNodeUrl', attr: 'rel' },
		{ type: "Block", target: '#SettingBlockId', attr: 'data-chooser_id' },
		{ type: "Block", target: '#SettingBlockTitle', attr: 'data-chooser_title' },
		{ type: "User", target: '#SettingUserId', attr: 'data-chooser_id' }
	],
	modalPopup: "#modalExample"
});
EOF;
$this->Js->buffer($script);

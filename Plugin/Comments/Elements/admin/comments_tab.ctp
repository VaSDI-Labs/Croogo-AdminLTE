<?php
/**
 * @var ViewIDE $this
 * @var array $type
 */
echo $this->Form->input('comment_status', [
	'type' => 'radio',
	'options' => [
		'0' => __d('croogo', 'Disabled'),
		'1' => __d('croogo', 'Read only'),
		'2' => __d('croogo', 'Read/Write'),
    ],
	'default' => $type['Type']['comment_status'],
	'legend' => false,
    'class' => '',
    'label' => false,
    'before' => '<div class=\'radio\'><label>',
    'separator' => '</label></div><div class=\'radio\'><label>',
    'after' => '</label></div>'
]);

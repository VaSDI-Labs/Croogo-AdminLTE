<?php /** @var ViewAnnotation $this */

$this->extend('/Common/admin_index');
$this->Html
	->addCrumb('', '/admin', ['icon' => $this->Theme->getIcon('home')])
	->addCrumb('Example', ['controller' => 'example', 'action' => 'index'])
	->addCrumb('RTE Example');

echo $this->Form->create('Example');

$options = ['type' => 'textarea'];
$rteConfigs = Configure::read('Wysiwyg.actions.Example/admin_rte_example');

$para = '<p>This editor was configured with the following setting:</p>';
foreach (['basic', 'standard', 'full', 'custom'] as $preset):
	$query = sprintf('{n}[elements=Example%s]', Inflector::camelize($preset));
	$presetConfig = Hash::extract($rteConfigs, $query);
	$pre = '<blockquote><pre>' . print_r($presetConfig[0], true) . '</pre></blockquote>';
	echo $this->Form->input($preset, Hash::merge([
		'value' => $para . $pre,
    ], $options));
endforeach;

echo $this->Form->end();

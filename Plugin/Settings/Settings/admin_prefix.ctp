<?php
/**
 * @var ViewIDE $this
 * @var string $prefix
 */

$this->extend('/Common/admin_edit');

$this->Html
    ->addCrumb($this->Html->icon('home'), '/admin')
	->addCrumb(__d('croogo', 'Settings'), ['plugin' => 'settings', 'controller' => 'settings', 'action' => 'index'])
	->addCrumb(__d('croogo', $prefix));

$this->append('form-start', $this->Form->create('Setting', [
	'url' => [
		'controller' => 'settings',
		'action' => 'prefix',
		$prefix,
    ],
    'class' => 'protected-form',
]));

$this->append('tab-heading');
    echo $this->Croogo->adminTab($prefix, '#settings-main');
	echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');
	echo $this->Html->tabStart('settings-main');
		foreach ($settings as $id => $setting):
            if (!empty($setting['Params']['tab'])) {
                continue;
            }
            $keyE = explode('.', $setting['Setting']['key']);
            $keyTitle = Inflector::humanize($keyE['1']);

            $label = ($setting['Setting']['title'] != null) ? $setting['Setting']['title'] : $keyTitle;

            $id = $setting['Setting']['id'];
            echo $this->Form->input("Setting.$id.id", [
                'value' => $setting['Setting']['id'],
            ]);
            echo $this->Form->input("Setting.$id.key", [
                'type' => 'hidden', 'value' => $setting['Setting']['key']
            ]);
            echo $this->SettingsForm->input($setting, __d('croogo', $label), $id);
        endforeach;
    echo $this->Html->tabEnd();

    echo $this->Croogo->adminTabs();
$this->end();

$this->append('panels');
    echo $this->Html->beginBox(__d('croogo', 'Saving'));
        echo $this->Html->div('btn-group');
            echo $this->Form->button(__d('croogo', 'Save'), ['button' => 'default']);
            echo $this->Html->link(__d('croogo', 'Cancel'), ['action' => 'index'], ['button' => 'danger']);
        echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->endBox();

	echo $this->Croogo->adminBoxes();
$this->end();

$this->append('form-end', $this->Form->end());

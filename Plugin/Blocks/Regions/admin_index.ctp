<?php /** @var ViewIDE $this */

$this->extend('/Common/admin_index');

$this->Html
	->addCrumb('', '/admin', ['icon' => $this->Theme->getIcon('home')])
	->addCrumb(__d('croogo', 'Blocks'), ['plugin' => 'blocks', 'controller' => 'blocks', 'action' => 'index'])
	->addCrumb(__d('croogo', 'Regions'));


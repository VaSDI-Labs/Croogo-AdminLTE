<?php /** @var ViewIDE $this */

$this->extend('/Common/admin_index');

$this->Html
    ->addCrumb($this->Html->icon('home'), '/admin')
	->addCrumb(__d('croogo', 'Contacts'));


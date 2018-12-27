<?php /** @var ViewAnnotation $this */

$this->extend('/Common/admin_index');

$this->Html
	->addCrumb($this->Html->icon('home'), '/admin')
	->addCrumb(__d('croogo', 'Users'));

if (isset($this->request->query['chooser'])):
	$this->Html->script(['Users.admin_index'], ['inline' => false]);
endif;

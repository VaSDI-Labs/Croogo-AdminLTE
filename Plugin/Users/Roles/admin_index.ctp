
<?php /** @var ViewAnnotation $this */
$this->extend('/Common/admin_index');

$this->Html
	->addCrumb($this->Html->icon('home'), '/admin')
	->addCrumb(__d('croogo', 'Users'), ['plugin' => 'users', 'controller' => 'users', 'action' => 'index'])
	->addCrumb(__d('croogo', 'Roles'));

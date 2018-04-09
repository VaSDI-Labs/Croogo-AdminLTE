<?php /** @var ViewTheme $this */

echo $this->Html->getCrumbList([
	'firstClass' => false,
	'lastClass' => "active",
	'escape' => false,
	'class' => 'breadcrumb'
]);

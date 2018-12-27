<?php /** @var ViewAnnotation $this */

echo $this->Html->getCrumbList([
	'firstClass' => false,
	'lastClass' => "active",
	'escape' => false,
	'class' => 'breadcrumb'
]);

<?php /** @var ViewAnnotation $this */

$adminThemeScripts =<<<EOF
	Admin.form();
	Admin.protectForms();
	$('.sidebar-menu').tree()
EOF;
$this->Js->buffer($adminThemeScripts);

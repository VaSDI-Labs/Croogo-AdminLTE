<?php

$adminThemeScripts =<<<EOF
	Admin.form();
	Admin.protectForms();
	$('.sidebar-menu').tree()
EOF;
$this->Js->buffer($adminThemeScripts);

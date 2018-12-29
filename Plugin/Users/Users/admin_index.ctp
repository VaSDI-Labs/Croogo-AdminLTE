<?php /** @var ViewAnnotation $this */

$this->extend('/Common/admin_index');

$this->Html
	->addCrumb($this->Html->icon('home'), '/admin')
	->addCrumb(__d('croogo', 'Users'));

if (isset($this->request->query['chooser'])):
	$this->start('page-footer');

	echo <<<HTML
<script>
	$(function () {
		Admin.modalLarge();
		Admin.chooserUpdate();
		Admin.chooserUpdate('#UserAdminIndexForm', {
			chooser: $('#UserChooser').val(),
			role_id: $('#UserRoleId').val(),
			name: $('#UserName').val()
		});
	});
</script>
HTML;
	$this->end();
endif;

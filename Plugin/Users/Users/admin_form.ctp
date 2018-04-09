<?php /** @var ViewIDE $this */
$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb($this->Html->icon('home'), '/admin')
	->addCrumb(__d('croogo', 'Users'), ['plugin' => 'users', 'controller' => 'users', 'action' => 'index']);

if ($this->request->params['action'] == 'admin_edit') {
	$this->Html->addCrumb($this->request->data['User']['name']);
	$this->set('title_for_layout', __d('croogo', 'Edit user %s', $this->request->data['User']['username']));
} else {
    $this->Html->addCrumb(__d('croogo', 'Add'));
    $this->set('title_for_layout', __d('croogo', 'New user'));
}

$this->start('actions');
if ($this->request->params['action'] == 'admin_edit'):
	echo $this->Croogo->adminAction(__d('croogo', 'Reset password'), ['action' => 'reset_password', $this->request->params['pass']['0']]);
endif;
$this->end();

$this->append('form-start', $this->Form->create('User', [
	'fieldAccess' => [
		'User.role_id' => 1,
    ],
    'class' => 'protected-form',
]));

$this->append('tab-heading');
	echo $this->Croogo->adminTab(__d('croogo', 'User'), '#user-main');
	echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');
    echo $this->Html->tabStart('user-main');
        echo $this->Form->input('id');
        echo $this->Form->input('role_id', ['label' => __d('croogo', 'Role')]);
        echo $this->Form->input('username', ['label' => __d('croogo', 'Username')]);
        echo $this->Form->input('name', ['label' => __d('croogo', 'Name')]);
        echo $this->Form->input('bio', ['label' => __d('croogo', 'Bio')]);
        echo $this->Form->input('email', ['label' => __d('croogo', 'Email')]);
        echo $this->Form->input('website', ['label' => __d('croogo', 'Website')]);
        echo $this->Form->input('timezone', [
            'type' => 'select',
            'empty' => true,
            'options' => $this->Time->listTimezones(),
            'label' => __d('croogo', 'Timezone'),
        ]);
    echo $this->Html->tabEnd();

	echo $this->Croogo->adminTabs();
$this->end();

$this->append('panels');
	echo $this->Html->beginBox(__d('croogo', 'Publishing'));
        echo $this->Html->div('btn-group');
            echo $this->Form->button(__d('croogo', 'Apply'), ['name' => 'apply']);
            echo $this->Form->button(__d('croogo', 'Save'), ['button' => 'success']);
            echo $this->Html->link(__d('croogo', 'Cancel'), ['action' => 'index'], ['button' => 'danger']);
        echo $this->Html->useTag('tagend', 'div');

        if ($this->request->params['action'] == 'admin_add'):
            echo $this->Form->input('notification', [
                'label' => false,
                'type' => 'checkbox',
                'class' => '',
                'before' => '<div class=\'checkbox\'><label>',
                'after' => __d('croogo', 'Send Activation Email') . '</label></div>'
            ]);
        endif;

        echo $this->Form->input('status', [
            'label' => false,
            'class' => '',
            'before' => '<div class=\'checkbox\'><label>',
            'after' => __d('croogo', 'Status') . '</label></div>'
        ]);

        $showPassword = !empty($this->request->data['User']['status']);
        if ($this->request->params['action'] == 'admin_add'):
            $out = $this->Form->input('password', [
                'label' => __d('croogo', 'Password'),
                'disabled' => !$showPassword,
            ]);
            $out .= $this->Form->input('verify_password', [
                'label' => __d('croogo', 'Verify Password'),
                'disabled' => !$showPassword,
                'type' => 'password'
            ]);

            $this->Form->unlockField('User.password');
            $this->Form->unlockField('User.verify_password');

            echo $this->Html->div(null, $out, [
                'id' => 'passwords',
                'style' => $showPassword ? '' : 'display: none',
            ]);
        endif;
    echo $this->Html->endBox();

	echo $this->Croogo->adminBoxes();
$this->end();

$this->append('form-end', $this->Form->end());

$script = <<<EOF
	$('#UserStatus').on('change', function(e) {
		const passwords = $('#passwords');
		const elements = $('input', passwords);
		elements.prop('disabled', !this.checked);
		if (this.checked) {
			passwords.show('fast');
		} else {
			passwords.hide('fast');
		}
	});
	$('#UserNotification').on('change', function(e) {
		const status = $('#UserStatus');
		status.prop('checked', false);
		status.trigger('change').parents('.form-group').toggle('fast');
	});
EOF;

if ($this->request->params['action'] == 'admin_add'):
	$this->Js->buffer($script);
endif;

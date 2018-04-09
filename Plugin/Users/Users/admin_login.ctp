<?php /** @var ViewIDE $this */

echo $this->Html->script('admin_login', ['inline' => false]);
echo $this->Html->para('login-box-msg', "Sign in to start your session");

echo $this->Form->create('User', ['url' => ['controller' => 'users', 'action' => 'login']]);
$this->Form->inputDefaults([
    'div' => 'form-group has-feedback',
    'class' => 'form-control',
    'label' => false,
]);

echo $this->Form->input('username', [
    'placeholder' => __d('croogo', 'Username'),
    'tooltip' => false,
    'after' => $this->Html->tag('span', "", [
        'class' => 'glyphicon glyphicon-user form-control-feedback'
    ]),
]);
echo $this->Form->input('password', [
    'placeholder' => __d('croogo', 'Password'),
    'tooltip' => false,
    'after' => $this->Html->tag('span', "", [
        'class' => 'glyphicon glyphicon-lock form-control-feedback'
    ]),
]); ?>
    <div class="row">
        <div class="col-xs-8">
		<?php if(Configure::read('Access Control.autoLoginDuration')){
			echo $this->Form->input('remember', [
				'type' => 'checkbox',
				'default' => false,
				'div' => 'checkbox icheck',
				'before' => '<label>',
				'class' => false,
				'after' => " " . __d('croogo', 'Remember me?') . "</label>"
            ]);
		} ?>
        </div>
        <div class="col-xs-4">
            <?php echo $this->Form->button(__d('croogo', 'Log In'), [
                'button' => 'primary',
                'class' => 'btn-block btn-flat'
            ]); ?>
        </div>
    </div>
<?php echo $this->Form->end();

echo $this->Html->link(__d('croogo', 'Forgot password?'), [
    'admin' => false,
    'controller' => 'users',
    'action' => 'forgot',
]);

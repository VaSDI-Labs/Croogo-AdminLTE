<?php
/**
 * @var ViewIDE $this
 * @var array $roles
 */
if (isset($roles[$this->request->data['User']['role_id']])) {
	$validRoles = array_diff_key($roles, [$this->request->data['User']['role_id'] => null]);
} else {
	$validRoles = $roles;
}

echo $this->Form->input('Role', ['values' => $validRoles, 'class' => 'input checkbox', 'multiple' => 'checkbox']);

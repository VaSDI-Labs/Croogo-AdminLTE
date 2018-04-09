<?php /** @var ViewIDE $this */

$rolePermissions = empty($rolePermissions) ? [] : $rolePermissions;
if(!empty($rolePermissions)){
    $out = $this->Form->label('RolePermission', __d('croogo', 'Edit Permissions'));
    foreach ($rolePermissions as $role) {
        if ($role['Role']['id'] == 1) {
            continue;
        }
        $field = 'RolePermission.' . $role['Role']['id'];
        $labelWrapper = $this->Html->tag('label', $this->Form->checkbox($field, [
                'checked' => $role['Role']['allowed'] ? 'checked' : null,
            ]) . $role['Role']['title']);

        $out .= $this->Html->div('checkbox', $labelWrapper);
    }

    echo $this->Html->div('form-group', $out);
}



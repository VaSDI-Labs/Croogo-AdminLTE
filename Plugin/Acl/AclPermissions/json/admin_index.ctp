<?php
/**
 * @var ViewAnnotation $this
 * @var array $permissions
 */
if (isset($this->request->query['urls'])) {
	foreach ($permissions as $acoId => &$aco) {
		$aco[key($aco)]['url'] = [
			'up' => $this->Html->link('',
				['controller' => 'acl_actions', 'action' => 'moveup', $acoId, 'up'],
				['icon' => $this->Theme->getIcon('move-up'), 'tooltip' => __d('croogo', 'Move up')]
			),
			'down' => $this->Html->link('',
				['controller' => 'acl_actions', 'action' => 'movedown', $acoId, 'down'],
				['icon' => $this->Theme->getIcon('move-down'), 'tooltip' => __d('croogo', 'Move down')]
			),
			'edit' => $this->Html->link('',
				['controller' => 'acl_actions', 'action' => 'edit', $acoId],
				['icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('croogo', 'Edit this item')]
			),
			'del' => $this->Form->postLink('',
				['controller' => 'acl_actions', 'action' => 'delete', $acoId],
				['icon' => $this->Theme->getIcon('delete'), 'tooltip' => __d('croogo', 'Remove this item'), 'escapeTitle' => false, 'escape' => true, 'class' => 'red'],
				__d('croogo', 'Are you sure?')
			),
        ];
	}
}
echo json_encode(compact('aros', 'permissions', 'level'));

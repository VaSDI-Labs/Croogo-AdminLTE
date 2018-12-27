<?php
/**
 * @var ViewAnnotation $this
 * @var integer $id
 * @var integer $status
 */

echo $this->Html->status($status, [
    'admin' => isset($admin) ? $admin : true,
    'plugin' => isset($plugin) ? $plugin : $this->request->params['plugin'],
    'controller' => isset($controller) ? $controller : $this->request->params['controller'],
    'action' => isset($action) ? $action : 'toggle',
    $id,
    $status,
]);

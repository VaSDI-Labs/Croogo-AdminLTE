<?php /** @var ViewIDE $this */

echo $this->Form->create('Message', [
    'novalidate' => true,
    'url' => [
        'plugin' => $this->request->params['plugin'],
        'controller' => $this->request->params['controller'],
        'action' => $this->request->params['action'],
    ],
    'inputDefaults' => [
        'label' => false,
    ],
]);

echo $this->Form->input('contact_id', [
    'empty' => '',
    'required' => false,
    'label' => false,
    'class' => 'form-control',
    'data-placeholder' => __d('croogo', 'Contact'),
]);

echo $this->Form->input('status', [
    'label' => __d('croogo', 'Status'),
    'type' => 'hidden',
    'empty' => '',
    'required' => false
]);

echo $this->Form->button(__d('croogo', 'Filter'), [
    'type' => 'submit',
    'button' => 'primary',
    'class' => 'btn-block'
]);
echo $this->Form->end();
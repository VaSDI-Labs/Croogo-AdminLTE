<?php
/**
 * @var ViewIDE $this
 * @var string $typeAlias
 * @var array $type
 */

$this->extend('/Common/admin_edit');
$this->Croogo->adminScript('Nodes.admin');

$this->Html
    ->addCrumb($this->Html->icon('home'), '/admin')
    ->addCrumb(__d('croogo', 'Content'), ['controller' => 'nodes', 'action' => 'index']);

if ($this->request->params['action'] == 'admin_add') {
    $formUrl = ['action' => 'add', $typeAlias];
    $this->Html->addCrumb(__d('croogo', 'Create'), ['controller' => 'nodes', 'action' => 'create']);
}

$this->Html->addCrumb($type['Type']['title'], [
    'plugin' => 'nodes',
    'controller' => 'nodes',
    'action' => 'hierarchy',
    '?' => [
        'type' => $type['Type']['alias'],
    ],
]);

if ($this->request->params['action'] == 'admin_edit') {
    $formUrl = ['action' => 'edit'];
    $this->Html->addCrumb($this->request->data['Node']['title']);
}

$this->append('form-start', $this->Form->create('Node', [
    'url' => $formUrl,
    'class' => 'protected-form',
]));
$inputDefaults = $this->Form->inputDefaults();
$inputClass = isset($inputDefaults['class']) ? $inputDefaults['class'] : null;

$this->append('tab-heading');
    echo $this->Croogo->adminTab(__d('croogo', $type['Type']['title']), '#node-main');
    echo $this->Croogo->adminTab(__d('croogo', 'Access'), '#node-access');
    echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');

    echo $this->Html->tabStart('node-main');
        echo $this->Form->autocomplete('parent_id', [
            'label' => __d('croogo', 'Parent'),
            'type' => 'text',
            'autocomplete' => [
                'default' => isset($parentTitle) ? $parentTitle : null,
                'data-displayField' => 'title',
                'data-primaryKey' => 'id',
                'data-queryField' => 'title',
                'data-relatedElement' => '#NodeParentId',
                'data-url' => $this->Form->apiUrl([
                    'controller' => 'nodes',
                    'action' => 'lookup',
                    '?' => [
                        'type' => $type['Type']['alias'],
                    ],
                ]),
            ],
        ]);
        echo $this->Form->input('id');
        echo $this->Form->input('title', [
            'label' => __d('croogo', 'Title'),
        ]);
        echo $this->Form->input('slug', [
            'class' => trim($inputClass . ' slug'),
            'label' => __d('croogo', 'Slug'),
        ]);
        echo $this->Form->input('excerpt', [
            'label' => __d('croogo', 'Excerpt'),
        ]);
        echo $this->Form->input('body', [
            'label' => __d('croogo', 'Body'),
            'class' => $inputClass . (!$type['Type']['format_use_wysiwyg'] ? ' no-wysiwyg' : ''),
        ]);
    echo $this->Html->tabEnd();

    echo $this->Html->tabStart('node-access');
        echo $this->Form->input('Role.Role', ['label' => __d('croogo', 'Role')]);
    echo $this->Html->tabEnd();

    echo $this->Croogo->adminTabs();
$this->end();

$this->start('panels');
    echo $this->Html->beginBox(__d('croogo', 'Publishing'));
        echo $this->Html->div('btn-group');
            echo $this->Form->button(__d('croogo', 'Apply'), ['name' => 'apply']);
            echo $this->Form->button(__d('croogo', 'Save'), ['button' => 'success']);
            echo $this->Html->link(__d('croogo', 'Cancel'), ['action' => 'index'], ['button' => 'danger']);
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Form->input('status', [
            'legend' => false,
            'label' => false,
            'type' => 'radio',
            'class' => '',
            'default' => CroogoStatus::UNPUBLISHED,
            'options' => $this->Croogo->statuses(),
            'before' => '<div class=\'radio\'><label>',
            'separator' => '</label></div><div class=\'radio\'><label>',
            'after' => '</label></div>'
        ]);


        echo $this->Form->input('promote', [
            'label' => false,
            'class' => '',
            'before' => '<div class=\'checkbox\'><label>',
            'after' => __d('croogo', 'Promoted to front page') . '</label></div>'
        ]);

        $username = isset($this->request->data['User']['username'])
            ? $this->request->data['User']['username']
            : $this->Session->read('Auth.User.username');

        echo $this->Form->autocomplete('user_id', [
            'type' => 'text',
            'label' => __d('croogo', 'Publish as '),
            'autocomplete' => [
                'default' => $username,
                'data-displayField' => 'username',
                'data-primaryKey' => 'id',
                'data-queryField' => 'name',
                'data-relatedElement' => '#NodeUserId',
                'data-url' => $this->Html->apiUrl([
                    'plugin' => 'users',
                    'controller' => 'users',
                    'action' => 'lookup',
                ]),
            ],
        ]);
        echo $this->Form->input('created', [
            'type' => 'text',
            'placeholder' => __d('croogo', 'Created'),
            'tooltip' => false,
            'class' => trim($inputClass . ' input-datetime'),
            'prepend' => true,
            'prependClass' => 'datetimepicker date',
            'label' => false,
            'addon' => $this->Html->icon('calendar'),
        ]);
        echo $this->Form->input('publish_start', [
            'label' => false,
            'placeholder' => __d('croogo', 'Publish Start'),
            'tooltip' => false,
            'type' => 'text',
            'class' => trim($inputClass . ' input-datetime'),
            'prepend' => true,
            'prependClass' => 'datetimepicker date',
            'addon' => $this->Html->icon('calendar'),
        ]);
        echo $this->Form->input('publish_end', [
            'label' => false,
            'placeholder' => __d('croogo', 'Publish End'),
            'tooltip' => false,
            'type' => 'text',
            'class' => trim($inputClass . ' input-datetime'),
            'prepend' => true,
            'prependClass' => 'datetimepicker date',
            'addon' => $this->Html->icon('calendar'),
        ]);

    echo $this->Html->endBox();

    echo $this->Croogo->adminBoxes();
$this->end();

$this->append('form-end', $this->Form->end());
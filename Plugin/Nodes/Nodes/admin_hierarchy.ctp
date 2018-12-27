
<?php
/**
 * @var ViewAnnotation $this
 * @var array $nodes
 */

$this->extend('/Common/admin_index');
$this->Croogo->adminScript('Nodes.admin');

$this->Html
    ->addCrumb('', '/admin', ['icon' => $this->Theme->getIcon('home')])
    ->addCrumb(__d('croogo', 'Content'), ['admin' => true, 'plugin' => 'nodes', 'controller' => 'nodes', 'action' => 'index',]);

if (isset($type) && $this->request->query):
    $typeUrl = '/' . $this->request->url;
    $typeUrl .= '?' . http_build_query($this->request->query);
    $this->Html->addCrumb($type['Type']['title'], $typeUrl);
endif;

$this->set('showActions', false);

$this->append('search', $this->element('admin/nodes_search'));

$this->append('form-start', $this->Form->create('Node', [
    'url' => ['controller' => 'nodes', 'action' => 'process'],
    'class' => 'form-inline'
]));

$this->start('table-heading');
$tableHeaders = $this->Html->tableHeaders([
    $this->Form->button('', ['type' => 'button', 'button' => 'default', 'class' => 'btn-sm checkbox-toggle', 'icon' => 'square-o']),
    __d('croogo', 'Id'),
    __d('croogo', 'Title'),
    __d('croogo', 'Type'),
    __d('croogo', 'User'),
    __d('croogo', 'Status'),
    __d('croogo', 'Actions')
]);
echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->append('table-body');
$rows = [];
foreach ($nodes as $node) {
    $actions = [];
    $actions[] = $this->Croogo->adminRowActions($node['Node']['id']);
    $actions[] = $this->Croogo->adminRowAction('',
        ['controller' => 'nodes', 'action' => 'moveup', $node['Node']['id']],
        ['icon' => $this->Theme->getIcon('move-up'), 'tooltip' => __d('croogo', 'Move up'),]
    );
    $actions[] = $this->Croogo->adminRowAction('',
        ['controller' => 'nodes', 'action' => 'movedown', $node['Node']['id']],
        ['icon' => $this->Theme->getIcon('move-down'), 'tooltip' => __d('croogo', 'Move down'),]
    );
    $actions[] = $this->Croogo->adminRowAction('',
        ['action' => 'edit', $node['Node']['id']],
        ['icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('croogo', 'Edit this item')]
    );
    $actions[] = $this->Croogo->adminRowAction('',
        '#Node' . $node['Node']['id'] . 'Id',
        [
            'icon' => $this->Theme->getIcon('delete'),
            'class' => 'delete',
            'tooltip' => __d('croogo', 'Remove this item'),
            'rowAction' => 'delete',
        ],
        __d('croogo', 'Are you sure?')
    );

    $htmlTitle = $this->Html->tag('span',
        $this->Html->link(
            $node['Node']['title'], [
            'admin' => false,
            'controller' => 'nodes',
            'action' => 'view',
            'type' => $node['Node']['type'],
            'slug' => $node['Node']['slug']
        ])
    );
    if ($node['Node']['promote'] == 1) {
        $htmlTitle .= $this->Html->tag('span', __d('croogo', 'promoted'), [
            'class' => 'label label-info'
        ]);
    }
    if ($node['Node']['status'] == CroogoStatus::PREVIEW) {
        $htmlTitle .= $this->Html->tag('span', __d('croogo', 'preview'), [
            'class' => 'label label-warning'
        ]);
    }

    $rows[] = [
        $this->Form->checkbox("Node.{$node['Node']['id']}.id", ['class' => 'row-select iCheck']),
        $node['Node']['id'],
        [$htmlTitle, ['class' => "level-{$node['Node']['depth']}"]],
        $node['Node']['type'],
        $node['User']['username'],
        $this->element('admin/toggle', [
            'id' => $node['Node']['id'],
            'status' => (int)$node['Node']['status'],
        ]),
        $this->Html->div('btn-group item-actions', implode(" ", $actions)),
    ];
}
echo $this->Html->tableCells($rows);
$this->end();

$this->start('bulk-action');
echo $this->Form->input('Node.action', [
    'label' => false,
    'div' => 'form-group',
    'class' => 'form-control',
    'data-placeholder' => __d('croogo', 'Applying to selected'),
    'options' => [
        'publish' => __d('croogo', 'Publish'),
        'unpublish' => __d('croogo', 'Unpublish'),
        'promote' => __d('croogo', 'Promote'),
        'unpromote' => __d('croogo', 'Unpromote'),
        'delete' => __d('croogo', 'Delete'),
        'copy' => [
            'value' => 'copy',
            'name' => __d('croogo', 'Copy'),
            'hidden' => true,
        ],
    ],
    'empty' => true,
]);

$jsVarName = uniqid('confirmMessage_');
echo  $this->Form->button(__d('croogo', 'Submit'), [
    'type' => 'button',
    'class' => 'bulk-process',
    'id' => 'bulkForm',
    'data-relatedElement' => '#' . $this->Form->domId('Node.action'),
    'data-confirmMessage' => $jsVarName,
]);
$this->Js->set($jsVarName, __d('croogo', '%s selected items?'));
$this->Js->buffer("$('.bulk-process').on('click', Nodes.confirmProcess);");

$this->end();

$this->append('paging', '');

$this->append('form-end', $this->Form->end());


<?php
/**
 * @var ViewAnnotation $this
 * @var array $criteria
 * @var array $comments
 */

$script = <<<EOF

Admin.toggleRowSelection('.checkbox-toggle');

$(".comment-view").on("click", function () {
    const el = \$(this);
    $('#comment-modal')
        .find('.modal-header .modal-title').html(el.data("title")).end()
        .find('.modal-body').html('<pre>' + el.data('content') + '</pre>').end()
        .modal('toggle');
    return false;
});
EOF;
$this->Js->buffer($script);

$this->extend('/Common/admin_index');

$this->Html
    ->addCrumb($this->Html->icon('home'), '/admin')
    ->addCrumb(__d('croogo', 'Content'), ['plugin' => 'nodes', 'controller' => 'nodes', 'action' => 'index'])
    ->addCrumb(__d('croogo', 'Comments'), ['plugin' => 'comments', 'controller' => 'comments', 'action' => 'index']);

if (isset($criteria['Comment.status'])) {
    if ($criteria['Comment.status'] == '1') {
        $this->Html->addCrumb(__d('croogo', 'Published'));
        $this->viewVars['title_for_layout'] = __d('croogo', 'Comments: Published');
    } else {
        $this->Html->addCrumb(__d('croogo', 'Approval'));
        $this->viewVars['title_for_layout'] = __d('croogo', 'Comments: Approval');
    }
}

$this->append('page-footer', $this->element('admin/modal', [
    'id' => 'comment-modal',
    'title' => __d('croogo', 'Comments')
]));

$this->append('actions');
    echo $this->Croogo->adminAction(
        __d('croogo', 'Published'),
        ['action' => 'index', '?' => ['status' => '1']]
    );
    echo $this->Croogo->adminAction(
        __d('croogo', 'Approval'),
        ['action' => 'index', '?' => ['status' => '0']]
    );
$this->end();

$this->append('form-start', $this->Form->create('Comment', [
        'url' => ['controller' => 'comments', 'action' => 'process'],
        'class' => 'form-inline'
    ]
));
$this->start('table-heading');
    $tableHeaders = $this->Html->tableHeaders([
        $this->Form->button('', ['type' => 'button', 'button' => 'default', 'class' => 'btn-sm checkbox-toggle', 'icon' => 'square-o']),
        $this->Paginator->sort('id', __d('croogo', 'Id')),
        $this->Paginator->sort('name', __d('croogo', 'Name')),
        $this->Paginator->sort('email', __d('croogo', 'Email')),
        $this->Paginator->sort('node_id', __d('croogo', 'Node')),
        '',
        $this->Paginator->sort('created', __d('croogo', 'Created')),
        __d('croogo', 'Actions'),
    ]);
    echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->append('table-body');
    $rows = [];
    foreach ($comments as $comment) {
        $actions = [];
        $actions[] = $this->Croogo->adminRowActions($comment['Comment']['id']);
        $actions[] = $this->Croogo->adminRowAction('',
            ['action' => 'edit', $comment['Comment']['id']],
            ['icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('croogo', 'Edit this item')]
        );
        $actions[] = $this->Croogo->adminRowAction('',
            '#Comment' . $comment['Comment']['id'] . 'Id',
            [
                'icon' => $this->Theme->getIcon('delete'),
                'class' => 'delete',
                'tooltip' => __d('croogo', 'Remove this item'),
                'rowAction' => 'delete',
            ],
            __d('croogo', 'Are you sure?')
        );

        $title = empty($comment['Comment']['title']) ? 'Comment' : $comment['Comment']['title'];
        $rows[] = [
            $this->Form->checkbox('Comment.' . $comment['Comment']['id'] . '.id', ['class' => 'row-select iCheck']),
            $comment['Comment']['id'],
            $comment['Comment']['name'],
            $comment['Comment']['email'],
            $this->Html->link($comment['Node']['title'], [
                'admin' => false,
                'plugin' => 'nodes',
                'controller' => 'nodes',
                'action' => 'view',
                'type' => $comment['Node']['type'],
                'slug' => $comment['Node']['slug'],
            ]),
            $this->Html->link($this->Html->image('/croogo/img/icons/comment.png'), '#', [
                'class' => 'comment-view',
                'data-title' => $title,
                'data-content' => $comment['Comment']['body'],
                'escape' => false
            ]),
            $comment['Comment']['created'],
            $this->Html->div('btn-group item-actions', implode(' ', $actions)),
        ];
    }

    echo $this->Html->tableCells($rows);
$this->end();

$this->start('bulk-action');
    echo $this->Form->input('Comment.action', [
        'label' => false,
        'div' => 'form-group',
        'class' => 'form-control',
        'options' => [
            'publish' => __d('croogo', 'Publish'),
            'unpublish' => __d('croogo', 'Unpublish'),
            'delete' => __d('croogo', 'Delete'),
        ],
        'empty' => true,
    ]);
    echo $this->Form->button(__d('croogo', 'Submit'), ['type' => 'submit', 'value' => 'submit', 'id' => 'bulkForm']);
$this->end();

$this->append('form-end', $this->Form->end());

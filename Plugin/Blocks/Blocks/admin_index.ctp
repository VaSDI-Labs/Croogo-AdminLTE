
<?php
/**
 * @var ViewAnnotation $this
 * @var array $blocks
 */

$this->extend('/Common/admin_index');

$script = <<<EOF
Admin.toggleRowSelection('.checkbox-toggle');
EOF;
$this->Js->buffer($script);


$this->Html
    ->addCrumb('', '/admin', ['icon' => $this->Theme->getIcon('home')])
    ->addCrumb(__d('croogo', 'Blocks'));

$this->append('form-start', $this->Form->create('Block', [
    'url' => ['controller' => 'blocks', 'action' => 'process'],
    'class' => 'form-inline'
]));

$chooser = isset($this->request->query['chooser']);

$this->start('table-heading');
    $tableHeadersOptions = [
        $this->Form->button('', ['type' => 'button', 'button' => 'default', 'class' => 'btn-sm checkbox-toggle', 'icon' => 'square-o']),
        $this->Paginator->sort('id', __d('croogo', 'Id')),
        $this->Paginator->sort('title', __d('croogo', 'Title')),
        $this->Paginator->sort('alias', __d('croogo', 'Alias')),
        $this->Paginator->sort('region_id', __d('croogo', 'Region')),
        $this->Paginator->sort('status', __d('croogo', 'Status')),
        __d('croogo', 'Actions'),
    ];

    if ($chooser) {
        unset($tableHeadersOptions[0]);
    }

    $tableHeaders = $this->Html->tableHeaders($tableHeadersOptions);
    echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->append('table-body');
    $rows = [];
    foreach ($blocks as $block) {
        $actions = [];
        $actions[] = $this->Croogo->adminRowAction('',
            ['controller' => 'blocks', 'action' => 'moveup', $block['Block']['id']],
            ['icon' => $this->Theme->getIcon('move-up'), 'tooltip' => __d('croogo', 'Move up'),]
        );
        $actions[] = $this->Croogo->adminRowAction('',
            ['controller' => 'blocks', 'action' => 'movedown', $block['Block']['id']],
            ['icon' => $this->Theme->getIcon('move-down'), 'tooltip' => __d('croogo', 'Move down'),]
        );
        $actions[] = $this->Croogo->adminRowActions($block['Block']['id']);
        $actions[] = $this->Croogo->adminRowAction('',
            ['controller' => 'blocks', 'action' => 'edit', $block['Block']['id']],
            ['icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('croogo', 'Edit this item')]
        );
        $actions[] = $this->Croogo->adminRowAction('',
            '#Block' . $block['Block']['id'] . 'Id',
            [
                'icon' => $this->Theme->getIcon('copy'),
                'tooltip' => __d('croogo', 'Create a copy'),
                'rowAction' => 'copy',
            ],
            __d('croogo', 'Create a copy of this Block?')
        );
        $actions[] = $this->Croogo->adminRowAction('',
            '#Block' . $block['Block']['id'] . 'Id',
            [
                'icon' => $this->Theme->getIcon('delete'),
                'class' => 'delete',
                'tooltip' => __d('croogo', 'Remove this item'),
                'rowAction' => 'delete'
            ],
            __d('croogo', 'Are you sure?')
        );


        if ($chooser) {
            $actions = [
                $this->Croogo->adminRowAction(__d('croogo', 'Choose'), '#', [
                    'class' => 'item-choose',
                    'data-chooser_type' => 'Block',
                    'data-chooser_id' => $block['Block']['id'],
                    'data-chooser_title' => $block['Block']['title'],
                ]),
            ];
        }

        $title = $this->Html->link($block['Block']['title'], [
            'controller' => 'blocks',
            'action' => 'edit',
            $block['Block']['id'],
        ]);

        if ($block['Block']['status'] == CroogoStatus::PREVIEW) {
            $title .= ' ' . $this->Html->tag('span', __d('croogo', 'preview'),
                    ['class' => 'label label-warning']
                );
        }

        $row = [
            $this->Form->checkbox('Block.' . $block['Block']['id'] . '.id', ['class' => 'row-select iCheck']),
            $block['Block']['id'],
            $title,
            $block['Block']['alias'],
            $block['Region']['title'],
            $this->element('admin/toggle', ['id' => $block['Block']['id'], 'status' => (int)$block['Block']['status'],]),
            $this->Html->div('btn-group item-actions', implode(' ', $actions)),
        ];

        if ($chooser) {
            unset($row[0]);
        }

        $rows[] = $row;
    }

    echo $this->Html->tableCells($rows);
$this->end();

if (!$chooser):
    $this->start('bulk-action');
    echo $this->Form->input('Block.action', [
        'label' => false,
        'div' => 'form-group',
        'class' => 'form-control',
        'data-placeholder' => __d('croogo', 'Applying to selected'),
        'options' => [
            'publish' => __d('croogo', 'Publish'),
            'unpublish' => __d('croogo', 'Unpublish'),
            'delete' => __d('croogo', 'Delete'),
            'copy' => __d('croogo', 'Copy'),
        ],
        'empty' => true,
    ]);
    echo $this->Form->button(__d('croogo', 'Submit'), ['type' => 'submit', 'value' => 'submit', 'id' => 'bulkForm']);
endif;
$this->end();
$this->append('form-end', $this->Form->end());

if ($chooser):
    $this->append('page-footer'); ?>
    <script>
        function ajaxRequest(url, data) {
            let ajaxOption = {
                url: url,
                dataType: "html",
                success: function (data) {
                    $('.modal').find('.modal-body').html($(data).find('.content-wrapper > .content').html());
                }
            };

            if (data !== undefined) ajaxOption.data = data;

            $.ajax(ajaxOption);
        }

        $(function () {
            const modalPopup = $('.modal');
            modalPopup.find('.modal-dialog').addClass('modal-lg');

            $('body').on('click', function () {
                if (!modalPopup.hasClass('in')) {
                    modalPopup.find('.modal-dialog').removeClass('modal-lg');
                }
            });

            $('#BlockAdminIndexForm').on('submit', function (e) {
                e.preventDefault();
                const data = {
                    chooser: $('#BlockChooser').val(),
                    region_id: $('#BlockRegionId').val(),
                    title: $('#BlockTitle').val()
                };
                ajaxRequest($(this).attr('action'), data);
            });

            $('.pagination').on('click', 'li a', function (e) {
                e.preventDefault();
                ajaxRequest($(this).attr('href'));
            });
        });
    </script>
    <?php $this->end(); endif;

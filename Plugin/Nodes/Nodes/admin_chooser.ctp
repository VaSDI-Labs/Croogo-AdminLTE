<?php
/**
 * @var ViewAnnotation $this
 * @var array $nodes
 * @var array $nodeTypes
 */

echo $this->Html->css('/bower_components/datatables.net-bs/css/dataTables.bootstrap.min');
echo $this->Html->script([
    '/bower_components/datatables.net/js/jquery.dataTables.min',
    '/bower_components/datatables.net-bs/js/dataTables.bootstrap.min'
]);


$tableHeaders = $this->Html->tableHeaders([
    __d('croogo', 'Id'),
    __d('croogo', 'Title'),
    __d('croogo', 'Created'),
]);
$tableHeaders = $this->Html->tag('thead', $tableHeaders);
$tableFooter = $this->Html->tag('tfoot', $tableHeaders);

$rows = [];
foreach ($nodes as $node) {
    $linkTitle = $this->Html->link($node['Node']['title'], [
        'admin' => false,
        'plugin' => 'nodes',
        'controller' => 'nodes',
        'action' => 'view',
        'type' => $node['Node']['type'],
        'slug' => $node['Node']['slug'],
    ], [
        'class' => 'item-choose',
        'data-chooser_type' => 'Node',
        'data-chooser_id' => $node['Node']['id'],
        'data-chooser_title' => $node['Node']['title'],
        'rel' => sprintf(
            'plugin:%s/controller:%s/action:%s/type:%s/slug:%s',
            'nodes',
            'nodes',
            'view',
            $node['Node']['type'],
            $node['Node']['slug']
        ),
    ]);

    $popup = [];
    $popup[] = [
        __d('croogo', 'Promoted'),
        $this->Layout->status($node['Node']['promote'])
    ];
    $popup[] = [
        __d('croogo', 'Status'),
        $this->Layout->status($node['Node']['status'])
    ];
    $popup = $this->Html->tag('table', $this->Html->tableCells($popup), [
        'class' => 'table table-condensed',
    ]);

    $popover = " " . $this->Html->link('', '#', [
            'class' => 'popovers action',
            'icon' => $this->Theme->getIcon('info'),
            'data-title' => __d('croogo', 'Type') . ": " . __d('croogo', $nodeTypes[$node['Node']['type']]),
            'data-trigger' => 'focus',
            'data-placement' => 'right',
            'data-html' => true,
            'data-content' => h($popup),
        ]);

    $rows[] = [
        $node['Node']['id'],
        $linkTitle . $popover,
        $this->Time->niceShort($node['Node']['created']),
    ];
}
$tableBody = $this->Html->tableCells($rows);

?>
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title"><?php echo __d('croogo', 'Nodes') ?></h3>

        <div class="box-tools">
            <?php echo $this->Form->create('Node', [
                'class' => 'form-inline',
                'url' => isset($url) ? $url : ['action' => 'index'],
                'inputDefaults' => [
                    'label' => false,
                ],
            ]);
            echo $this->Form->input('chooser', [
                'type' => 'hidden',
                'value' => isset($this->request->query['chooser']),
            ]); ?>
            <div class="input-group input-group-sm" style="width: 150px;">
                <?php
                echo $this->Form->input('filter', [
                    'placeholder' => __d('croogo', 'Search...'),
                    'tooltip' => false,
                    'div' => false,
                    'class' => 'form-control pull-right'
                ]); ?>

                <div class="input-group-btn">
                    <?php echo $this->Form->button('', [
                        'type' => 'submit',
                        'button' => 'default',
                        'icon' => $this->Theme->getIcon('search'),
                    ]); ?>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
    <div class="box-body table-responsive no-padding">
        <?php echo $this->Html->tag('table', $tableHeaders . $tableBody . $tableFooter, [
            'class' => 'table table-bordered table-striped',
            'id' => 'chooserTable'
        ]); ?>
    </div>
    <div class="box-footer">
        <?php echo $this->element('admin/pagination'); ?>
    </div>
</div>
<script>
    $(function () {
        $('.popovers').popover();

        Admin.modalLarge();
        Admin.chooserUpdate('#NodeIndexForm', {
			chooser: $('#NodeChooser').val(),
			filter: $('#NodeFilter').val()
		});



        $('#chooserTable').DataTable({
            'paging': false,
            'lengthChange': false,
            'searching': false,
            'ordering': true,
            'info': false,
            'autoWidth': true,
        });
    });
</script>

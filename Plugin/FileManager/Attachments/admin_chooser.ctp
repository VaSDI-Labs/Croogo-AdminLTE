<?php
/**
 * @var ViewIDE $this
 * @var array $attachments
 * @var string $uploadsDir
 */
echo $this->Html->css('/bower_components/datatables.net-bs/css/dataTables.bootstrap.min');
echo $this->Html->script([
    '/bower_components/datatables.net/js/jquery.dataTables.min',
    '/bower_components/datatables.net-bs/js/dataTables.bootstrap.min'
]);

$tableHeaders = $this->Html->tableHeaders([
    __d('croogo', 'Id'),
    __d('croogo', 'Title'),
    __d('croogo', 'Type'),
    __d('croogo', 'Created'),
]);
$tableHeaders = $this->Html->tag('thead', $tableHeaders);
$tableFooter = $this->Html->tag('tfoot', $tableHeaders);

$rows = [];
foreach ($attachments as $attachment) {
    $linkTitle = $this->Html->link($attachment['Attachment']['title'],
        "/{$uploadsDir}/" . $attachment['Attachment']['slug'],
        [
            'class' => 'item-choose',
            'data-chooser_type' => 'Node',
            'data-chooser_id' => $attachment['Attachment']['id'],
            'data-chooser_title' => $attachment['Attachment']['title'],
            'rel' => sprintf(
                "/{$uploadsDir}/%s",
                $attachment['Attachment']['slug']
            ),
        ]);

    $rows[] = [
        $attachment['Attachment']['id'],
        $linkTitle,
        __d('croogo', $attachment['Attachment']['mime_type']),
        $this->Time->niceShort($attachment['Attachment']['created']),
    ];
}
$tableBody = $this->Html->tableCells($rows);
?>
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title"><?php echo __d('croogo', 'Attachments') ?></h3>

        <div class="box-tools">
            <?php echo $this->Form->create('Attachment', [
                'class' => 'form-inline',
                'url' => isset($url) ? $url : ['action' => 'index'],
                'inputDefaults' => [
                    'label' => false,
                ],
            ]);
            echo $this->Form->input('chooser_type', [
                'type' => 'hidden',
                'value' => isset($this->request->query['chooser_type']) ? $this->request->query['chooser_type'] : 'attachment',
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
    function ajaxRequest(url, data){
        let ajaxOption = {
            url: url,
            dataType: "html",
            success: function (data) {
                $('#link_choosers').find('.modal-body').html($(data).find('.content-wrapper > .content').html());
            }
        };

        if(data !== undefined) ajaxOption.data = data;

        $.ajax(ajaxOption);
    }
    $(function () {
        $('.popovers').popover();

        const modalPopup = $('#link_choosers');
        modalPopup.find('.modal-dialog').addClass('modal-lg');

        $('body').on('click', function () {
            if (!modalPopup.hasClass('in')) {
                modalPopup.find('.modal-dialog').removeClass('modal-lg');
            }
        });

        $('#AttachmentIndexForm').on('submit', function (e) {
            e.preventDefault();
            const data = {
                chooser_type: $('#AttachmentChooserType').val(),
                chooser: $('#AttachmentChooser').val(),
                filter: $('#AttachmentFilter').val()
            };
            ajaxRequest($(this).attr('action'), data);
        });

        $('.pagination').on('click', 'li a', function (e) {
            e.preventDefault();
            ajaxRequest($(this).attr('href'));
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


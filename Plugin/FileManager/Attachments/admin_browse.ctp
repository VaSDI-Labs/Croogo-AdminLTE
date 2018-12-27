
<?php
/**
 * @var ViewAnnotation $this
 * @var array $attachments
 */

$this->extend('/Common/admin_index');

$this->start('actions');
    echo $this->Croogo->adminAction(__d('croogo', 'New Attachment'), ['action' => 'add', 'editor' => 1], ['button' => 'success']);
$this->end();

$this->start('table-heading');
    $tableHeaders = $this->Html->tableHeaders([
        $this->Paginator->sort('id', __d('croogo', 'Id')),
        '&nbsp;',
        $this->Paginator->sort('title', __d('croogo', 'Title')),
        '&nbsp;',
        __d('croogo', 'URL'),
        __d('croogo', 'Actions'),
    ]);
    echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->append('table-body'); ?>
    <style>
        .content-wrapper {
            margin-left: 0 !important;
        }
    </style>
<?php $rows = [];
    foreach ($attachments as $attachment) {
        $actions = [];
        $actions[] = $this->Croogo->adminRowAction('',
            ['controller' => 'attachments', 'action' => 'edit', $attachment['Attachment']['id'], 'editor' => 1],
            ['icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('croogo', 'Edit')]
        );
        $actions[] = $this->Croogo->adminRowAction('', [
            'controller' => 'attachments',
            'action' => 'delete',
            $attachment['Attachment']['id'],
            'editor' => 1,
        ], ['icon' => $this->Theme->getIcon('delete'), 'tooltip' => __d('croogo', 'Delete')], __d('croogo', 'Are you sure?'));

        list($mimeType, $mimeSubtype) = explode('/', $attachment['Attachment']['mime_type']);
        $imagecreatefrom = array('gif', 'jpeg', 'png', 'string', 'wbmp', 'webp', 'xbm', 'xpm');
        if ($mimeType == 'image' && in_array($mimeSubtype, $imagecreatefrom)) {
            $thumbnail = $this->Html->link($this->Image->resize($attachment['Attachment']['path'], 100, 200), $attachment['Attachment']['path'], array(
                'class' => 'thickbox',
                'escape' => false,
                'title' => $attachment['Attachment']['title'],
            ));
        } else {
            $thumbnail = $this->Html->image('/croogo/img/icons/page_white.png') . ' ' . $attachment['Attachment']['mime_type'] . ' (' . $this->FileManager->filename2ext($attachment['Attachment']['slug']) . ')';
            $thumbnail = $this->Html->link($thumbnail, '#', [
                'escape' => false,
            ]);
        }

        $rows[] = [
            $attachment['Attachment']['id'],
            $thumbnail,
            $attachment['Attachment']['title'],
            $this->Html->link('', '#', [
                'onclick' => "Croogo.Wysiwyg.choose('" . $attachment['Attachment']['slug'] . "');",
                'escapeTitle' => false,
                'icon' => $this->Theme->getIcon('attach'),
                'tooltip' => __d('croogo', 'Insert')
            ]),
            $this->Html->link(Router::url($attachment['Attachment']['path']),
                $attachment['Attachment']['path'],
                ['onclick' => "Croogo.Wysiwyg.choose('" . $attachment['Attachment']['slug'] . "');"]
            ),
            $this->Html->div('btn-group item-actions', implode(' ', $actions)),
        ];
    }
    echo $this->Html->tableCells($rows);

    echo $tableHeaders;
$this->end();

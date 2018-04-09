<?php
/**
 * @var ViewIDE $this
 * @var array $attachments
 */

$this->extend('/Common/admin_index');

$this->Html
    ->addCrumb('', '/admin', ['icon' => $this->Theme->getIcon('home')])
    ->addCrumb(__d('croogo', 'Attachments'));

$this->start('table-heading');
    $tableHeaders = $this->Html->tableHeaders([
        $this->Paginator->sort('id', __d('croogo', 'Id')),
        '&nbsp;',
        $this->Paginator->sort('title', __d('croogo', 'Title')),
        __d('croogo', 'URL'),
        __d('croogo', 'Actions'),
    ]);
    echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->append('table-body');

    $rows = [];
    foreach ($attachments as $attachment) {
        $actions = [];
        $actions[] = $this->Croogo->adminRowActions($attachment['Attachment']['id']);
        $actions[] = $this->Croogo->adminRowAction('',
            ['controller' => 'attachments', 'action' => 'edit', $attachment['Attachment']['id']],
            ['icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('croogo', 'Edit this item')]
        );
        $actions[] = $this->Croogo->adminRowAction('',
            ['controller' => 'attachments', 'action' => 'delete', $attachment['Attachment']['id']],
            ['icon' => $this->Theme->getIcon('delete'), 'tooltip' => __d('croogo', 'Remove this item')],
            __d('croogo', 'Are you sure?')
        );

        $mimeType = explode('/', $attachment['Attachment']['mime_type']);
        $imageType = $mimeType['1'];
        $mimeType = $mimeType['0'];
        $imagecreatefrom = ['gif', 'jpeg', 'png', 'string', 'wbmp', 'webp', 'xbm', 'xpm'];
        if ($mimeType == 'image' && in_array($imageType, $imagecreatefrom)) {
            $imgUrl = $this->Image->resize('/uploads/' . $attachment['Attachment']['slug'], 100, 200, true, ['alt' => $attachment['Attachment']['title']]);
            $thumbnail = $this->Html->link($imgUrl, $attachment['Attachment']['path'],
                ['escape' => false, 'title' => $attachment['Attachment']['title']]);
        } else {
            $thumbnail = $this->Html->thumbnail('/croogo/img/icons/page_white.png', ['alt' => $attachment['Attachment']['mime_type']]) . ' ' . $attachment['Attachment']['mime_type'] . ' (' . $this->FileManager->filename2ext($attachment['Attachment']['slug']) . ')';
        }

        $rows[] = [
            $attachment['Attachment']['id'],
            $thumbnail,
            $this->Html->tag('div', $attachment['Attachment']['title'], ['class' => 'ellipsis']),
            $this->Html->tag('div',
                $this->Html->link(
                    $this->Html->url($attachment['Attachment']['path'], true),
                    $attachment['Attachment']['path'],
                    ['target' => '_blank']
                ), ['class' => 'ellipsis']
            ),
            $this->Html->div('btn-group item-actions', implode(' ', $actions)),
        ];
    }
    echo $this->Html->tableCells($rows);

$this->end();



<?php
/**
 * @var ViewIDE $this
 * @var array $menus
 */
$this->extend('/Common/admin_index');

$this->Html
    ->addCrumb($this->Html->icon('home'), '/admin')
    ->addCrumb(__d('croogo', 'Menus'));


$this->start('table-heading');
    $tableHeaders = $this->Html->tableHeaders([
        $this->Paginator->sort('id', __d('croogo', 'Id')),
        $this->Paginator->sort('title', __d('croogo', 'Title')),
        $this->Paginator->sort('alias', __d('croogo', 'Alias')),
        $this->Paginator->sort('link_count', __d('croogo', 'Link Count')),
        $this->Paginator->sort('status', __d('croogo', 'Status')),
        __d('croogo', 'Actions'),
    ]);
    echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->start('table-body');
    $rows = [];
    foreach ($menus as $menu) {
        $actions = [];
        $actions[] = $this->Croogo->adminRowAction('',
            ['controller' => 'links', 'action' => 'index', '?' => ['menu_id' => $menu['Menu']['id']]],
            ['icon' => $this->Theme->getIcon('inspect'), 'tooltip' => __d('croogo', 'View links')]
        );
        $actions[] = $this->Croogo->adminRowActions($menu['Menu']['id']);
        $actions[] = $this->Croogo->adminRowAction('',
            ['controller' => 'menus', 'action' => 'edit', $menu['Menu']['id']],
            ['icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('croogo', 'Edit this item')]
        );
        $actions[] = $this->Croogo->adminRowAction('',
            ['controller' => 'menus', 'action' => 'delete', $menu['Menu']['id']],
            ['icon' => $this->Theme->getIcon('delete'), 'tooltip' => __d('croogo', 'Remove this item')],
            __d('croogo', 'Are you sure?')
        );

        $title = $this->Html->link($menu['Menu']['title'], ['controller' => 'links', '?' => ['menu_id' => $menu['Menu']['id']]]);

        if ($menu['Menu']['status'] === CroogoStatus::PREVIEW) {
            $title .= $this->Html->tag('span', __d('croogo', 'preview'), [
                'class' => 'label label-warning'
            ]);
        }

        $rows[] = [
            $menu['Menu']['id'],
            $title,
            $menu['Menu']['alias'],
            $menu['Menu']['link_count'],
            $this->element('admin/toggle', ['id' => $menu['Menu']['id'], 'status' => $menu['Menu']['status'],]),
            $this->Html->div('btn-group item-actions', implode(' ', $actions)),
        ];
    }

    echo $this->Html->tableCells($rows);
$this->end();


<?php
/**
 * @var ViewAnnotation $this
 * @var array $languages
 */

$this->extend('/Common/admin_index');

$this->Html
    ->addCrumb($this->Html->icon('home'), '/admin')
	->addCrumb(__d('croogo', 'Settings'), ['plugin' => 'settings', 'controller' => 'settings', 'action' => 'prefix', 'Site'])
	->addCrumb(__d('croogo', 'Languages'));

$this->start('table-heading');
    $tableHeaders = $this->Html->tableHeaders([
        $this->Paginator->sort('id', __d('croogo', 'Id')),
        $this->Paginator->sort('title', __d('croogo', 'Title')),
        $this->Paginator->sort('native', __d('croogo', 'Native')),
        $this->Paginator->sort('alias', __d('croogo', 'Alias')),
        $this->Paginator->sort('status', __d('croogo', 'Status')),
        __d('croogo', 'Actions'),
    ]);
    echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->append('table-body');
    $rows = [];
    foreach ($languages as $language) {
        $actions = [];
        $actions[] = $this->Croogo->adminRowActions($language['Language']['id']);
        $actions[] = $this->Croogo->adminRowAction('',
            ['action' => 'moveup', $language['Language']['id']],
            ['icon' => $this->Theme->getIcon('move-up'), 'tooltip' => __d('croogo', 'Move up')]
        );
        $actions[] = $this->Croogo->adminRowAction('',
            ['action' => 'movedown', $language['Language']['id']],
            ['icon' => $this->Theme->getIcon('move-down'), 'tooltip' => __d('croogo', 'Move down')]
        );
        $actions[] = $this->Croogo->adminRowAction('',
            ['action' => 'edit', $language['Language']['id']],
            ['icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('croogo', 'Edit this item')]
        );
        $actions[] = $this->Croogo->adminRowAction('',
            ['action' => 'delete', $language['Language']['id']],
            ['icon' => $this->Theme->getIcon('delete'), 'tooltip' => __d('croogo', 'Remove this item')],
            __d('croogo', 'Are you sure?')
        );

        $rows[] = [
            $language['Language']['id'],
            $language['Language']['title'],
            $language['Language']['native'],
            $language['Language']['alias'],
            $this->Html->status($language['Language']['status']),
            $this->Html->div('btn-group item-actions', implode(' ', $actions)),
        ];
    }

    echo $this->Html->tableCells($rows);
$this->end();


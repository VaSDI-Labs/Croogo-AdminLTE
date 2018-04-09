<?php
/**
 * @var ViewIDE $this
 * @var array $vocabulary
 * @var array $terms
 * @var array $defaultType
 */

$this->extend('/Common/admin_index');

$this->Html
    ->addCrumb($this->Html->icon('home'), '/admin')
    ->addCrumb(__d('croogo', 'Content'), ['plugin' => 'nodes', 'controller' => 'nodes', 'action' => 'index'])
    ->addCrumb(__d('croogo', 'Vocabularies'), ['plugin' => 'taxonomy', 'controller' => 'vocabularies', 'action' => 'index'])
    ->addCrumb($vocabulary['Vocabulary']['title']);

$this->append('actions');
    echo $this->Croogo->adminAction(__d('croogo', 'New Term'), ['action' => 'add', $vocabulary['Vocabulary']['id']]);
$this->end();

if (isset($this->request->params['named'])) {
    foreach ($this->request->params['named'] as $nn => $nv) {
        $this->Paginator->options['url'][] = $nn . ':' . $nv;
    }
}
$this->start('table-heading');
    $tableHeaders = $this->Html->tableHeaders([
        __d('croogo', 'Id'),
        __d('croogo', 'Title'),
        __d('croogo', 'Slug'),
        __d('croogo', 'Actions'),
    ]);
    echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->append('table-body');
    $rows = [];

    foreach ($terms as $term):
        $actions = [];
        $actions[] = $this->Croogo->adminRowActions($term['Term']['id']);
        $actions[] = $this->Croogo->adminRowAction('',
            ['action' => 'moveup', $term['Term']['id'], $vocabulary['Vocabulary']['id']],
            ['icon' => $this->Theme->getIcon('move-up'), 'tooltip' => __d('croogo', 'Move up')]
        );
        $actions[] = $this->Croogo->adminRowAction('',
            ['action' => 'movedown', $term['Term']['id'], $vocabulary['Vocabulary']['id']],
            ['icon' => $this->Theme->getIcon('move-down'), 'tooltip' => __d('croogo', 'Move down')]
        );
        $actions[] = $this->Croogo->adminRowAction('',
            ['action' => 'edit', $term['Term']['id'], $vocabulary['Vocabulary']['id']],
            ['icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('croogo', 'Edit this item')]
        );
        $actions[] = $this->Croogo->adminRowAction('',
            ['action' => 'delete', $term['Term']['id'], $vocabulary['Vocabulary']['id']],
            ['icon' => $this->Theme->getIcon('delete'), 'tooltip' => __d('croogo', 'Remove this item')],
            __d('croogo', 'Are you sure?'));

        // Title Column
        $titleCol = $term['Term']['title'];
        if (isset($defaultType['alias'])) {
            $titleCol = $this->Html->link($term['Term']['title'], [
                'plugin' => 'nodes',
                'controller' => 'nodes',
                'action' => 'term',
                'type' => $defaultType['alias'],
                'slug' => $term['Term']['slug'],
                'admin' => 0,
            ], [
                'target' => '_blank',
            ]);
        }

        if (!empty($term['Term']['indent'])):
            $titleCol = str_repeat('&emsp;', $term['Term']['indent']) . $titleCol;
        endif;

        // Build link list
        $typeLinks = $this->Taxonomies->generateTypeLinks($vocabulary['Type'], $term);
        if (!empty($typeLinks)) {
            $titleCol .= $this->Html->tag('small', $typeLinks);
        }

        $rows[] = [
            $term['Term']['id'],
            $titleCol,
            $term['Term']['slug'],
            $this->Html->div('btn-group item-actions', implode(' ', $actions)),
        ];
    endforeach;
    echo $this->Html->tableCells($rows);
$this->end();


<?php
/**
 * @var ViewAnnotation $this
 * @var array $terms
 */

$tableHeaders = $this->Html->tableHeaders([
    __d('croogo', 'Id'),
    __d('croogo', 'Title'),
    __d('croogo', 'Slug'),
]);
$tableHeaders = $this->Html->tag('thead', $tableHeaders);

$rows = [];
foreach ($terms as $term):
    $titleCol = $term['Term']['title'];
    if (isset($defaultType)) {
        $titleCol = $this->Html->link($term['Term']['title'], [
            'plugin' => 'nodes',
            'controller' => 'nodes',
            'action' => 'term',
            'type' => $defaultType['alias'],
            'slug' => $term['Term']['slug'],
            'admin' => false
        ], [
            'class' => 'item-choose',
            'data-chooser_type' => 'Node',
            'data-chooser_id' => $term['Term']['id'],
            'rel' => sprintf(
                'plugin:%s/controller:%s/action:%s/type:%s/slug:%s',
                'nodes',
                'nodes',
                'term',
                $defaultType['alias'],
                $term['Term']['slug']
            ),
        ]);
    }
    $rows[] = [$term['Term']['id'], $titleCol, $term['Term']['slug']];

endforeach;

$tableBody = $this->Html->tableCells($rows); ?>
<div class="box box-primary">
    <div class="box-body table-responsive no-padding">
        <?php echo $this->Html->tag('table', $tableHeaders . $tableBody, [
            'class' => 'table table-striped'
        ]); ?>
    </div>
</div>

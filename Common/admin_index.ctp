<?php /** @var ViewAnnotation $this */

if (empty($modelClass)) $modelClass = Inflector::singularize($this->name);
if (!isset($className)) $className = strtolower($this->name);

$humanName = Inflector::humanize(Inflector::underscore($modelClass));
$i18nDomain = empty($this->params['plugin']) ? 'croogo' : $this->params['plugin'];

$rowClass = $this->Theme->getCssClass('row');
$columnFull = $this->Theme->getCssClass('columnFull');
$tableClass = isset($tableClass) ? $tableClass : $this->Theme->getCssClass('tableClass');

$showActions = isset($showActions) ? $showActions : true;

if ($pageHeading = trim($this->fetch('page-heading'))):
    echo $pageHeading;
endif; ?>

<?php if ($showActions): ?>
    <div class="<?php echo $rowClass; ?>">
        <div class="actions <?php echo $columnFull; ?> btn-group margin-bottom">
            <?php
            if ($actionsBlock = $this->fetch('actions')):
                echo $actionsBlock;
            else:
                echo $this->Croogo->adminAction(
                    __d('croogo', 'New %s', __d($i18nDomain, $humanName)),
                    ['action' => 'add'],
                    ['button' => 'success']
                );
            endif;
            ?>
        </div>
    </div>
<?php endif; ?>

<?php
$tableHeaders = trim($this->fetch('table-heading'));
if (!$tableHeaders && isset($displayFields)):
    $tableHeaders = [];
    foreach ($displayFields as $field => $arr):
        $tableHeaders[] = $arr['sort']
            ? $this->Paginator->sort($field, __d($i18nDomain, $arr['label']))
            : __d($i18nDomain, $arr['label']);
    endforeach;
    $tableHeaders[] = __d('croogo', 'Actions');
    $tableHeaders = $this->Html->tableHeaders($tableHeaders);
    $tableHeaders = $this->Html->tag('thead', $tableHeaders);
endif;

$tableBody = trim($this->fetch('table-body'));
if (!$tableBody && isset($displayFields)):
    $rows = [];
    if (!empty(${strtolower($this->name)})):
        foreach (${strtolower($this->name)} as $item):
            $actions = [];

            if (isset($this->request->query['chooser'])):
                $title = isset($item[$modelClass]['title']) ? $item[$modelClass]['title'] : null;
                $actions[] = $this->Croogo->adminRowAction(__d('croogo', 'Choose'), '#', [
                    'class' => 'item-choose',
                    'data-chooser_type' => $modelClass,
                    'data-chooser_id' => $item[$modelClass]['id'],
                ]);
            else:
                $actions[] = $this->Croogo->adminRowAction('',
                    ['action' => 'edit', $item[$modelClass]['id']],
                    ['icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('croogo', 'Edit this item')]
                );
                $actions[] = $this->Croogo->adminRowActions($item[$modelClass]['id']);
                $actions[] = $this->Croogo->adminRowAction('',
                    ['action' => 'delete', $item[$modelClass]['id'],],
                    ['icon' => $this->Theme->getIcon('delete'), 'tooltip' => __d('croogo', 'Remove this item')],
                    __d('croogo', 'Are you sure?')
                );
            endif;
            $row = [];
            foreach ($displayFields as $key => $val):
                extract($val);
                if (!is_int($key)) {
                    $val = $key;
                }
                if (strpos($val, '.') === false) {
                    $val = $modelClass . '.' . $val;
                }
                list($model, $field) = pluginSplit($val);
                $row[] = $this->Layout->displayField($item, $model, $field, compact('type', 'url', 'options'));
            endforeach;
            $row[] = $this->Html->div('btn-group item-actions', implode(' ', $actions));
            $rows[] = $row;
        endforeach;
        $tableBody = $this->Html->tableCells($rows);
    endif;
endif;

$tableFooters = trim($this->fetch('table-footer'));

$searchBlock = $this->fetch('search');
if (!$searchBlock):
    $searchBlock = $this->element('admin/search');
endif;
echo $searchBlock;


if ($contentBlock = trim($this->fetch('content'))):
    echo $this->element('admin/search');
    echo $contentBlock;
else: ?>
    <div class="box box-primary">
        <div class="box-body<?php echo (($this->exists('table-heading') || isset($displayFields)) && !$this->exists('main')) ? " table-responsive no-padding" : ""; ?>">
            <?php
            if ($formStart = trim($this->fetch('form-start'))):
                echo $formStart;
            endif;

            if ($mainBlock = trim($this->fetch('main'))):
                echo $mainBlock;
            else: ?>
                <table class="<?php echo $tableClass; ?>">
                    <?php
                    echo $tableHeaders;
                    echo $tableBody;
                    if ($tableFooters):
                        echo $tableFooters;
                    endif;
                    ?>
                </table>
            <?php endif; ?>

            <?php if ($bulkAction = trim($this->fetch('bulk-action'))): ?>
                <div id="bulk-action">
                    <?php echo $bulkAction; ?>
                </div>
            <?php endif; ?>

            <?php
            if ($formEnd = trim($this->fetch('form-end'))):
                echo $formEnd;
            endif;
            ?>
        </div>
            <?php
            if ($pagingBlock = $this->fetch('paging')):
                echo $this->Html->div('box-footer clearfix');
                echo $pagingBlock;
                echo $this->Html->useTag('tagend','div');
            else:
                if (isset($this->Paginator) && isset($this->request['paging'])):
                    echo $this->Html->div('box-footer clearfix');
                    echo $this->element('admin/pagination');
                    echo $this->Html->useTag('tagend','div');
                endif;
            endif;
            ?>
    </div>
<?php endif; ?>
<?php

if ($pageFooter = trim($this->fetch('page-footer'))):
    echo $pageFooter;
endif;

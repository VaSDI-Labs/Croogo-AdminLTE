
<?php
/**
 * @var ViewAnnotation $this
 * @var string $modelAlias
 * @var array $record
 * @var mixed $displayField
 * @var integer $id
 * @var array $translations
 * @var mixed $runtimeModelAlias
 */

$this->extend('/Common/admin_index');
$this->name = 'translate';

$plugin = $controller = 'nodes';
if (isset($this->request->params['models'][$modelAlias])) {
    $plugin = $this->request->params['models'][$modelAlias]['plugin'];
    $controller = strtolower(Inflector::pluralize($modelAlias));
}

$this->Html
    ->addCrumb('', '/admin', ['icon' => $this->Theme->getIcon('home')])
    ->addCrumb(Inflector::pluralize($modelAlias), ['plugin' => Inflector::underscore($plugin), 'controller' => Inflector::underscore($controller), 'action' => 'index',])
    ->addCrumb($record[$modelAlias][$displayField], ['plugin' => Inflector::underscore($plugin), 'controller' => Inflector::underscore($controller), 'action' => 'edit', $record[$modelAlias]['id'],])
    ->addCrumb(__d('croogo', 'Translations'));

$this->start('actions');

    $btnGroup = $this->Html->link(__d('croogo', 'Translate in a new language'), [
        'plugin' => 'settings',
        'controller' => 'languages',
        'action' => 'select',
        $record[$modelAlias]['id'],
        $modelAlias
    ], [
        'button' => 'default',
    ]);

    if (!empty($languages)) {
        $btnGroup .= $this->Form->button('<span class="caret"></span>', [
            'type' => 'button',
            'button' => 'default',
            'class' => 'dropdown-toggle',
            'data-toggle' => 'dropdown'
        ]);

        $out = null;
        foreach ($languages as $languageAlias => $languageDisplay) {
            $out .= $this->Html->tag('li',
                $this->Html->link($languageDisplay, [
                    'admin' => true,
                    'plugin' => 'translate',
                    'controller' => 'translate',
                    'action' => 'edit',
                    $id,
                    $modelAlias,
                    'locale' => $languageAlias,
                ])
            );
        }
        $btnGroup .= $this->Html->tag('ul', $out, ['class' => 'dropdown-menu']);
    }

    echo $this->Html->div('btn-group', $btnGroup);

$this->end();

if (count($translations) == 0):
    $this->append('main');

    echo $this->Html->para(null, __d('croogo', 'No translations available.'));

    $this->end();
endif;

$this->append('table-heading');
    $tableHeaders = $this->Html->tableHeaders([
        __d('croogo', 'Title'),
        __d('croogo', 'Locale'),
        __d('croogo', 'Actions'),
    ]);
    echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->append('table-body');
    $rows = [];
    foreach ($translations as $translation):
        $actions = [];
        $actions[] = $this->Croogo->adminRowAction('',
            [
                'action' => 'edit',
                $id,
                $modelAlias,
                'locale' => $translation[$runtimeModelAlias]['locale'],
            ],
            ['icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('croogo', 'Edit this item'),]
        );
        $actions[] = $this->Croogo->adminRowAction('',
            [
                'action' => 'delete',
                $id,
                $modelAlias,
                $translation[$runtimeModelAlias]['locale'],
            ],
            ['icon' => $this->Theme->getIcon('delete'), 'tooltip' => __d('croogo', 'Remove this item'),],
            __d('croogo', 'Are you sure?')
        );

        $rows[] = [
            $translation[$runtimeModelAlias]['content'],
            $translation[$runtimeModelAlias]['locale'],
            $this->Html->div('btn-group item-actions', implode(' ', $actions)),
        ];
    endforeach;

    echo $this->Html->tableCells($rows);
$this->end();

<?php
/**
 * @var ViewIDE $this
 * @var array $corePlugins
 * @var array $bundledPlugins
 */

$this->extend('/Common/admin_index');

$this->name = 'extensions-plugins';

$this->Html
	->addCrumb('', '/admin', ['icon' => $this->Theme->getIcon('home')])
	->addCrumb(__d('croogo', 'Extensions'), ['plugin' => 'extensions', 'controller' => 'extensions_plugins', 'action' => 'index'])
	->addCrumb(__d('croogo', 'Plugins'));

$this->start('actions');
    echo $this->Croogo->adminAction(__d('croogo', 'Upload'),
        ['action' => 'add'],
        ['button' => 'success']
    );
$this->end(); ?>

<div class="box box-primary">
    <div class="box-body table-responsive no-padding">
        <table class="table table-striped table-hover">
            <?php $tableHeaders = $this->Html->tableHeaders([
                __d('croogo', 'Alias'),
                __d('croogo', 'Name'),
                __d('croogo', 'Description'),
                __d('croogo', 'Active'),
                __d('croogo', 'Actions'),
            ]);
            echo $this->Html->tag('thead', $tableHeaders);

            $rows = [];
            foreach ($plugins as $pluginAlias => $pluginData){
                $toggleText = $pluginData['active'] ? __d('croogo', 'Deactivate') : __d('croogo', 'Activate');

                $actions = [];
                if (!in_array($pluginAlias, $corePlugins)):
                    $icon = $pluginData['active'] ? $this->Theme->getIcon('power-off') : $this->Theme->getIcon('power-on');
                    $actions[] = $this->Croogo->adminRowAction('',
                        ['action' => 'toggle',	$pluginAlias],
                        ['icon' => $icon, 'tooltip' => $toggleText, 'method' => 'post']
                    );
                    if (!in_array($pluginAlias, $bundledPlugins)):
                        $actions[] = $this->Croogo->adminRowAction('',
                            ['action' => 'delete', $pluginAlias],
                            ['icon' => $this->Theme->getIcon('delete'), 'class' => 'text-red', 'tooltip' => __d('croogo', 'Delete')],
                            __d('croogo', 'Are you sure?')
                        );
                    endif;
                endif;

                if ($pluginData['active'] && !in_array($pluginAlias, $bundledPlugins) && !in_array($pluginAlias, $corePlugins)) {
                    $actions[] = $this->Croogo->adminRowAction('',
                        ['action' => 'moveup', $pluginAlias],
                        ['icon' => $this->Theme->getIcon('move-up'), 'tooltip' => __d('croogo', 'Move up'), 'method' => 'post'],
                        __d('croogo', 'Are you sure?')
                    );

                    $actions[] = $this->Croogo->adminRowAction('',
                        ['action' => 'movedown', $pluginAlias],
                        ['icon' => $this->Theme->getIcon('move-down'), 'tooltip' => __d('croogo', 'Move down'), 'method' => 'post'],
                        __d('croogo', 'Are you sure?')
                    );
                }

                if ($pluginData['needMigration']) {
                    $actions[] = $this->Croogo->adminRowAction(__d('croogo', 'Migrate'), [
                        'action' => 'migrate',
                        $pluginAlias,
                    ], [], __d('croogo', 'Are you sure?'));
                }

                $rows[] = [
                    $pluginAlias,
                    $pluginData['name'],
                    !empty($pluginData['description']) ? $pluginData['description'] : '',
                    $this->Html->status($pluginData['active']),
                    $this->Html->div('btn-group item-actions', implode(' ', $actions)),
                ];
            }

            echo $this->Html->tableCells($rows); ?>
        </table>
    </div>
</div>



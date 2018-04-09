<?php
/**
 * @var ViewIDE $this
 * @var array $breadcrumb
 * @var string $path
 * @var array $content
 * @var array $deletablePaths
 */

$this->extend('/Common/admin_index');

$this->Html
    ->addCrumb('', '/admin', ['icon' => $this->Theme->getIcon('home')])
    ->addCrumb(__d('croogo', 'File Manager'));

$this->start('actions');
echo $this->FileManager->adminAction(__d('croogo', 'Upload here'),
    ['controller' => 'file_manager', 'action' => 'upload'],
    $path
);
echo $this->FileManager->adminAction(__d('croogo', 'Create directory'),
    ['controller' => 'file_manager', 'action' => 'create_directory'],
    $path
);
echo $this->FileManager->adminAction(__d('croogo', 'Create file'),
    ['controller' => 'file_manager', 'action' => 'create_file'],
    $path
);
$this->end(); ?>

<div class="box box-solid box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            <a href="#"><?php echo __d('croogo', 'You are here') . ' '; ?> </a> <span class="divider"> &gt; </span>
            <?php $breadcrumb = $this->FileManager->breadcrumb($path); ?>
            <?php foreach ($breadcrumb as $pathname => $p) : ?>
                <?php echo $this->FileManager->linkDirectory($pathname, $p); ?>
                <span class="divider"> <?php echo DS; ?> </span>
            <?php endforeach; ?>
        </h3>
    </div>
    <div class="box-body table-responsive no-padding directory-content">
        <table class="table table-striped">
            <?php
            $tableHeaders = $this->Html->tableHeaders([
                __d('croogo', 'Directory content'),
                __d('croogo', 'Actions'),
            ]);
            echo $this->Html->tag('thead', $tableHeaders);

            // directories
            $rows = [];
            foreach ($content['0'] as $directory):
                $actions = [];
                $fullpath = $path . $directory;
                $actions[] = $this->FileManager->linkDirectory(__d('croogo', 'Open'), $fullpath . DS);
                if ($this->FileManager->inPath($deletablePaths, $fullpath)) {
                    $actions[] = $this->FileManager->link(__d('croogo', 'Delete'), [
                        'controller' => 'file_manager',
                        'action' => 'delete_directory',
                    ], $fullpath);
                }
                $actions[] = $this->FileManager->link(__d('croogo', 'Rename'), [
                    'controller' => 'file_manager',
                    'action' => 'rename',
                ], $fullpath);
                $actions = $this->Html->div('btn-group item-actions', implode(' ', $actions));
                $rows[] = [
                    $this->Html->image('/croogo/img/icons/folder.png')
                    . " "
                    . $this->FileManager->linkDirectory($directory, $fullpath . DS),
                    $actions,
                ];
            endforeach;
            echo $this->Html->tableCells($rows, ['class' => 'directory'], ['class' => 'directory']);

            // files
            $rows = [];
            foreach ($content['1'] as $file):
                $actions = [];
                $fullpath = $path . $file;
                $icon = $this->FileManager->filename2icon($file);
                if ($icon == 'picture.png'):
                    $image = '/' . str_replace(WWW_ROOT, '', $fullpath);
                    $thickboxOptions = [
                        'class' => 'thickbox', 'escape' => false,
                    ];
                    $linkFile = $this->Html->link($file, $image, $thickboxOptions);
                    $actions[] = $this->Html->link(__d('croogo', 'View'),
                        $image,
                        $thickboxOptions
                    );
                else:
                    $linkFile = $this->FileManager->linkFile($file, $fullpath);
                    $actions[] = $this->FileManager->link(__d('croogo', 'Edit'),
                        [
                            'plugin' => 'file_manager',
                            'controller' => 'file_manager', 'action' => 'editfile'
                        ],
                        $fullpath
                    );
                endif;
                if ($this->FileManager->inPath($deletablePaths, $fullpath)) {
                    $actions[] = $this->FileManager->link(__d('croogo', 'Delete'), [
                        'controller' => 'file_manager',
                        'action' => 'delete_file',
                    ], $fullpath);
                }
                $actions[] = $this->FileManager->link(__d('croogo', 'Rename'), [
                    'controller' => 'file_manager',
                    'action' => 'rename',
                ], $fullpath);
                $actions = $this->Html->div('item-actions', implode(' ', $actions));
                $rows[] = [
                    $this->Html->image('/croogo/img/icons/' . $icon)
                    . " "
                    . $linkFile,
                    $actions,
                ];
            endforeach;
            echo $this->Html->tableCells($rows, ['class' => 'file'], ['class' => 'file']);
            echo $this->Html->tag('tfoot', $tableHeaders);
            ?>
        </table>
    </div>
</div>
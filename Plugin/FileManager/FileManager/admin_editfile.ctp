
<?php
/**
 * @var ViewAnnotation $this
 * @var string $absolutefilepath
 * @var array $breadcrumb
 * @var string $path
 * @var string $content
 */

$this->extend('/Common/admin_edit');

$this->viewVars['title_for_layout'] = __d('croogo', 'Edit file: %s', basename($absolutefilepath));

$this->Html
    ->addCrumb('', '/admin', ['icon' => $this->Theme->getIcon('home')])
    ->addCrumb(__d('croogo', 'File Manager'), ['plugin' => 'file_manager', 'controller' => 'file_manager', 'action' => 'browse'])
    ->addCrumb(basename($absolutefilepath));

$this->append('page-heading');
?>
    <div class="breadcrumb">
        <a href="#"><?php echo __d('croogo', 'You are here') . ' '; ?> </a> <span class="divider"> &gt; </span>
        <?php
        $breadcrumb = $this->FileManager->breadcrumb($path);
        foreach ($breadcrumb as $pathname => $p):
            echo $this->FileManager->linkDirectory($pathname, $p);
            echo $this->Html->tag('span', DS, ['class' => 'divider']);
        endforeach;
        ?>
    </div>
<?php
$this->end();

$this->append('form-start', $this->Form->create('FileManager', [
    'url' => $this->Html->url([
            'controller' => 'file_manager',
            'action' => 'editfile',
        ], true) . '?path=' . urlencode($absolutefilepath),
]));

$this->append('tab-heading');
    echo $this->Croogo->adminTab(__d('croogo', 'Edit'), '#filemanager-edit');
    echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');
    echo $this->Html->tabStart('filemanager-edit');
        echo $this->Form->input('FileManager.content', [
            'type' => 'textarea',
            'value' => $content,
            'label' => false,
        ]);
    echo $this->Html->tabEnd();

    echo $this->Croogo->adminTabs();
$this->end();

$this->append('panels');
    echo $this->Html->beginBox(__d('croogo', 'Publishing'));
        echo $this->Html->div('btn-group');
            echo $this->Form->button(__d('croogo', 'Save'));
            echo $this->Html->link(__d('croogo', 'Cancel'), ['action' => 'index'], ['button' => 'danger']);
        echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->endBox();

    echo $this->Croogo->adminBoxes();
$this->end();

$this->append('form-end', $this->Form->end());

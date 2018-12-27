
<?php /** @var ViewAnnotation $this */

$this->extend('/Common/admin_edit');

$this->Html
    ->addCrumb($this->Html->icon('home'), '/admin')
    ->addCrumb(__d('croogo', 'Blocks'), ['plugin' => 'blocks', 'controller' => 'blocks', 'action' => 'index']);

if ($this->request->params['action'] == 'admin_edit') {
    $this->Html->addCrumb($this->request->data['Block']['title']);
}
if ($this->request->params['action'] == 'admin_add') {
    $this->Html->addCrumb(__d('croogo', 'Add'));
}

$this->append('form-start', $this->Form->create('Block', [
    'class' => 'protected-form',
]));
$inputDefaults = $this->Form->inputDefaults();
$inputClass = isset($inputDefaults['class']) ? $inputDefaults['class'] : null;

$this->append('tab-heading');
    echo $this->Croogo->adminTab(__d('croogo', 'Block'), '#block-basic');
    echo $this->Croogo->adminTab(__d('croogo', 'Access'), '#block-access');
    echo $this->Croogo->adminTab(__d('croogo', 'Visibilities'), '#block-visibilities');
    echo $this->Croogo->adminTab(__d('croogo', 'Params'), '#block-params');
    echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');

    echo $this->Html->tabStart('block-basic');
        echo $this->Form->input('id');
        echo $this->Form->input('title', ['label' => __d('croogo', 'Title'),]);
        echo $this->Form->input('alias', [
            'label' => __d('croogo', 'Alias'),
            'help' => __d('croogo', 'unique name for your block'),
        ]);
        echo $this->Form->input('region_id', [
            'label' => __d('croogo', 'Region'),
            'help' => __d('croogo', 'if you are not sure, choose \'none\''),
        ]);
        echo $this->Form->input('body', ['label' => __d('croogo', 'Body'),]);
        echo $this->Form->input('class', ['label' => __d('croogo', 'Class')]);
        echo $this->Form->input('element', ['label' => __d('croogo', 'Element')]);
    echo $this->Html->tabEnd();

    echo $this->Html->tabStart('block-access');
        echo $this->Form->input('Role.Role', ['label' => __d('croogo', 'Role'),]);
    echo $this->Html->tabEnd();

    echo $this->Html->tabStart('block-visibilities');
        echo $this->Form->input('Block.visibility_paths', [
            'label' => __d('croogo', 'Visibility Paths'),
            'help' => __d('croogo', 'Enter one URL per line. Leave blank if you want this Block to appear in all pages.')
        ]);
    echo $this->Html->tabEnd();

    echo $this->Html->tabStart('block-params');
        echo $this->Form->input('Block.params', [
            'label' => __d('croogo', 'Params'),
        ]);
    echo $this->Html->tabEnd();

    echo $this->Croogo->adminTabs();
$this->end();

$this->append('panels');
    echo $this->Html->beginBox(__d('croogo', 'Publishing'));
        echo $this->Html->div('btn-group');
            echo $this->Form->button(__d('croogo', 'Apply'), ['name' => 'apply']);
            echo $this->Form->button(__d('croogo', 'Save'), ['button' => 'success']);
            echo $this->Html->link(__d('croogo', 'Cancel'), ['action' => 'index'], ['button' => 'danger']);
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Form->input('status', [
            'type' => 'radio',
            'legend' => false,
            'default' => CroogoStatus::UNPUBLISHED,
            'options' => $this->Croogo->statuses(),
            'class' => '',
            'label' => false,
            'before' => '<div class=\'radio\'><label>',
            'separator' => '</label></div><div class=\'radio\'><label>',
            'after' => '</label></div>'
        ]);

        echo $this->Form->input('show_title', [
            'label' => false,
            'class' => '',
            'before' => '<div class=\'checkbox\'><label>',
            'after' => __d('croogo', 'Show title ?') . '</label></div>'
        ]);

        echo $this->Form->input('publish_start', [
            'label' => false,
            'tooltip' => false,
            'placeholder' => __d('croogo', 'Publish Start'),
            'type' => 'text',
            'class' => trim($inputClass . ' input-datetime'),
            'prepend' => true,
            'prependClass' => 'datetimepicker date',
            'addon' => $this->Html->icon('calendar'),
        ]);
        echo $this->Form->input('publish_end', [
            'label' => false,
            'placeholder' => __d('croogo', 'Publish End'),
            'tooltip' => false,
            'type' => 'text',
            'class' => trim($inputClass . ' input-datetime'),
            'prepend' => true,
            'prependClass' => 'datetimepicker date',
            'addon' => $this->Html->icon('calendar'),
        ]);

    echo $this->Html->endBox();

    echo $this->Croogo->adminBoxes();
$this->end();

$this->append('form-end', $this->Form->end());

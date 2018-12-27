
<?php
/**
 * @var ViewAnnotation $this
 * @var array $nodeTypes
 */
?>
<div class="box box-primary nodes filter">
    <div class="box-body">
            <?php echo $this->Form->create('Node', [
                'class' => 'form-inline',
                'url' => isset($url) ? $url : ['action' => 'index'],
                'inputDefaults' => [
                    'label' => false,
                ],
            ]);

            echo $this->Form->input('chooser', [
                'type' => 'hidden',
                'value' => isset($this->request->query['chooser']),
            ]);

            echo $this->Form->input('filter', [
                'title' => __d('croogo', 'Search'),
                'placeholder' => __d('croogo', 'Search...'),
                'tooltip' => false,
            ]);

            if (!isset($this->request->query['chooser'])){

                echo $this->Form->input('type', [
                    'class' => 'form-control',
                    'data-placeholder' => __d('croogo', 'Type'),
                    'options' => $nodeTypes,
                    'empty' => __d('croogo', 'Type'),
                ]);

                echo $this->Form->input('status', [
                    'class' => 'form-control',
                    'data-placeholder' => __d('croogo', 'Status'),
                    'options' => [
                        '1' => __d('croogo', 'Published'),
                        '0' => __d('croogo', 'Unpublished'),
                    ],
                    'empty' => __d('croogo', 'Status'),
                ]);

                echo $this->Form->input('promote', [
                    'class' => 'form-control',
                    'data-placeholder' => __d('croogo', 'Promoted'),
                    'data-allow-clear' => "true",
                    'options' => [
                        '1' => __d('croogo', 'Yes'),
                        '0' => __d('croogo', 'No'),
                    ],
                    'empty' => __d('croogo', 'Promoted'),
                ]);

            }

            echo $this->Form->button(__d('croogo', 'Filter'), ['type' => 'submit', 'button' => 'primary', 'id' => 'searchFilter']);

            echo $this->Form->end(); ?>
    </div>
</div>

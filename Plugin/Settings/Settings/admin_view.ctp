<?php /**
 * @var ViewIDE $this
 * @var array $setting
 */ ?>
<div class="row">
    <div class="col-md-8">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo __d('croogo', 'Setting'); ?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title=""
                            data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <?php
                $viewField = [
                    'id',
                    'key',
                    'value',
                    'description',
                    'input_type',
                    'weight',
                    'params',
                ];

                $out = "";
                foreach ($viewField as $field) {
                    $msgKey = Inflector::humanize($field);
                    $dt = $this->Html->tag('dt', __d('croogo', $msgKey));
                    $dd = $this->Html->tag('dd', $setting['Setting'][$field]);
                    $out .= $dt . $dd;
                }
                echo $this->Html->tag('dl', $out, [
                    'class' => 'dl-horizontal'
                ]);
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <?php
        echo $this->Html->beginBox(__d('croogo', 'Actions'));

        $btn = $this->Html->link(__d('croogo', 'Edit Setting'), ['action' => 'edit', $setting['Setting']['id']], ['class' => 'btn btn-success']);
        $btn .= $this->Croogo->adminRowAction(__d('croogo', 'Delete Setting'),
            ['action' => 'delete', $setting['Setting']['id']],
            ['class' => 'btn btn-danger'],
            __d('croogo', 'Are you sure you want to delete # %s?', $setting['Setting']['id'])
        );
        $btn .= $this->Html->link(__d('croogo', 'List Settings'), ['action' => 'index'], ['class' => 'btn btn-default']);
        $btn .= $this->Html->link(__d('croogo', 'New Setting'), ['action' => 'add'], ['class' => 'btn btn-default']);

        echo $this->Html->div('btn-group-vertical', $btn);
        echo $this->Html->endBox();

        ?>
    </div>
</div>







<?php
/**
 * @var ViewIDE $this
 * @var array $editFields
 */

if (empty($modelClass)) $modelClass = Inflector::singularize($this->name);
if (!isset($className)) $className = strtolower($this->name);

$what = isset($this->request->data[$modelClass]['id'])  //TODO найти в каких случаях это исполузуется
    ? __d('croogo', 'Edit')
    : __d('croogo', 'Add');

if (empty($title_for_layout)) $this->fetch('title', $what . ' ' . $modelClass); //TODO

$rowClass = $this->Theme->getCssClass('row');
$columnLeft = $this->Theme->getCssClass('columnLeft');
$columnRight = $this->Theme->getCssClass('columnRight');
$columnFull = $this->Theme->getCssClass('columnFull');

if ($pageHeading = trim($this->fetch('page-heading'))) {
    echo $pageHeading;
}

if ($actionsBlock = $this->fetch('actions')):
    echo $this->Html->div(
        $rowClass,
        $this->Html->div(
            "actions {$columnFull} btn-group margin-bottom",
            $actionsBlock
        )
    );
endif;

if ($contentBlock = trim($this->fetch('content'))):
    echo $contentBlock;
    return;
endif;

if ($formStart = trim($this->fetch('form-start'))):
    echo $formStart;
else:
    echo $this->Form->create($modelClass);
    if (isset($this->request->data[$modelClass]['id'])):
        echo $this->Form->input('id');
    endif;
endif;

$tabId = 'tabitem-' . Inflector::slug(strtolower($modelClass), '-'); ?>

    <div class="<?php echo $rowClass; ?>">
        <div class="<?php echo $columnLeft; ?>">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <?php
                    if ($tabHeading = $this->fetch('tab-heading')):
                        echo $tabHeading;
                    else:
                        echo $this->Croogo->adminTab(__d('croogo', $modelClass), "#$tabId");
                        echo $this->Croogo->adminTabs();
                    endif;
                    ?>
                </ul>

                <?php
                $tabContent = trim($this->fetch('tab-content'));
                if (!$tabContent):
                    $content = '';
                    foreach ($editFields as $field => $opts):
                        if (is_string($opts)) {
                            $field = $opts;
                            $opts = array(
                                'label' => false,
                                'tooltip' => ucfirst($field),
                            );
                        }
                        $content .= $this->Form->input($field, $opts);
                    endforeach;
                endif;

                if (empty($tabContent) && !empty($content)):
                    $tabContent = $this->Html->div('tab-pane', $content, [
                        'class' => 'tab-pane active',
                        'id' => $tabId,
                    ]);
                    $tabContent .= $this->Croogo->adminTabs();
                endif;
                echo $this->Html->div('tab-content', $tabContent); ?>
            </div>
        </div>
        <div class="<?php echo $columnRight; ?>">
            <?php
            if ($rightCol = $this->fetch('panels')):
                echo $rightCol;
            else:
                if ($buttonsBlock = $this->fetch('buttons')):
                    echo $buttonsBlock;
                else:
                    echo $this->Html->beginBox(__d('croogo', 'Publishing'));
                        echo $this->Html->div('btn-group');
                            echo $this->Form->button(__d('croogo', 'Save'), ['button' => 'primary']);
                            echo $this->Html->link(__d('croogo', 'Cancel'), ['action' => 'index'], ['button' => 'danger']);
                        echo $this->Html->useTag('tagend', 'div');
                    echo $this->Html->endBox();
                endif;
                echo $this->Croogo->adminBoxes();
            endif;
            ?>
        </div>
    </div>

<?php

if ($formEnd = trim($this->fetch('form-end'))):
    echo $formEnd;
else:
    echo $this->Form->end();
endif;

if ($pageFooter = trim($this->fetch('page-footer'))):
    echo $pageFooter;
endif;


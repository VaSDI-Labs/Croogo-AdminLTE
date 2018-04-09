<?php /** @var ViewIDE $this */

if (empty($modelClass)) $modelClass = Inflector::singularize($this->name);
if (!isset($className)) $className = strtolower($this->name);

$rowClass = $this->Theme->getCssClass('row');
$columnFull = $this->Theme->getCssClass('columnFull');
$tableClass = isset($tableClass) ? $tableClass : $this->Theme->getCssClass('tableClass');

$showActions = isset($showActions) ? $showActions : true;

if ($pageHeading = trim($this->fetch('page-heading'))):
    echo $pageHeading;
endif;
?>

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

    <div class="<?php echo $rowClass; ?>">
        <div class="<?php echo $columnFull; ?>">
            <?php if ($contentBlock = trim($this->fetch('content'))):
                echo $this->element('admin/search');
                echo $contentBlock;
            else:
                if ($mainBlock = trim($this->fetch('main'))): ?>
                    <div class="box box-primary">
                        <div class="box-body table-responsive no-padding">
                            <?php echo $mainBlock; ?>
                        </div>
                    </div>
                <?php endif;
            endif; ?>
        </div>
    </div>

<?php
if ($pageFooter = trim($this->fetch('page-footer'))):
    echo $pageFooter;
endif;

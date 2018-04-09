<?php
/**
 * @var ViewIDE $this
 * @var string $alias
 * @var array $dashboard
 */
?>
<div class="box box-primary box-<?php echo $alias; ?> dashboard-box <?php echo ($dashboard['collapsed']) ? "collapsed-box" : ""; ?>" id="<?php echo $alias ?>">
    <div class="box-header">
        <i class="fa fa-comments-o"></i>

        <h3 class="box-title"><?php echo $dashboard['title'] ?></h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-<?php echo ($dashboard['collapsed']) ? "plus" : "minus" ; ?>"></i></button>
        </div>
    </div>

    <div class="box-body">
        <?php echo $this->element($dashboard['element'], compact('alias', 'dashboard'), ['cache' => $dashboard['cache']]);?>
    </div>
</div>
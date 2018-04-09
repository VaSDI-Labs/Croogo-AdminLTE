<?php /** @var View $this */ ?>
<footer class="main-footer">
    <div class="pull-right hidden-xs"><b>Version</b> 2.4.3</div>
    <?php
    $link = $this->Html->link(
        __d('croogo', 'Croogo %s', strval(Configure::read('Croogo.version'))),
        'http://www.croogo.org'
    );
    echo $this->Html->tag('strong', __d('croogo', 'Powered by %s', $link)); ?>
</footer>

<?php /** @var ViewAnnotation $this */

$this->extend('/Common/admin_index');

$this->Html
    ->addCrumb('', '/admin', ['icon' => $this->Theme->getIcon('home')])
    ->addCrumb(__d('croogo', 'Extensions'), ['plugin' => 'extensions', 'controller' => 'extensions_plugins', 'action' => 'index'])
    ->addCrumb(__d('croogo', 'Themes'));

$this->start('actions');
    echo $this->Croogo->adminAction(__d('croogo', 'Upload'),
        ['action' => 'add'],
        ['button' => 'success']
    );
$this->end(); ?>


<div class="box box-solid box-success">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo __d('croogo', 'Current Theme'); ?></h3>
    </div>
    <div class="box-body">
        <div class="<?php echo $this->Theme->getCssClass('row'); ?>">
            <div class="<?php echo $this->Theme->getCssClass('columnRight'); ?>">
                <?php if (isset($currentTheme['screenshot'])):
                    if (!Configure::read('Site.theme')):
                        $file = $currentTheme['screenshot'];
                    else:
                        $file = '/theme/' . Configure::read('Site.theme') . '/img/' . $currentTheme['screenshot'];
                    endif;
                    echo $this->Html->link($this->Html->thumbnail($file), $file, ['escape' => false]);
                endif; ?>
            </div>
            <div class="<?php echo $this->Theme->getCssClass('columnLeft'); ?>">
                <h3><?php $author = isset($currentTheme['author']) ? $currentTheme['author'] : null;
                    if (isset($currentTheme['authorUrl']) && strlen($currentTheme['authorUrl']) > 0) {
                        $author = $this->Html->link($author, $currentTheme['authorUrl']);
                    }
                    echo $currentTheme['name'];
                    if (!empty($author)):
                        echo " " . __d('croogo', 'by') . ' ' . $author;
                    endif; ?></h3>
                <p class="description"><?php echo $currentTheme['description']; ?></p>
                <?php if (isset($currentTheme['regions'])): ?>
                    <p class="regions"><?php echo __d('croogo', 'Regions supported: ') . implode(', ', $currentTheme['regions']); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="box box-solid box-primary collapsed-box">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo __d('croogo', 'Available Themes'); ?></h3>
        <div class="box-tools">
            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"><i class="fa fa-plus"></i></button>
        </div>
    </div>
    <div class="box-body">
        <?php $hasAvailable = false;
        foreach ($themesData as $themeAlias => $theme):
            $isAdminOnly = (!isset($theme['adminOnly']) || $theme['adminOnly'] != 'true');
            $isDefault = !($themeAlias == 'default' && !Configure::read('Site.theme'));
            $display = $themeAlias != Configure::read('Site.theme') && $isAdminOnly && $isDefault;
            if (!$display) continue; ?>
            <div class="<?php echo $this->Theme->getCssClass('row'); ?>">
                <div class="<?php echo $this->Theme->getCssClass('columnRight'); ?>">
                    <?php if ($themeAlias == 'default') {
                        $imgUrl = $this->Html->thumbnail($theme['screenshot']);
                        echo $this->Html->link($imgUrl, $theme['screenshot'], [
                            'escape' => false,
                        ]);
                    } else {
                        if (!empty($theme['screenshot'])):
                            $file = '/theme/' . $themeAlias . '/img/' . $theme['screenshot'];
                            $imgUrl = $this->Html->thumbnail($file);
                            echo $this->Html->link($imgUrl, $file, [
                                'escape' => false,
                            ]);
                        endif;
                    } ?>
                </div>
                <div class="<?php echo $this->Theme->getCssClass('columnLeft'); ?>">
                    <?php
                    $author = isset($theme['author']) ? $theme['author'] : null;
                    if (isset($theme['authorUrl']) && strlen($theme['authorUrl']) > 0) {
                        $author = $this->Html->link($author, $theme['authorUrl']);
                    }

                    echo $this->Html->tag('h3', $theme['name'] . ' ' . __d('croogo', 'by') . ' ' . $author);
                    echo $this->Html->tag('p', $theme['description'], ['class' => 'description']);
                    if (isset($theme['regions'])):
                        echo $this->Html->tag('p', __d('croogo', 'Regions supported: ') . implode(', ', $theme['regions']), ['class' => 'regions']);
                    endif;
                    echo $this->Html->tag('div',
                        $this->Form->postLink(" " . __d('croogo', 'Activate'), [
                            'action' => 'activate',
                            $themeAlias,
                        ], [
                            'button' => 'success',
                            'icon' => $this->Theme->getIcon('power-on'),
                        ]) . $this->Form->postLink(" " . __d('croogo', 'Delete'), [
                            'action' => 'delete',
                            $themeAlias,
                        ], [
                            'button' => 'danger',
                            'escape' => true,
                            'escapeTitle' => false,
                            'icon' => $this->Theme->getIcon('delete'),
                        ], __d('croogo', 'Are you sure?')),
                        ['class' => 'btn-group']
                    ); ?>
                </div>
            </div>
            <?php $hasAvailable = true; endforeach; ?>

        <?php if (!$hasAvailable): ?>
            <div class="<?php echo $this->Theme->getCssClass('row'); ?>">
                <div class="<?php echo $this->Theme->getCssClass('columnFull'); ?>">
                    <p><?php echo __d('croogo', 'No available theme'); ?></p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

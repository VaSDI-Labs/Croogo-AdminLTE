<?php
/**
 * @var ViewIDE $this
 * @var array $posts
 */
?>
<ul class="products-list product-list-in-box">
    <?php foreach ($posts as $post): ?>
        <li class="item">
            <div class="product-img">
                <?php echo $this->Html->image('default-50x50.gif') ?>
            </div>
            <div class="product-info">
                <?php echo $this->Html->link($post['title'], $post['url'], ['target' => '_blank', 'class' => 'product-title']); ?>
                <!--<span class="product-description"><?php /*echo $post['body']; */?></span>-->
                <span class="product-description"><?php echo $this->Time->i18nFormat($post['date']); ?></span>
            </div>
        </li>
    <?php endforeach; ?>
</ul>

<?php /** @var ViewAnnotation $this */ ?>
<div class="row">
    <div class="col-sm-7">
        <p><?php echo $this->Paginator->counter([
                'format' => __d('croogo', 'Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
            ]); ?></p>
    </div>
    <div class="col-sm-5">
        <ul class="pagination pagination-sm no-margin pull-right">
            <?php
            echo $this->Paginator->first('««');
            echo $this->Paginator->prev('«');
            echo $this->Paginator->numbers(['class' => 'paginator-link']);
            echo $this->Paginator->next('»');
            echo $this->Paginator->last('»»');
            ?>
        </ul>
    </div>
</div>




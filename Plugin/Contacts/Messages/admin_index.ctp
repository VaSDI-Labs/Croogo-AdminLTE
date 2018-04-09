<?php
/**
 * @var ViewIDE $this
 * @var array $criteria
 * @var array $messages
 */

$script = <<<EOF

Admin.toggleRowSelection('.checkbox-toggle');

$(".messageOptions").click(function () {
        const action = $(this).data('action');
        $('#messageAction').val(action);
    });

$(".message-view").on("click", function() {
	var el= \$(this)
	var modal = \$('#message-modal');
	$('#message-modal')
		.find('.modal-header .modal-title').html(el.data("title")).end()
		.find('.modal-body').html('<pre>' + el.data('content') + '</pre>').end()
		.modal('toggle');
});
EOF;
$this->Js->buffer($script);

$this->Html
    ->addCrumb('', '/admin', ['icon' => $this->Theme->getIcon('home')])
    ->addCrumb(__d('croogo', 'Contacts'), ['controller' => 'contacts', 'action' => 'index'])
    ->addCrumb(__d('croogo', 'Messages'));

if (isset($criteria['Message.status'])) {
    if ($criteria['Message.status'] == '1') {
        $this->Html->addCrumb(__d('croogo', 'Read'));
        $this->viewVars['title_for_layout'] = __d('croogo', 'Messages: Read');
    } else {
        $this->Html->addCrumb(__d('croogo', 'Unread'));
        $this->viewVars['title_for_layout'] = __d('croogo', 'Messages: Unread');
    }
}
?>

<div class="row">
    <div class="col-md-3">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo __d('croogo', 'Filter') ?></h3>

                <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <?php echo $this->element('admin/messages_search'); ?>
            </div>
            <!-- /.box-body -->
        </div>

        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo __d('croogo', 'Labels') ?></h3>

                <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body no-padding">
                <ul class="nav nav-pills nav-stacked">
                    <?php $links = [[
                        'title' => __d('croogo', 'Unread'),
                        'url' => ['action' => 'index', '?' => ['status' => '0',],]
                    ], [
                        'title' => __d('croogo', 'Read'),
                        'url' => ['action' => 'index', '?' => ['status' => '1',],]
                    ]];
                    foreach ($links as $link) {
                        echo $this->Html->tag('li',
                            $this->Html->link($link['title'], $link['url'])
                        );
                    } ?>
                </ul>
            </div>
            <!-- /.box-body -->
        </div>

    </div>
    <div class="col-md-9">
        <div class="box box-primary">
            <?php echo $this->Form->create('Message', [
                'url' => [
                    'controller' => 'messages',
                    'action' => 'process',
                ],
            ]); ?>

            <div class="box-body no-padding">
                <div class="mailbox-controls">
                    <!-- Check all button -->
                    <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>

                    <?php echo $this->Form->input('Message.action', [
                        'type' => "hidden",
                        'id' => 'messageAction',
                    ]); ?>

                    <div class="btn-group">
                        <button type="submit" value="submit" class="btn btn-default btn-sm messageOptions"
                                data-action="read" title="<?php echo __d('croogo', 'Mark as read'); ?>"><i
                                    class="fa fa-envelope"></i></button>
                        <button type="submit" value="submit" class="btn btn-default btn-sm messageOptions"
                                data-action="unread" title="<?php echo __d('croogo', 'Mark as unread'); ?>"><i
                                    class="fa fa-envelope-o"></i></button>
                        <button type="submit" value="submit" class="btn btn-default btn-sm messageOptions"
                                data-action="delete" title="<?php echo __d('croogo', 'Delete'); ?>"><i
                                    class="fa fa-trash-o"></i></button>
                    </div>
                </div>

                <div class="table-responsive mailbox-messages">
                    <table class="table table-hover table-striped">
                        <tbody>
                        <?php
                        $rows = [];
                        foreach ($messages as $message) {
                            $actions = [];

                            $actions[] = $this->Croogo->adminRowAction('',
                                ['action' => 'edit', $message['Message']['id']],
                                ['icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('croogo', 'Edit this item')]
                            );
                            $actions[] = $this->Croogo->adminRowAction('',
                                '#Message' . $message['Message']['id'] . 'Id',
                                [
                                    'icon' => $this->Theme->getIcon('delete'),
                                    'class' => 'delete',
                                    'tooltip' => __d('croogo', 'Remove this item'),
                                    'rowAction' => 'delete',
                                ],
                                __d('croogo', 'Are you sure?')
                            );
                            $actions[] = $this->Croogo->adminRowActions($message['Message']['id']);

                            $actions = $this->Html->div('btn-group item-actions', implode(' ', $actions));

                            $rows[] = [
                                $this->Form->checkbox('Message.' . $message['Message']['id'] . '.id', ['class' => 'row-select iCheck']),
                                [$this->Html->link($message['Message']['name'], "javascript:;", [
                                    'class' => 'message-view',
                                    'data-target' => '#comment-modal',
                                    'data-title' => $message['Message']['title'],
                                    'data-content' => $message['Message']['body'],
                                ]), ['class' => 'mailbox-name']],
                                [$this->Html->tag('b', $message['Message']['title']) . " - " . $message['Message']['body'], [
                                    'class' => 'mailbox-subject'
                                ]],
                                [$this->Time->timeAgoInWords($message['Message']['created'], [
                                    'accuracy' => [
                                        'year' => 'year',
                                        'month' => 'month',
                                        'day' => 'day',
                                        'hour' => 'hour',
                                        'minute' => 'minute',
                                        'second' => 'second',
                                    ],
                                ]), [
                                    'class' => 'mailbox-date'
                                ]],
                                $actions,
                            ];
                        }
                        echo $this->Html->tableCells($rows); ?>
                        </tbody>
                    </table>
                    <!-- /.table -->
                </div>
                <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->

            <div class="box-footer no-padding">
                <div class="mailbox-controls">
                    <!-- Check all button -->
                    <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
                    <div class="btn-group">
                        <button type="submit" value="submit" class="btn btn-default btn-sm messageOptions"
                                data-action="read" title="<?php echo __d('croogo', 'Mark as read'); ?>"><i
                                    class="fa fa-envelope"></i></button>
                        <button type="submit" value="submit" class="btn btn-default btn-sm messageOptions"
                                data-action="unread" title="<?php echo __d('croogo', 'Mark as unread'); ?>"><i
                                    class="fa fa-envelope-o"></i></button>
                        <button type="submit" value="submit" class="btn btn-default btn-sm messageOptions"
                                data-action="delete" title="<?php echo __d('croogo', 'Delete'); ?>"><i
                                    class="fa fa-trash-o"></i></button>
                    </div>
                </div>
            </div>

            <?php echo $this->element('admin/modal', ['id' => 'message-modal', 'title' => __d('croogo', 'Message'),]); ?>


            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>

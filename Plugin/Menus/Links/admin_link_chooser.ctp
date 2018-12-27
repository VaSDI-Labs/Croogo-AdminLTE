
<?php
/**
 * @var ViewAnnotation $this
 * @var array $linkChoosers
 */

$rows = [];
foreach ($linkChoosers as $name => $chooser):
	$link = $this->Html->link('', $chooser['url'], [
		'icon' => $this->Theme->getIcon('search'),
		'iconSize' => 'small',
		'button' => ['default', 'small'],
		'class' => 'link chooser pull-right',
		'title' => __d('croogo', 'Link to %s', $name),
    ]);
	$title = $this->Html->tag('h5', $name . $link);
	$div = $this->Html->div('link_chooser', $title . $this->Html->tag('small', $chooser['description']));
	$rows[] = '<tr><td>' . $div . '</td></tr>';
endforeach;
?>
<table class="table table-striped table-hover">
	<?php echo implode(' ', $rows); ?>
</table>
<?php

$script =<<< EOF
$('.link.chooser').itemChooser({
	fields: [{ type: "Node", target: "#LinkLink", attr: "rel"}],
	modalPopup: "#link_choosers"
});
EOF;

echo $this->Html->scriptBlock($script);

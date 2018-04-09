<?php
/**
 * @var ViewIDE $this
 * @var array $types
 */

$this->Html
    ->addCrumb('', '/admin', ['icon' => $this->Theme->getIcon('home')])
	->addCrumb(__d('croogo', 'Content'), ['controller' => 'nodes', 'action' => 'index'])
	->addCrumb(__d('croogo', 'Create'));

?>
<div class="<?php echo $this->Theme->getCssClass('row'); ?>">
	<div class="<?php echo $this->Theme->getCssClass('columnFull'); ?>">
		<div class="box box-primary">
			<div class="box-body">
				<?php foreach ($types as $type): ?>
					<?php
						if (!empty($type['Type']['plugin'])):
							continue;
						endif;
					?>
					<div class="type">
						<h3><?php echo $this->Html->link($type['Type']['title'], ['action' => 'add', $type['Type']['alias']]); ?></h3>
						<p><?php echo $type['Type']['description']; ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>

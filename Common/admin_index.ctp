<?php /** @var ViewAnnotation $this */

echo $this->fetch('page-heading', "");

echo $this->CrudAdminIndex->actions();

echo $this->fetch('search', $this->element('admin/search'));

if ($contentBlock = trim($this->fetch('content'))):
	echo $this->fetch('search', $this->element('admin/search'));
	echo $contentBlock;
else: ?>
	<div class="box box-primary">
		<div
			class="box-body<?php echo (($this->exists('table-heading') || isset($displayFields)) && !$this->exists('main')) ? " table-responsive no-padding" : ""; ?>">
			<?php
			echo $this->fetch('form-start', "");

			$tableContent = $this->fetch('table-heading', $this->CrudAdminIndex->tableHeading());
			$tableContent .= $this->fetch('table-body', $this->CrudAdminIndex->tableBody());
			$tableContent .= $this->fetch('table-footer', $this->CrudAdminIndex->tableFooter());

			$tableContent = $this->Html->tag('table', $tableContent, [
				'class' => isset($tableClass) ? $tableClass : $this->Theme->getCssClass('tableClass')
			]);
			echo $this->fetch('main', $tableContent);

			if ($bulkAction = trim($this->fetch('bulk-action'))) {
				echo $this->Html->div('', $bulkAction, ['id' => "bulk-action"]);
			}

			echo $this->fetch('form-end', "");
			?>
		</div>
		<?php
		$pagingBlockDefault = "";
		if (isset($this->Paginator) && isset($this->request['paging'])) {
			$pagingBlockDefault = $this->element('admin/pagination');
		}
		$pagingBlock = $this->fetch('paging', $pagingBlockDefault);
		echo $this->Html->div('box-footer clearfix', $pagingBlock);
		?>
	</div>
<?php endif;

echo $this->fetch('page-footer', "");

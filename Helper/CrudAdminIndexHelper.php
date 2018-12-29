<?php
App::uses('AppHelper', 'View/Helper');

/**
 * Class CrudAdminIndex
 *
 * @property \HtmlHelper $Html
 * @property \ThemeHelper $Theme
 * @property \CroogoHelper $Croogo
 * @property \PaginatorHelper $Paginator
 * @property \LayoutHelper|\AdminLTELayoutHelper $Layout
 */
class CrudAdminIndexHelper extends AppHelper
{

	public $helpers = [
		'Html',
		'Croogo.Theme',
		'Croogo.Croogo',
		'Paginator',
		'Croogo.Layout' => ['className' => 'AdminLTELayout'],
	];

	protected $i18nDomain = 'croogo';

	protected $modelClass = null;

	protected $displayFields = [];
	protected $displayList = [];

	public function __construct(\View $View, array $settings = array())
	{
		parent::__construct($View, $settings);
		if ($this->request->params['plugin']) {
			$this->i18nDomain = $this->request->params['plugin'];
		}
		$this->modelClass = $this->_View->get('modelClass', Inflector::singularize($this->_View->name));
		$this->displayFields = $this->_View->get('displayFields', []);
		$this->displayList = $this->_View->get(strtolower($this->_View->name));
	}

	public function actions()
	{
		$showActions = $this->_View->get('showActions', true);
		if ($showActions) {
			$rowClass = $this->Theme->getCssClass('row');
			$columnFull = $this->Theme->getCssClass('columnFull');
			$humanName = Inflector::humanize(Inflector::underscore($this->modelClass));

			$actionsBlock = $this->fetch('actions', $this->Croogo->adminAction(
				__d('croogo', 'New %s', __d($this->i18nDomain, $humanName)),
				['action' => 'add'],
				['button' => 'success']
			));
			return $this->Html->div($rowClass, $this->Html->div("actions {$columnFull} btn-group margin-bottom", $actionsBlock));
		}
		return "";
	}

	public function tableHeading()
	{
		$defaultTableHeading = "";
		if (!empty($this->displayFields)) {
			$tableHeaders = [];
			foreach ($this->displayFields as $field => $arr) {
				$label = __d($this->i18nDomain, $arr['label']);
				$tableHeaders[] = $arr['sort'] ? $this->Paginator->sort($field, $label, ['class' => 'paginator-link']) : $label;
			}
			$tableHeaders[] = __d('croogo', 'Actions');
			$defaultTableHeading = $this->Html->tableHeaders($tableHeaders);
			$defaultTableHeading = $this->Html->tag('thead', $defaultTableHeading);
		}
		return $defaultTableHeading;
	}

	public function tableBody()
	{
		$defaultTableBody = "";
		if (!empty($this->displayFields) && !empty($this->displayList)) {
			$rows = [];

			foreach ($this->displayList as $item) {
				$row = [];

				foreach ($this->displayFields as $key => $val) {
					extract($val);
					if (!is_int($key)) {
						$val = $key;
					}
					if (strpos($val, '.') === false) {
						$val = $this->modelClass . '.' . $val;
					}
					list($model, $field) = pluginSplit($val);
					$row[] = $this->Layout->displayField($item, $model, $field, compact('type', 'url', 'options'));
				}
				$row[] = $this->Html->div('btn-group item-actions', implode(' ', $this->tableActions($item)));
				$rows[] = $row;
			}
			$defaultTableBody = $this->Html->tableCells($rows);
		}
		return $defaultTableBody;
	}

	public function tableFooter()
	{
		return "";
	}

	protected function tableActions($item)
	{
		$actions = [];

		if (isset($this->_View->request->query['chooser'])) {
			$actions[] = $this->Croogo->adminRowAction(__d('croogo', 'Choose'), '#', [
				'class' => 'item-choose',
				'data-chooser_type' => $this->modelClass,
				'data-chooser_id' => $item[$this->modelClass]['id'],
			]);
		} else {
			$actions[] = $this->Croogo->adminRowAction('',
				['action' => 'edit', $item[$this->modelClass]['id']],
				['icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('croogo', 'Edit this item')]
			);

			$actions[] = $this->Croogo->adminRowActions($item[$this->modelClass]['id']);

			$actions[] = $this->Croogo->adminRowAction('',
				['action' => 'delete', $item[$this->modelClass]['id'],],
				['icon' => $this->Theme->getIcon('delete'), 'tooltip' => __d('croogo', 'Remove this item')],
				__d('croogo', 'Are you sure?')
			);
		}
		return $actions;
	}

	protected function fetch($fetchBlock, $default = "")
	{
		return trim($this->_View->fetch($fetchBlock, $default));
	}


}

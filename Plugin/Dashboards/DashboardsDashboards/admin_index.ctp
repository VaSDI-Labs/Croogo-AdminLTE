
<?php
/**
 * @var ViewAnnotation $this
 * @var array $dashboards
 */

$this->viewVars['title_for_layout'] = __d('croogo', 'Dashboards');
$this->extend('/Common/admin_index');

$this->Html
	->addCrumb('', '/admin', ['icon' => 'home'])
	->addCrumb(__d('croogo', 'Dashboards'));

$this->set('showActions', false);

$this->append('table-heading');
	$tableHeaders = $this->Html->tableHeaders([
		$this->Paginator->sort('id'),
		$this->Paginator->sort('alias'),
		$this->Paginator->sort('column'),
		$this->Paginator->sort('collapsed'),
		$this->Paginator->sort('status'),
		$this->Paginator->sort('updated'),
		$this->Paginator->sort('created'),
		__d('croogo', 'Actions'),
    ]);
	echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->append('table-body');
    $rows = [];
    foreach ($dashboards as $dashboard){
        $actions = [];
        $actions[] = $this->Croogo->adminRowAction('',
            ['controller' => 'dashboards_dashboards', 'action' => 'moveup', $dashboard['DashboardsDashboard']['id']],
            ['icon' => $this->Theme->getIcon('move-up'), 'tooltip' => __d('croogo', 'Move up')]
        );
        $actions[] = $this->Croogo->adminRowAction('',
            ['controller' => 'dashboards_dashboards', 'action' => 'movedown', $dashboard['DashboardsDashboard']['id']],
            ['icon' => $this->Theme->getIcon('move-down'), 'tooltip' => __d('croogo', 'Move down')]
        );
        $actions[] = $this->Croogo->adminRowAction('',
            ['action' => 'delete', $dashboard['DashboardsDashboard']['id']],
            ['icon' => $this->Theme->getIcon('delete'), 'escape' => true],
            __d('croogo', 'Are you sure you want to delete # %s?', $dashboard['DashboardsDashboard']['id'])
        );

        $rows[] = [
            h($dashboard['DashboardsDashboard']['id']),
            h($dashboard['DashboardsDashboard']['alias']),
            $this->Dashboards->columnName($dashboard['DashboardsDashboard']['column']),
            $dashboard['DashboardsDashboard']['collapsed']
                ? $this->Layout->status($dashboard['DashboardsDashboard']['collapsed'])
                : "",
            $this->element('admin/toggle', [
                'id' => $dashboard['DashboardsDashboard']['id'],
                'status' => (int)$dashboard['DashboardsDashboard']['status'],
            ]),
            h($dashboard['DashboardsDashboard']['updated']),
            h($dashboard['DashboardsDashboard']['created']),
            $this->Html->div('btn-group item-actions', implode(' ', $actions)),
        ];
    }
    echo $this->Html->tableCells($rows);
$this->end();

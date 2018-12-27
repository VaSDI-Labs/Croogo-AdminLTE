
<?php /** @var ViewAnnotation $this */

$this->Croogo->adminScript('Dashboards.admin');

$this->Html
	->addCrumb('', '/admin', ['icon' => $this->Theme->getIcon('home')])
	->addCrumb(__d('croogo', 'Dashboard'));

echo $this->Dashboards->dashboards();

$this->Js->buffer('Dashboard.init();');
?>
<div id="dashboard-url" class="hidden"><?php echo $this->Html->url(['action' => 'save']);?></div>

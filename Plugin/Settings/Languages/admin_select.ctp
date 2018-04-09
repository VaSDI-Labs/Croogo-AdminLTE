<?php /**
 * @var ViewIDE $this
 * @var array $languages
 * @var integer $id
 * @var string $modelAlias
 */

$this->extend('/Common/admin_index');

$this->Html
	->addCrumb($this->Html->icon('home'), '/admin')
	->addCrumb(__d('croogo', 'Settings'), ['plugin' => 'settings', 'controller' => 'settings', 'action' => 'index'])
	->addCrumb(__d('croogo', 'Languages'), ['plugin' => 'settings', 'controller' => 'languages', 'action' => 'index']);

$this->append('actions');
	echo $this->Html->link(__d('croogo', 'New Language'), ['action' => 'add'], ['button' => 'success']);
$this->end();

$this->append('main');
	$html = "";
	foreach ($languages as $language){
		$title = $language['Language']['title'] . ' (' . $language['Language']['native'] . ')';
		$link = $this->Html->link($title, [
			'plugin' => 'translate',
			'controller' => 'translate',
			'action' => 'edit',
			$id,
			$modelAlias,
			'locale' => $language['Language']['alias'],
        ]);
		$html .= $this->Html->tag('li', $link);
    }
    echo $this->Html->tag('ul', $html, [
        'class' => 'list-unstyled'
    ]);
$this->end();
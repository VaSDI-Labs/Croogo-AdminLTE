<?php /** @var ViewIDE $this */

$this->extend('/Common/admin_index');
$this->Html
    ->addCrumb('', '/admin', ['icon' => $this->Theme->getIcon('home')])
    ->addCrumb('Example');


$this->start('actions');
    echo $this->Croogo->adminAction(
        'New Tab',
        ['action' => 'add'],
        ['button' => 'success']
    );
    echo $this->Croogo->adminAction(
        'Chooser Example',
        ['action' => 'chooser']
    );
$this->end();

echo $this->Html->para('', 'content here');
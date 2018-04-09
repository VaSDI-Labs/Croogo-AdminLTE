<?php /** @var ViewIDE $this */

$this->extend('/Common/admin_edit');
$this->Html
    ->addCrumb('', '/admin', ['icon' => $this->Theme->getIcon('home')])
    ->addCrumb('Example');


echo $this->Html->para('', 'Here you are..');



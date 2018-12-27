<?php
/**
 * @var ViewAnnotation $this
 * @var mixed $success
 * @var mixed $permitted
 * @var string|integer $acoId
 * @var string|integer $aroId
 */

if ($success == 1) {
	if ($permitted == 1) {
		echo $this->Html->icon($this->Theme->getIcon('check-mark'), [
			'class' => 'permission-toggle text-green',
			'data-aco_id' => $acoId,
			'data-aro_id' => $aroId
        ]);
	} else {
		echo $this->Html->icon($this->Theme->getIcon('x-mark'), [
			'class' => 'permission-toggle text-red',
			'data-aco_id' => $acoId,
			'data-aro_id' => $aroId
        ]);
	}
} else {
	echo __d('croogo', 'error');
}

Configure::write('debug', 0);

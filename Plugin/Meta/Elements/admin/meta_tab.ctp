<?php /** @var ViewIDE $this */ ?>

<div id="meta-fields"><?php
	if (!empty($this->request->data['Meta'])) {
		$fields = Hash::combine($this->request->data['Meta'], '{n}.key', '{n}.value');
		$fieldsKeyToId = Hash::combine($this->request->data['Meta'], '{n}.key', '{n}.id');
	} else {
		$fields = $fieldsKeyToId = array();
	}
	if (count($fields) > 0) {
		foreach ($fields as $fieldKey => $fieldValue) {
			echo $this->Meta->field($fieldKey, $fieldValue, $fieldsKeyToId[$fieldKey]);
		}
	}
?></div>
<?php

echo $this->Html->link(__d('croogo', 'Add another field'),
	['plugin' => 'meta', 'controller' => 'meta', 'action' => 'add_meta'],
	['class' => 'btn-block add-meta', 'button' => 'default']
);

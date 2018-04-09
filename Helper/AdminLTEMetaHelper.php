<?php
App::uses('MetaHelper', 'Meta.View/Helper');
/**
 * Created by PhpStorm.
 * User: VaDiM
 * Date: 01.04.2018
 * Time: 23:29
 *
 * @property LayoutHelper $Layout
 * @property ThemeHelper $Theme
 * @property FormHelper $Form
 * @property HtmlHelper $Html
 */
class AdminLTEMetaHelper extends MetaHelper {

    public $helpers = [
        'Croogo.Theme',
        'Html',
        'Form',
    ];

    public function field($key = '', $value = null, $id = null, $options = array()) {
        $inputClass = $this->Theme->getCssClass('formInput');
        $inputClassDiv = $this->Theme->getCssClass('formInputDiv');
        $_options = [
            'key' => [
                'label' => false,
                'placeholder' => __d('croogo', 'Key'),
                'value' => $key,
                'tooltip' => false,
            ],
            'value' => [
                'label' => false,
                'tooltip' => false,
                'placeholder' => __d('croogo', 'Value'),
                'value' => $value,
                'type' => 'textarea',
                'rows' => 2,
            ],
        ];
        if ($inputClass) {
            $_options['key']['class'] = $_options['value']['class'] = $inputClass;
        }
        if ($inputClassDiv) {
            $_options['key']['div']['class'] = $_options['value']['div']['class'] = $inputClassDiv;
        }
        $options = Hash::merge($_options, $options);
        $uuid = CakeText::uuid();

        $fields = '';
        if ($id != null) {
            $fields .= $this->Form->input('Meta.' . $uuid . '.id', ['type' => 'hidden', 'value' => $id]);
            $this->Form->unlockField('Meta.' . $uuid . '.id');
        }
        $fields .= $this->Form->input('Meta.' . $uuid . '.key', $options['key']);
        $fields .= $this->Form->input('Meta.' . $uuid . '.value', $options['value']);
        $this->Form->unlockField('Meta.' . $uuid . '.key');
        $this->Form->unlockField('Meta.' . $uuid . '.value');
        $fields = $this->Html->tag('div', $fields, ['class' => 'fields']);

        $id = is_null($id) ? $uuid : $id;
        $deleteUrl = $this->settings['deleteUrl'];
        $deleteUrl[] = $id;
        $actions = $this->Html->link(
            __d('croogo', 'Remove'),
            $deleteUrl,
            ['button' => 'danger' , 'class' => 'btn-block remove-meta', 'rel' => $id]
        );
        $actions = $this->Html->tag('div', $actions, ['class' => 'actions']);

        $output = $this->Html->tag('div', $fields . $actions . $this->Html->tag('hr') , ['class' => 'meta']);
        return $output;
    }


}
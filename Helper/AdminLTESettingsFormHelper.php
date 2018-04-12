<?php
App::uses('SettingsFormHelper', 'Settings.View/Helper');

/**
 * Created by PhpStorm.
 * User: VaDiM
 * Date: 07.02.2018
 * Time: 23:51
 * @property AdminLTEFormHelper $Form
 * @property AdminLTEHtmlHelper $Html
 */
class AdminLTESettingsFormHelper extends SettingsFormHelper {

    public $helpers = [
        'Form' => ['className' => 'AdminLTEForm'],
        'Html' => ['className' => 'AdminLTEHtml'],
    ];

    protected function _inputCheckbox($setting, $label, $i) {
        if ($setting['Setting']['value'] == 1) {
            $output = $this->Form->input("Setting.$i.value", [
                'type' => $setting['Setting']['input_type'],
                'checked' => 'checked',
                'label' => false,
                'before' => '<div class=\'checkbox\'><label>',
                'after' => $label . '</label></div>'
            ]);
        } else {
            $output = $this->Form->input("Setting.$i.value", [
                'type' => $setting['Setting']['input_type'],
                'label' => false,
                'before' => '<div class=\'checkbox\'><label>',
                'after' => $label . '</label></div>'
            ]);
        }
        return $output;
    }

    public function input($setting, $label, $i) {
        $inputType = ($setting['Setting']['input_type'] != null) ? $setting['Setting']['input_type'] : 'text';
        if($setting['Setting']['input_type'] == 'multiple'){
            $multiple = true;
            if (isset($setting['Params']['multiple'])) {
                $multiple = $setting['Params']['multiple'];
            }
            $selected = json_decode($setting['Setting']['value']);
            $selected = empty($selected) ? [] : $selected;
            $options = json_decode($setting['Params']['options'], true);

            if($multiple == "checkbox"){
                $out = $this->Form->label("Setting.$i.values", $setting['Setting']['title']);
                $out .= $this->Form->input("Setting.$i.values", ['type' => 'hidden']);

                foreach ($options as $option => $label){
                    $labelWrapper = $this->Html->tag('label', $this->Form->checkbox("Setting.$i.values.", [
                            'checked' => in_array($option, $selected) ? 'checked' : null,
                            'value' => $option,
                            'hiddenField' => false,
                        ]) . $label);
                    $out .= $this->Html->div('checkbox', $labelWrapper);
                }

                $output = $this->Html->div('form-group', $out);
            } else {
                $output = $this->Form->input("Setting.$i.values", [
                    'label' => $setting['Setting']['title'],
                    'multiple' => $multiple,
                    'options' => $options,
                    'selected' => $selected,
                ]);
            }
        } elseif ($setting['Setting']['input_type'] == 'checkbox'){
            $output = $this->_inputCheckbox($setting, $label, $i);
        } elseif ($setting['Setting']['input_type'] == 'radio'){
            $value = $setting['Setting']['value'];
            $options = json_decode($setting['Params']['options'], true);
            $output = $this->Form->input("Setting.$i.value", [
                'legend' => false,
                'type' => 'radio',
                'options' => $options,
                'value' => $value,
                'label' => false,
                'before' => $this->Form->label('', $setting['Setting']['title']) . '<div class=\'radio\'><label>',
                'separator' => '</label></div><div class=\'radio\'><label>',
                'after' => '</label></div>'
            ]);
        } else {
            $output = $this->Form->input("Setting.$i.value", [
                'type' => $inputType,
                'value' => $setting['Setting']['value'],
                'help' => $setting['Setting']['description'],
                'label' => $label,
            ]);
        }
        return $output;
    }


}
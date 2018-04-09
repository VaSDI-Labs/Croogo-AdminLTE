<?php
App::uses('CroogoFormHelper', 'Croogo.View/Helper');

/**
 * @property ThemeHelper $Theme
 */
class AdminLTEFormHelper extends CroogoFormHelper {

    protected function _parseOptionsAddon($options) {
        if (isset($options['append'])) {
            $this->_addon = 'input-append';
        }
        if (isset($options['prepend'])) {
            $this->_addon = 'input-prepend';
        }

        if (isset($this->_addon)) {
            $inputGroupClass = isset($options['prependClass']) ? "input-group {$options['prependClass']}" : "input-group";

            if (isset($options['append'])) {
                $options['between'] = "<div class='{$inputGroupClass}'>";

                if(isset($options['addonBtn'])){
                    $options['after'] = '<div class="input-group-btn">' . $options['addonBtn'] . '</div></div>';
                } elseif (isset($options['addon'])) {
                    $options['after'] = '<div class="input-group-addon">' . $options['addon'] . '</div></div>';
                }

            }
            if (isset($options['prepend'])) {
                if(isset($options['addonBtn'])){
                    $options['between'] = "<div class='{$inputGroupClass}'><div class='input-group-btn'>" . $options['addonBtn'] . "</div>";
                } elseif (isset($options['addon'])) {
                    $options['between'] = "<div class='{$inputGroupClass}'><div class='input-group-addon'>" . $options['addon'] . "</div>";
                }
                $options['after'] = '</div>';
            }
        }

        unset($options['append'], $options['prepend'], $options['addon'], $options['addonBtn'], $options['prependClass']);

        return $options;
    }

    protected function _helpText($options) {
        $helpClass = isset($options['helpInline']) ? 'help-inline' : 'help-block';
        $helpText = $this->Html->tag('p', $options['help'], ['class' => $helpClass,]);
        $options['after'] = isset($options['after']) ? $options['after'] . $helpText : $helpText;
        unset($options['help'], $options['helpInline']);
        return $options;
    }

    public function input($fieldName, $options = array()) {
        if (!$this->_isEditable($fieldName)) {
            return null;
        }
        $options = $this->_placeholderOptions($fieldName, $options);

        // Automatic tooltip when label is 'false'. Leftover from 1.5.0.
        //
        // TODO:
        // Remove this behavior in 1.6.x, ie: tooltip needs to be implicitly
        // requested by caller.
        if (empty($options['title']) && empty($options['label']) && !empty($options['placeholder']) && !isset($options['tooltip'])) {
            $options['tooltip'] = $options['placeholder'];
        }

        if (!empty($options['help'])) {
            $options = $this->_helpText($options);
        }

        if (array_key_exists('tooltip', $options)) {
            $options = $this->_tooltip($options);
        }

        return parent::input($fieldName, $options);
    }
}

<?php
App::uses('LayoutHelper', 'Croogo.View/Helper');

/**
 * Created by PhpStorm.
 * User: VaDiM
 * Date: 20.02.2018
 * Time: 0:11
 *
 * @property \ViewAnnotation $_View
 * @property ThemeHelper $Theme
 * @property AdminLTEHtmlHelper $Html
 */
class AdminLTELayoutHelper extends LayoutHelper {


    public function status($value) {
        $icons = $this->Theme->settings('icons');
        if (empty($icons)) {
            $icons = array('check-mark' => 'ok', 'x-mark' => 'remove');
        }
        if ($value == 1) {
            $icon = $icons['check-mark'];
            $class = 'text-green';
        } else {
            $icon = $icons['x-mark'];
            $class = 'text-red';
        }
        if (method_exists($this->Html, 'icon')) {
            return $this->Html->icon($icon, compact('class'));
        } else {
            if (empty($this->_View->CroogoHtml)) {
                $this->_View->Helpers->load('Croogo.CroogoHtml');
            }
            return $this->_View->CroogoHtml->icon($icon, compact('class'));
        }
    }


}

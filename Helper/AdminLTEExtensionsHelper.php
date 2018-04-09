<?php
App::uses('AppHelper', 'View/Helper');

/**
 * Created by PhpStorm.
 * User: VaDiM
 * Date: 15.02.2018
 * Time: 12:25
 *
 * @property AdminLTEHtmlHelper $Html
 * @property ThemeHelper $Theme
 */
class AdminLTEExtensionsHelper extends AppHelper {

    public $helpers = [
        'Form' => ['className' => 'AdminLTEForm'],
        'Html' => ['className' => 'AdminLTEHtml'],
        'Croogo.Theme',
    ];

}
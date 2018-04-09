<?php
App::uses('AppHelper', 'View/Helper');

/**
 * Class CustomHelper
 *
 * @property ViewIDE $_View
 */
class CustomHelper extends AppHelper {

    public function __construct(View $View, array $settings = array()) {
        parent::__construct($View, $settings);

        if(CakePlugin::loaded('Dashboards') && isset($this->request->params['admin'])){
            $this->_View->Helpers->unload('Dashboards');
            $this->_View->Dashboards = $this->_View->loadHelper('Dashboards', ['className' => 'AdminLTEDashboards']);;
        }
    }


}
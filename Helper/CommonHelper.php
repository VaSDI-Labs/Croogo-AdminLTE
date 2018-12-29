<?php
App::uses('AppHelper', 'View/Helper');

/**
 * Created by PhpStorm.
 * User: VaDiM
 * Date: 02.03.2018
 * Time: 23:11
 *
 * @property AdminLTEHtmlHelper $Html
 * @property ThemeHelper $Theme
 * @property AdminLTECroogoHelper $Croogo
 * @property \ViewAnnotation $_View
 * @property PaginatorHelper $Paginator
 * @property LayoutHelper $Layout
 */
class CommonHelper extends AppHelper {

    public $helpers = [
        'Html' => [
            'className' => 'AdminLTEHtml'
        ],
        'Form' => [
            'className' => 'AdminLTEForm'
        ],
        'Paginator',
        'Theme',
        'Layout',
        'Croogo' => [
            'className' => 'AdminLTECroogo'
        ]
    ];

    protected $_currentLocale = "";

    protected $_modelClass = "";

    protected $_mapComponent = [
        'select2' => [
            'css' => '/libs/select2/css/select2.min',
            'js' => '/libs/select2/js/select2.full.min',
            'i18n' => '/libs/select2/js/i18n/',
        ],
        'tippyjs' => [
            //'css' => '/libs/tippyjs/css/tippy.css',
            'js' => '/libs/tippyjs/js/tippy.all.min',
        ],
        'slugify' => [
            'js' => [
                '/libs/slugify/js/speakingurl.min',
                '/libs/slugify/js/slugify.min'
            ]
        ],
        'jquery-cookie' => [
            'js' => '/libs/jquery-cookie/jquery.cookie',
        ],
        'underscore' => [
            'js' => '/libs/underscore/underscore.min',
        ],
        'iCheck' => [
            'css' => '/plugins/iCheck/flat/blue',
            'js' => '/plugins/iCheck/icheck.min',
        ],
        'bootstrap-datepicker' => [
            'css' => '/libs/bootstrap-datepicker/css/bootstrap-datepicker.min',
            'js' => '/libs/bootstrap-datepicker/js/bootstrap-datepicker.min',
        ],
    ];

    protected $_defaultComponent = [
        'select2', 'tippyjs', 'slugify', 'underscore', 'jquery-cookie', 'iCheck', 'bootstrap-datepicker', 'thickbox'
    ];

    protected $_mapLocale = [
        'rus' => 'ru',
        'end' => 'en',
    ];

    public function __construct(View $View, array $settings = array()) {
        parent::__construct($View, $settings);

        $this->_currentLocale = Configure::read('Site.locale');

        $this->_modelClass = Inflector::singularize($this->_View->name);

        $this->addBowerComponent();
    }


    public function addBowerComponent($componentNames = []) {
        $componentNames = empty($componentNames) ? $this->_defaultComponent : $componentNames;

        list($css, $js) = $this->getResourceComponet($componentNames);

        /*$this->Html->css($css, ['block' => 'bowerComponentCss']);
        $this->Html->script($js, ['block' => 'bowerComponentJs']);*/
    }

    private function getResourceComponet($componentNames){
        $css = [];
        $js = [];
        foreach ($componentNames as $componentName){
            if(isset($this->_mapComponent[$componentName]['css'])){
                $css[] = $this->_mapComponent[$componentName]['css'];
            }
            if(isset($this->_mapComponent[$componentName]['js'])){

                $js[] = $this->_mapComponent[$componentName]['js'];
                if(isset($this->_mapLocale[$this->_currentLocale]) && isset($this->_mapComponent[$componentName]['i18n'])){
                    $js[] = $this->_mapComponent[$componentName]['i18n'] . $this->_mapLocale[$this->_currentLocale];
                }
            }
        }
        return [$css, $js];
    }

}

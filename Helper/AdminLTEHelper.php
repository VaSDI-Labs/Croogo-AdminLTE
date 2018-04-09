<?php
App::uses('AppHelper', 'View/Helper');

/**
 * @property AdminLTEHtmlHelper $Html
 * @property AdminLTECroogoHelper $Croogo
 * @property ThemeHelper $Theme
 * @property View $_View
 */
class AdminLTEHelper extends AppHelper {

    public $helpers = [
        'Html' => ['className' => 'AdminLTEHtml'],
        'Croogo.Croogo' => ['className' => 'AdminLTECroogo'],
        'Croogo.Theme',
    ];

    protected $_baseRowActions = [];
    protected $_controller = null;

    protected $_mapIcon = [];
    protected $_mapTooltip = [];

    public function __construct(View $View, array $settings = []) {
        parent::__construct($View, $settings);

        $this->_controller = $this->_View->request->params['controller'];

        $this->initRowActions();
    }

    public function getRowActions(array $rowActions = [], array $data = []) {
        $html = "";

        foreach ($rowActions as $rowAction) {
            switch ($rowAction) {
                case "delete":
                    $html .= $this->Croogo->adminRowAction('',
                        ['controller' => $this->_controller, 'action' => 'delete', $data['id']],
                        ['icon' => $this->Theme->getIcon($this->_mapIcon['delete']), 'tooltip' => $this->_mapTooltip['delete']],
                        __d('croogo', 'Are you sure?')
                    );
                    break;
                case "all_id":
                    $html .= $this->Croogo->adminRowActions($data['id']);
                    break;
                default:
                    $html .= $this->Croogo->adminRowAction('',
                        ['controller' => $this->_controller, 'action' => $rowAction, $data['id']],
                        ['icon' => $this->Theme->getIcon($this->_mapIcon[$rowAction]), 'tooltip' => $this->_mapTooltip[$rowAction]]
                    );
                    break;
            }

        }

        return $this->Html->div('btn-group actions', $html);
    }

    protected function initRowActions() {
        $this->_mapTooltip = [
            'moveup' => __d('croogo', 'Move up'),
            'movedown' => __d('croogo', 'Move down'),
            'edit' => __d('croogo', 'Edit this item'),
            'delete' => __d('croogo', 'Remove this item'),
        ];
        $this->_mapIcon = [
            'moveup' => 'move-up',
            'movedown' => 'move-down',
            'edit' => 'update',
            'delete' => 'delete',
        ];

    }


}

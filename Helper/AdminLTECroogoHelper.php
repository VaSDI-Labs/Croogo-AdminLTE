<?php
App::uses('CroogoHelper', 'Croogo.View/Helper');

/**
 * Created by PhpStorm.
 * User: VaDiM
 * Date: 12.01.2018
 * Time: 16:13
 *
 * @property AdminLTEHtmlHelper $Html
 * @property AdminLTEFormHelper $Form
 */
class AdminLTECroogoHelper extends CroogoHelper {

    protected $_firstShow = false;

    public function adminMenus($menus, $options = [], $depth = 0) {
        $options = Hash::merge([
            'type' => 'sidebar',
            'children' => true,
            'htmlAttributes' => [
                'class' => 'nav nav-stacked',
            ],
        ], $options);

        $aclPlugin = Configure::read('Site.acl_plugin');
        $userId = AuthComponent::user('id');
        if (empty($userId)) {
            return '';
        }

        $sidebar = $options['type'] === 'sidebar';
        $htmlAttributes = $options['htmlAttributes'];
        $out = null;
        $sorted = Hash::sort($menus, '{s}.weight', 'ASC');
        if (empty($this->Role)) {
            $this->Role = ClassRegistry::init('Users.Role');
            $this->Role->Behaviors->attach('Croogo.Aliasable');
        }
        $currentRole = $this->Role->byId($this->Layout->getRoleId());

        if(isset($options['navigationHeader']) && $depth == 0){
            $out .= $this->Html->tag('li', $options['navigationHeader'], [
                'class' => 'header'
            ]);
        }

        foreach ($sorted as $menu) {

            if (isset($menu['separator'])) {
                $liOptions['class'] = 'header';
                $out .= $this->Html->tag('li', $menu['title'], $liOptions);
                continue;
            }
            if ($currentRole != 'admin' && !$this->{$aclPlugin}->linkIsAllowedByUserId($userId, $menu['url'])) {
                continue;
            }

            if (empty($menu['htmlAttributes']['class'])) {
                $defaultAttributes = [
                    'class' => Inflector::slug(strtolower('menu-' . $menu['title']), '-'),
                ];
                $menu['htmlAttributes'] = Hash::merge($defaultAttributes, $menu['htmlAttributes']);
            }
            $title = '';
            if ($menu['icon'] === false) {
            } elseif (empty($menu['icon'])) {
                $menu['htmlAttributes'] += ['icon' => 'link'];
            } else {
                $menu['htmlAttributes'] += ['icon' => $menu['icon']];
            }
            if ($sidebar && $depth == 0) {
                $title .= '<span>' . $menu['title'] . '</span>';
            } else {
                $title .= $menu['title'];
            }
            $children = '';
            if (!empty($menu['children'])) {
                $childClass = '';
                if ($sidebar) {
                    $childClass = 'treeview-menu';
                } else {
                    if ($depth == 0) {
                        $childClass = 'dropdown-menu';
                    }
                }
                $children = $this->adminMenus($menu['children'], [
                    'type' => $options['type'],
                    'children' => true,
                    'htmlAttributes' => ['class' => $childClass],
                ], $depth + 1);
            }



            if($sidebar && !empty($children) && $depth >= 0){
                $icon = $this->Html->tag('i', '', [
                    'class' => 'fa fa-angle-left pull-right'
                ]);
                $title .= $this->Html->tag('span', $icon, [
                    'class' => 'pull-right-container'
                ]);
                $menu['url'] = "#";
            }

            $link = $this->Html->link($title, $menu['url'], $menu['htmlAttributes']);
            $liOptions = array();
            if($sidebar && !empty($children) && $depth >= 0){
                $liOptions['class'] = "treeview";
            }

            $menuUrl = $this->url($menu['url']);

            if (($menuUrl == env('REQUEST_URI')) && ($depth >= 0)) {
                $liOptions['class'] = empty($liOptions['class']) ? "active" : $liOptions['class'] .= " active";
            }

            $out .= $this->Html->tag('li', $link . $children, $liOptions);
        }
        return $this->Html->tag('ul', $out, $htmlAttributes);
    }

    /**
     * Create an action button
     *
     * @param string $title Button title
     * @param array|string $url URL
     * @param array $options Options array
     * @param string|boolean $confirmMessage Confirmation message
     * @return string
     */
    public function adminAction($title, $url, $options = [], $confirmMessage = false) {
        $options = Hash::merge([
            'button' => 'default',
            'method' => 'get',
            'list' => false,
        ], $options);

        if ($options['list'] === true) {
            $list = true;
            unset($options['list']);
        }
        if (strcasecmp($options['method'], 'post') == 0) {
            $options['block'] = 'scriptBottom';
            $out = $this->Form->postLink($title, $url, $options, $confirmMessage);
        } else {
            unset($options['method']);
            $out = $this->Html->link($title, $url, $options, $confirmMessage);
        }
        if (isset($list)) {
            $out = $this->Html->tag('li', $out);
        }
        return $out;
    }

    public function adminTab($title, $url, $options = []) {
        if(!isset($this->_firstShow)){
            $this->_firstShow = false;
        }

        $link = $this->Html->link($title, $url, Hash::merge([
            'data-toggle' => 'tab',
            'aria-expanded' => ($this->_firstShow) ? "false" : "true"
        ], $options));

        $liOptions = [
            'class' => ($this->_firstShow) ? "" : "active",
        ];

        $this->_firstShow = true;
        return $this->Html->tag('li', $link, $liOptions);
    }

}
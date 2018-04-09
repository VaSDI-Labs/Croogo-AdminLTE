<?php
App::uses('DashboardsHelper', 'Dashboards.View/Helper');

/**
 * Created by PhpStorm.
 * User: VaDiM
 * Date: 01.04.2018
 * Time: 16:02
 *
 * @property ViewIDE $_View
 * @property HtmlHelper $Html
 * @property Role $Role
 * @property LayoutHelper $Layout
 * @property ThemeHelper $Theme
 */
class AdminLTEDashboardsHelper extends DashboardsHelper {

    public $helpers = [
        'Croogo.Layout',
        'Croogo.Theme',
        'Html' => ['className' => 'AdminLTEHtml'],
    ];

    public function beforeRender($viewFile) {
        parent::beforeRender($viewFile);

        $this->_getFeedPost();
    }

    public function dashboards() {
        $registered = Configure::read('Dashboards');
        $userId = AuthComponent::user('id');
        if (empty($userId)) {
            return '';
        }

        $columns = array(
            CroogoDashboard::LEFT => array(),
            CroogoDashboard::RIGHT => array(),
            CroogoDashboard::FULL => array(),
        );
        if (empty($this->Role)) {
            $this->Role = ClassRegistry::init('Users.Role');
            $this->Role->Behaviors->load('Croogo.Aliasable');
        }
        $currentRole = $this->Role->byId($this->Layout->getRoleId());

        /** @var array $cssSetting */
        $cssSetting = $this->Theme->settings('css');

        if (!empty($this->_View->viewVars['boxes_for_dashboard'])) {
            $boxesForLayout = Hash::combine($this->_View->viewVars['boxes_for_dashboard'], '{n}.DashboardsDashboard.alias', '{n}.DashboardsDashboard');
            $dashboards = array();
            $registeredUnsaved = array_diff_key($registered, $boxesForLayout);
            foreach ($boxesForLayout as $alias => $userBox) {
                if (isset($registered[$alias]) && $userBox['status']) {
                    $dashboards[$alias] = array_merge($registered[$alias], $userBox);
                }
            }
            $dashboards = Hash::merge($dashboards, $registeredUnsaved);
            $dashboards = Hash::sort($dashboards, '{s}.weight', 'ASC');
        } else {
            $dashboards = Hash::sort($registered, '{s}.weight', 'ASC');
        }

        foreach ($dashboards as $alias => $dashboard) {
            if ($currentRole != 'admin' && !in_array($currentRole, $dashboard['access'])) {
                continue;
            }

            $opt = array(
                'alias' => $alias,
                'dashboard' => $dashboard,
            );
            Croogo::dispatchEvent('Croogo.beforeRenderDashboard', $this->_View, compact('alias', 'dashboard'));
            $dashboardBox = $this->_View->element('Dashboards.admin/dashboard', $opt);
            Croogo::dispatchEvent('Croogo.afterRenderDashboard', $this->_View, compact('alias', 'dashboard', 'dashboardBox'));

            if ($dashboard['column'] === false) {
                $dashboard['column'] = count($columns[0]) <= count($columns[1]) ? CroogoDashboard::LEFT : CroogoDashboard::RIGHT;
            }

            $columns[$dashboard['column']][] = $dashboardBox;
        }

        $dashboardTag = $this->settings['dashboardTag'];
        $columnDivs = array(
            0 => $this->Html->tag($dashboardTag, implode('', $columns[CroogoDashboard::LEFT]), array(
                'class' => $cssSetting['dashboardLeft'] . ' ' . $cssSetting['dashboardClass'],
                'id' => 'column-0',
            )),
            1 => $this->Html->tag($dashboardTag, implode('', $columns[CroogoDashboard::RIGHT]), array(
                'class' => $cssSetting['dashboardRight'] . ' ' . $cssSetting['dashboardClass'],
                'id' => 'column-1'
            )),
        );
        $fullDiv = $this->Html->tag($dashboardTag, implode('', $columns[CroogoDashboard::FULL]), array(
            'class' => $cssSetting['dashboardFull'] . ' ' . $cssSetting['dashboardClass'],
            'id' => 'column-2',
        ));

        return $this->Html->tag('div', $fullDiv, array('class' => $cssSetting['row'])) .
            $this->Html->tag('div', implode('', $columnDivs), array('class' => $cssSetting['row']));
    }

    protected function _getFeedPost(){
        $posts = $this->getPosts();

        $this->_View->set('posts', $posts);
    }

    protected function getPosts()
    {
        $posts = Cache::read('croogo_blog_feed_posts');
        if ($posts === false) {
            $xml = Xml::build(file_get_contents('https://blog.croogo.org/promoted.rss'));

            $data = Xml::toArray($xml);

            $posts = [];
            foreach ($data['rss']['channel']['item'] as $item) {
                $posts[] = [
                    'title' => $item['title'],
                    'url' => $item['link'],
                    'body' => $item['description'],
                    'date' => $item['pubDate'],
                ];
            }
        }

        Cache::write('croogo_blog_feed_posts', $posts);

        return $posts;
    }


}
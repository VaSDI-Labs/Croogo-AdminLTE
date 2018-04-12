<?php
App::uses('CroogoHtmlHelper', 'Croogo.View/Helper');

/**
 * Class AdminLTEHtmlHelper
 */
class AdminLTEHtmlHelper extends CroogoHtmlHelper {

    public function __construct(View $View, array $settings = []) {
        parent::__construct($View, $settings);

        unset($this->_tags['javascriptlink']);
        $this->_tags['javascriptlink'] = '<script src="%s"%s></script>';

        $boxIconClass = trim(
            $this->settings['iconDefaults']['classDefault'] . ' ' .
            $this->settings['iconDefaults']['classPrefix'] . 'list'
        );

        $this->_tags['beginbox'] =
            '<div class="box box-default">
				<div class="box-header with-border">
				    <i class="' . $boxIconClass . '"></i>
					<h3 class="box-title">%s</h3>
					<div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
				</div>
				<div class="box-body">';

        $this->_tags['endbox'] =
            '
                </div>
                <div id="boxOverlay"></div>
			</div>';
    }

    public function status($value, $url = []) {
        $iconDefaults = $this->settings['iconDefaults'];
        $icons = $this->settings['icons'];
        $icon = $value == CroogoStatus::PUBLISHED ? $icons['check-mark'] : $icons['x-mark'];
        $class = $value == CroogoStatus::PUBLISHED ? 'text-green' : 'text-red';

        if (empty($url)) {
            return $this->icon($icon, ['class' => $class]);
        } else {
            return $this->link('', 'javascript:void(0);', [
                'data-url' => $this->url($url),
                'class' => trim(implode(' ', [
                    $iconDefaults['classDefault'],
                    $iconDefaults['classPrefix'] . $icon,
                    $class,
                    'ajax-toggle',
                ]))
            ]);
        }
    }
}

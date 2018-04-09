(function ($, window, document, undefined ) {

	const pluginName = 'itemChooser';

	const defaults = {
		// selector that triggers chooser_select event
		itemSelector: 'a.item-choose',

        modalPopup: "#modal",

		// field configuration:
		// eg:
		//	{ type: "Node", target: "id", attr: "data-id" },
		//	{ type: "Block", target: "title", attr: "data-title" }
		fields: []
	};

	function Plugin(element, options) {
		this.element = element;

		this.options = $.extend({}, defaults, options);

		this._defaults = defaults;
		this._name = pluginName;

		this.init();
	}

	Plugin.prototype = {

		init: function() {
			$(this.element).on('click', this.openModal);
		},

		clickCallback: function(e, data) {
			const $this = $(this);
            const attr = $this.data('chooserAttr');
            const type = $this.data('chooserType');
			if (type !== $(data).attr('data-chooser_type')) {
				return;
			}
			$this.val($(data).attr(attr));
		},

        openModal: function(e) {
			const $this = $(this);
			const $plugin = $this.data('plugin_' + pluginName);
			const options = $plugin.options;

            for (let i = 0; i < options.fields.length; i++){
                const config = options.fields[i];
                const $el = $(config.target);
                const events = 'chooser_select';
                $el.data('chooserAttr', config.attr);
                $el.data('chooserType', config.type);
                if ($el.data('chooserAttached') === true) {
                    continue;
                }
                if (typeof config.callback === 'function') {
                    $el.on(events, config.callback);
                } else {
                    $el.on(events, $plugin.clickCallback);
                }
                $el.data('chooserAttached', true);
			}

            $.ajax({
                url: $this.attr('href'),
                dataType: "html",
                success: function(data){
                    let modalBody = $(options.modalPopup).find('.modal-body');

                    $(modalBody).html($(data).find('.content-wrapper > .content').html());

                    $(options.modalPopup).on('click', options.itemSelector, function (e) {
                        parent.$('body *').trigger('chooser_select', this);
                        $(options.modalPopup).modal('hide');
                        $(modalBody).html("");
                        return false;
                    }).modal('show');
                }
            });

			return false;
		}

	};

	$.fn[pluginName] = function(options) {
		return this.each(function() {
			if (!$.data(this, 'plugin_' + pluginName)) {
				$.data(this, 'plugin_' + pluginName, new Plugin(this, options));
			}
		});
	};

})(jQuery, window, document);

const Admin = {
    spinnerClass() {
        return Admin.iconClass('spinner') + ' ' + Admin.iconClass('spin', false)
    },
    form() {
        $('[rel=tooltip],*[data-title]:not([data-content]),input[title],textarea[title]').tooltip();

        $('.datepicker').datepicker({
            autoclose: true
        });

        $('.datetimepicker').datetimepicker({
            keepOpen: true,
            format: "YYYY-MM-DD HH:mm:ss"
        });


        $('[type="submit"]').on('click', function () {
            const $required = $('.required');

            if($required.length !== 0){
                let isContinue = false;

                $.each($required, function (i, elem) {
                    const $field = $(elem).find('input[required="required"]:not([type="password"])');
                    if($field.get(0) !== undefined){
                        const errorClass = "has-error";
                        const successClass = "has-success";

                        if($field.val() === ""){
                            $(elem).addClass(errorClass).removeClass(successClass);

                            isContinue = false;
                        } else {
                            $(elem).addClass(successClass).removeClass(errorClass);

                            isContinue = true;
                        }
                    }
                });

                return isContinue;
            }

            return true;
        });

        $('input[type="checkbox"].iCheck, input[type="radio"].iCheck').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });

        const ajaxToggle = function () {
            const $this = $(this);
            const spinnerClass = Admin.spinnerClass();
            $this.addClass(spinnerClass).find('i').attr('class', 'icon-none');
            const url = $this.data('url');
            $.post(url, function (data) {
                $this.parent().html(data);
            });
        };

        if (typeof $.fn.typeahead_autocomplete === 'function') {
            $('input.typeahead-autocomplete').typeahead_autocomplete();
        }

        $('body')
            .on('click', 'a[data-row-action]', Admin.processLink)
            .on('click', 'a.ajax-toggle', ajaxToggle);
    },
    protectForms() {
        const forms = document.getElementsByClassName('protected-form');
        if (forms.length > 0) {
            const watchElements = ['input', 'select', 'textarea'];
            const ignored = ['button', '[type=submit]', '.cancel'];
            for (let i = 0; i < forms.length; i++) {
                const $form = $(forms[i]);
                const customIgnore = $form.data('ignore-elements');
                let whitelist = ignored.join(',');
                if (customIgnore) {
                    whitelist += ',' + customIgnore;
                }
                $form
                    .on('change', watchElements.join(','), function (e) {
                        $form.data('dirty', true);
                    })
                    .on('click', whitelist, function (e) {
                        $form.data('dirty', false);
                        if (Croogo.Wysiwyg && Croogo.Wysiwyg.resetDirty) {
                            Croogo.Wysiwyg.resetDirty();
                        }
                    });
            }

            window.onbeforeunload = function (e) {
                let dirty = false;
                for (let i = 0; i < forms.length; i++) {
                    if ($(forms[i]).data('dirty') === true) {
                        dirty = true;
                        break;
                    }
                }
                const Wysiwyg = Croogo.Wysiwyg;
                if (!dirty) {
                    if (!Wysiwyg.checkDirty || (Wysiwyg.checkDirty && !Wysiwyg.checkDirty())) {
                        return;
                    }
                }

                const confirmationMessage = 'Please save your changes';
                (e || window.event).returnValue = confirmationMessage;
                return confirmationMessage;
            };
        }
    },
    processLink(event) {
        const $el = $(event.currentTarget);
        const checkbox = $(event.currentTarget.attributes["href"].value);
        const form = checkbox.get(0).form;
        const action = $el.data('row-action');
        const confirmMessage = $el.data('confirm-message');
        if (confirmMessage && !confirm(confirmMessage)) {
            return false;
        }
        $("input[type='checkbox']", form).prop('checked', false);
        checkbox.prop("checked", true);
        $('#bulk-action select', form).val(action);
        form.submit();
        return false;
    },
    toggleRowSelection(selector, checkboxSelector) {
        const $selector = $(selector);

        if (typeof checkboxSelector === 'undefined') {
            checkboxSelector = "input.row-select[type='checkbox']";
        }
        $selector.on('click', function (e) {
            const clicks = $(selector).data('clicks');

            if (clicks) {
                $(".fa", selector).removeClass("fa-check-square-o").addClass('fa-square-o');
                $(checkboxSelector).iCheck("uncheck").prop('checked', false);
            } else {
                $(".fa", selector).removeClass("fa-square-o").addClass('fa-check-square-o');
                $(checkboxSelector).iCheck("check").prop('checked', true);
            }

            $(selector).data("clicks", !clicks);
        });
    },
    iconClass(icon, includeDefault) {
        let result = '';
        if (typeof Croogo.themeSettings.icons[icon] === 'string') {
            icon = Croogo.themeSettings.icons[icon];
        }
        if (typeof includeDefault === 'undefined') {
            includeDefault = true;
        }
        if (includeDefault) {
            result = Croogo.themeSettings.iconDefaults['classDefault'] + ' ';
        }
        result += Croogo.themeSettings.iconDefaults['classPrefix'] + icon;
        return result.trim();
    }
};
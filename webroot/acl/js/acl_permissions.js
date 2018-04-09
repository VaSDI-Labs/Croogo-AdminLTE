const AclPermissions = {
    _firstLoad: true,
    templates: {
        permissionRow: _.template('<tr data-parent_id="<%= id %>" class="<%= classes %>"> <%= text %> </tr>'),
        controllerCell: _.template('\
<td> \
	<div class="<%= classes %>" data-alias="<%= alias %>" \
		data-level="<%= level %>" data-id="<%= id %>" > \
	<%= alias %><i class="pull-right"></i> \
	</div> \
</td>'),
        toggleButton: _.template('\
<td><i class="<%= classes.trim() %>" \
		data-aro_id="<%= aroId %>" data-aco_id="<%= acoId %>"></i> \
</td>'),
        editLinks: _.template('<td><div class="btn-group item-actions"><%= up %> <%= down %> <%= edit %> <%= del %> </div></td>')
    },
    documentReady() {
        AclPermissions.permissionToggle();
        AclPermissions.tableToggle();
        $('tr:has(div.controller)').addClass('controller-row');
    },
    tabLoad(e) {
        const $target = $(e.target);
        const matches = (e.target.toString().match(/#.+/gi));
        const pane = matches[0];
        const alias = $target.data('alias');
        const $i = $('.' + Admin.iconClass('spinner', false), $target);
        const spinnerClass = Admin.spinnerClass();
        if ($i.length > 0) {
            $i.addClass(spinnerClass);
        } else {
            $target.append(' <i class="' + spinnerClass + '"></i>');
        }
        $(pane).load(
            Croogo.basePath + 'admin/acl/acl_permissions/',
            $.param({root: alias}),
            function (responseText, textStatus, xhr) {
                $('i', $target).removeClass(spinnerClass);
                AclPermissions.documentReady();
            }
        );
        this._firstLoad = false;
    },
    tabSwitcher() {
        $('body').on('shown.bs.tab', '#permissions-tab', AclPermissions.tabLoad);
        if (this._firstLoad) {
            AclPermissions.tabLoad({
                target: $('#permissions-tab').find('li:first-child a').get(0)
            });
        }
    },
    permissionToggle() {
        $('.permission-table').one('click', '.permission-toggle:not(.permission-disabled)', function () {
            const $this = $(this);
            const acoId = $this.data('aco_id');
            const aroId = $this.data('aro_id');
            const spinnerClass = Admin.spinnerClass();

            // show loader
            $this
                .removeClass(Admin.iconClass('check-mark') + ' ' + Admin.iconClass('x-mark'))
                .addClass(spinnerClass);

            // prepare loadUrl
            let loadUrl = Croogo.basePath + 'admin/acl/acl_permissions/toggle/';
            loadUrl += acoId + '/' + aroId + '/';

            // now load it
            const target = $this.parent();
            $.post(loadUrl, null, function (data, textStatus, jqXHR) {
                target.html(data);
                AclPermissions.permissionToggle();
            });

            return false;
        });
    },
    tableToggle() {
        const renderPermissions = function (data, textStatus) {
            const $el = $(this);
            let rows = '';
            const id = $el.data('id');
            const spinnerClass = Admin.spinnerClass();

            for (const acoId in data.permissions) {
                if (data.permissions.hasOwnProperty(acoId)) {
                    let text = '<td>' + acoId + '</td>';
                    const aliases = data.permissions[acoId];

                    let children = null;
                    for (const alias in aliases) {
                        if (aliases.hasOwnProperty(alias)) {
                            const aco = aliases[alias];
                            children = aco['children'];
                            let classes = children > 0 ? 'controller perm-expand' : '';
                            classes += " level-" + data.level;
                            text += AclPermissions.templates.controllerCell({
                                id: acoId,
                                alias: alias,
                                level: data.level,
                                classes: classes.trim()
                            });
                            if (Croogo.params.controller === 'acl_permissions') {
                                text += renderRoles(data.aros, acoId, aco);
                            } else {
                                text += AclPermissions.templates.editLinks(aco['url']);
                            }
                        }
                    }
                    let rowClass = '';
                    if (children > 0 && data.level > 0) {
                        rowClass = "controller-row level-" + data.level;
                    }
                    rows += AclPermissions.templates.permissionRow({
                        id: id,
                        classes: rowClass,
                        text: text
                    });
                }
            }
            const $row = $el.parents('tr');
            $(rows).insertAfter($row);
            $el.find('i').removeClass(spinnerClass);
        };

        const renderRoles = function (aros, acoId, roles) {
            let text = '';
            for (const aroIndex in roles['roles']) {
                if (roles['roles'].hasOwnProperty(aroIndex)) {
                    const cell = {
                        aroId: aros[aroIndex],
                        acoId: acoId,
                        classes: "permission-toggle "
                    };
                    if (roles['children'] > 0) {
                        text += '<td>&nbsp;</td>';
                        continue;
                    }

                    const allowed = roles['roles'][aroIndex];
                    if (aroIndex === "1") {
                        cell.classes += "lightgray permission-disabled " + Admin.iconClass("check-mark");
                    } else {
                        if (allowed) {
                            cell.classes += "text-green " + Admin.iconClass("check-mark");
                        } else {
                            cell.classes += "text-red " + Admin.iconClass("x-mark");
                        }
                    }
                    text += AclPermissions.templates.toggleButton(cell);
                }
            }
            return text;
        };

        $('.permission-table').on('click', '.controller', function () {
            const $el = $(this);
            const id = $el.data('id');
            const level = $el.data('level');
            const spinnerClass = Admin.spinnerClass();

            $el.find('i').addClass(spinnerClass);
            if ($el.hasClass('perm-expand')) {
                $el.removeClass('perm-expand').addClass('perm-collapse');
            } else {
                const children = $('tr[data-parent_id=' + id + ']');
                children.each(function () {
                    const childId = $('.controller', this).data('id');
                    $('tr[data-parent_id=' + childId + ']').remove();
                }).remove();
                $el.removeClass('perm-collapse').addClass('perm-expand')
                    .find('i').removeClass(spinnerClass);
                return;
            }

            let params = {
                perms: true
            };
            if (Croogo.params.controller === 'acl_actions') {
                params = $.extend(params, {
                    urls: true,
                    perms: false
                });
            }

            const url = Croogo.basePath + 'admin/acl/acl_permissions/index/';
            $.getJSON(url + id + '/' + level, params, function (data, textStatus) {
                renderPermissions.call($el[0], data, textStatus);
            });
        });
    }
};

$(function () {
    if (Croogo.params.controller === "acl_permissions") {
        AclPermissions.documentReady();
    }
});
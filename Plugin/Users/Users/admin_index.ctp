
<?php /** @var ViewAnnotation $this */

$this->extend('/Common/admin_index');

$this->Html
	->addCrumb($this->Html->icon('home'), '/admin')
	->addCrumb(__d('croogo', 'Users'));

if(isset($this->request->query['chooser'])):
$this->append('page-footer'); ?>
    <script>
        function ajaxRequest(url, data){
            let ajaxOption = {
                url: url,
                dataType: "html",
                success: function (data) {
                    $('.modal').find('.modal-body').html($(data).find('.content-wrapper > .content').html());
                }
            };

            if(data !== undefined) ajaxOption.data = data;

            $.ajax(ajaxOption);
        }
        $(function () {
            const modalPopup = $('.modal');
            modalPopup.find('.modal-dialog').addClass('modal-lg');

            $('body').on('click', function () {
                if (!modalPopup.hasClass('in')) {
                    modalPopup.find('.modal-dialog').removeClass('modal-lg');
                }
            });

            $('#UserAdminIndexForm').on('submit', function (e) {
                e.preventDefault();
                const data = {
                    chooser: $('#UserChooser').val(),
                    role_id: $('#UserRoleId').val(),
                    name: $('#UserName').val()
                };
                ajaxRequest($(this).attr('action'), data);
            });

            $('.pagination').on('click', 'li a', function (e) {
                e.preventDefault();
                ajaxRequest($(this).attr('href'));
            });
        });
    </script>
<?php $this->end(); endif;

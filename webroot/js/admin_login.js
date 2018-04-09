$(function () {

    $('[type="submit"]').on('click', function () {
        const $required = $('.required');

        if($required.length !== 0){
            let isContinue = false;

            $.each($required, function (i, elem) {
                const $field = $(elem).find('input[required="required"]');
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

    setTimeout(function () {
        $('.login-box-body').find('.success').remove();
    }, 3000);



    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });
});
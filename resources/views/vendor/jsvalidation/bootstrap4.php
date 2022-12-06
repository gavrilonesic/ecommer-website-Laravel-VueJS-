<script>
    jQuery(document).ready(function(){

        $("<?= $validator['selector']; ?>").each(function() {
            $(this).validate({
                errorElement: 'span',
                errorClass: 'invalid-feedback',
                errorPlacement: function (error, element) {
                    if (element.parent('span').parent('.radioboxrow').length){
                        error.insertAfter(element.closest('.second-step'));
                        // else just place the validation message immediately after the input
                    }
                    else if (element.parent('.input-group').length ||
                        element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                        error.insertAfter(element.parent());
                        // else just place the validation message immediately after the input
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function (element) {
                $(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid'); // add the Bootstrap error class to the control group
                },

                <?php if (isset($validator['ignore']) && is_string($validator['ignore'])): ?>

                ignore: "<?= $validator['ignore']; ?>",
                <?php endif; ?>


                unhighlight: function(element) {
                    // $(element).closest('.form-control').removeClass('is-invalid').addClass('is-valid');
                    $(element).closest('.form-control').removeClass('is-invalid');
                },

                success: function (element) {
                    $(element).closest('.form-control').removeClass('is-invalid').addClass('is-valid'); // remove the Boostrap error class from the control group
                    $(element).remove()
                },

                focusInvalid: true, // do not focus the last invalid input
                onkeyup: false, // disable on key press event
                <?php if (Config::get('jsvalidation.focus_on_error')): ?>
                invalidHandler: function (form, validator) {

                    if (!validator.numberOfInvalids())
                        return;
                    // if (!$('body').hasClass('modal-open')) {
                    //     $('html, body').animate({
                    //         // scrollTop: $(validator.errorList[0].element).offset().top
                    //         scrollTop: $(validator.errorList[0].element).closest("div").parent().scrollTop()
                    //     }, <?= Config::get('jsvalidation.duration_animate') ?>);
                    // }
                    $(validator.errorList[0].element).focus();

                },
                <?php endif; ?>

                rules: <?= json_encode($validator['rules']); ?>
            });
        });
    });
</script>

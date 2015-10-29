jQuery(document).ready(function ($) {
    $('#vote-send-btn').on('click', function () {
        if ($('.vote-input input:checked').length == 0) {
            // Not selected
            $('.vote-error').html(voteObj.lang.errors.required).show();
        } else {
            // OK
            $('.vote-error').html('').hide();

            var answer = {};
            $('.vote-input input:checked').each(function () {
                answer['vote[' + $(this).val() + ']'] = $(this).val();
            });

            $.ajax({
                'type': "POST",
                'url': voteObj.url,
                'data': answer,
                'success': function (responseHtml) {
                    $('#vote-block-container').html(responseHtml);
                },
                'error': function () {
                    $('.vote-error').html(voteObj.lang.errors.failed).show();
                },
                'dataType': 'html'
            });

        }
    });
});
$(document).ready(function() {
    var min_post_len = 2;
    $('#post_body').on('change keydown paste', function() {
        var len = $(this).val().length;

        if (len >= min_post_len) {
            $('[name="submit"]').prop('disabled', false);
        } else {
            $('[name="submit"]').prop('disabled', true);
        }
        if ((min_post_len - len) > 0) {
            $('.char_count').text('( ' + (min_post_len - len) + ' chars more)')
        } else {
            $('.char_count').text('');
        }
    });
    $('[id^=list_box]').click(function() {
        $('#comment_list_box_' + $(this).data('post-id')).slideDown();
    });
    $('[id^=reply_post_]').click(function() {
        $('[id^=comment_list_]').slideUp();
        $('[id^=comment_box_]').slideUp();
        $('#comment_list_box_' + $(this).data('post-id')).slideToggle();
        $('#comment_box_' + $(this).data('post-id')).slideToggle();
        $('html, body').animate({
            scrollTop: $('#comment_box_' + $(this).data('post-id')).offset().top
        }, 1000);
    });
});

$(document).ready(function () {
    $('div#my_seminars table').each(
        function () {
            var caption = $.trim($(this).find('caption').first().text());
            if (caption === 'WS 15/16' && $(this).find('tbody tr').length < 5) {
                $(this).find('tbody').append($('tr.rec'));
            }
        }
    );
});
+function ($) { "use strict";

    $(document).ready(function(){
        $('#js-comments').on('click touchstart', function (e) {
            e.preventDefault()
            var $this = $(this),
                $a = $this.find('a'),
                href = $a.attr('href')

            window.location.href = href
        })

        $('.js-hostname').on('click touchstart', function (e) {
            e.preventDefault()
            var $this = $(this),
                ip = $this.text()

            $('input[name="listToolbarSearch[term]"]').val(ip).focus()
        })
    })

}(window.jQuery);
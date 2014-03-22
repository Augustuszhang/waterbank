var Page = (function () {
    var $grid = $('#bb-custom-grid');
    return {
        init: function () {
            $grid.find('div.bb-bookblock').each(function (i) {
                var $bookBlock = $(this),
                    $nav = $bookBlock.next().children('span'),
                    bb = $bookBlock.bookblock({
                        speed: 600,
                        shadows: false
                    });
                $nav.each(function (i) {
                    $(this).on('click touchstart', function (event) {
                        var $dot = $(this);
                        $nav.removeClass('bb-current');
                        $dot.addClass('bb-current');
                        $bookBlock.bookblock('jump', i + 1);
                        return false;
                    });
                });
                $bookBlock.children().on({
                    'swipeleft': function (event) {
                        $bookBlock.bookblock('next');
                        return false;
                    },
                    'swiperight': function (event) {
                        $bookBlock.bookblock('prev');
                        return false;
                    }
                });
            });
        }
    };
})();
$(document).ready(function () {
    Page.init();
});
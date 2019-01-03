(function ($) {
    $(document).ready(function () {
        $('.sweets_shop a').on('click', function(e) {
            e.preventDefault();
            var sweet = $(this).data( "sweet" );
            $.ajax({
                type: "POST",
                data: { 
                    sweet: sweet
                },
                url: "/ajax/sweets_shop/make_order",
                success: function(res) {
                    $('.'+sweet+'-order-list').after(`<p>${res}</p>`);
                    $('orders-list').remove();
                    $('.'+sweet+'-order-btn').remove();
                },
                error: function() {
                    console.log('error');
                }
            });
        });
    });
}(jQuery));
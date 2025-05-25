$(document).ready(function () {
    $('input[name="product_autocomplete"]').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: location.href + '&ajax=1&action=searchProducts',
                dataType: 'json',
                data: { q: request.term },
                success: function (data) {
                    response($.map(data, function (item) {
                        return {
                            label: item.name,
                            value: item.name,
                            id_product: item.id_product
                        };
                    }));
                }
            });
        },
        minLength: 2,
        select: function (event, ui) {
            $('input[name="id_product"]').val(ui.item.id_product);
        }
    });
});

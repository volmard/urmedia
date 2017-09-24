<?php
//select title from products where brand_id in (1,2) and price between 2000 and 2500;

?>

<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" >
<div class="demo">

    <p>
        <label for="amount">Price range:</label>
        <input type="text" id="amount" style="border:0; color:#f6931f; font-weight:bold;" />
    </p>

    <div id="slider-range"></div>
    </div>

<script>
var $filters = $("input:radio[name='brand'],input:radio[name=team]").prop('checked', false); // start all checked
var $categoryContent = $('#CategoryContent li');
$filters.click(function() {
    // if any of the checkboxes for brand or team are checked, you want to show LIs containing their value, and you want to hide all the rest.
    $categoryContent.hide();
    $filters.filter(':checked').each(function(i, el) {
        $categoryContent.filter(':contains(' + el.value + ')').show();
    });
});

function showProducts(minPrice, maxPrice) {
    $("#products li").hide().filter(function() {
        var price = parseInt($(this).data("price"), 10);
        return price >= minPrice && price <= maxPrice;
    }).show();
}

$(function() {
    var options = {
        range: true,
        min: 0,
        max: 500,
        values: [50, 300],
        slide: function(event, ui) {
            var min = ui.values[0],
                max = ui.values[1];

            $("#amount").val("$" + min + " - $" + max);
            showProducts(min, max);
        }
    }, min, max;

    $("#slider-range").slider(options);

    min = $("#slider-range").slider("values", 0);
    max = $("#slider-range").slider("values", 1);

    $("#amount").val("$" + min + " - $" + max);

    showProducts(min, max);
});

</script>
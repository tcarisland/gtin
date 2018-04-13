function search_gtin() {
    var number = jQuery("#searchfield").val();
    var selectedField = "";
    var selected = jQuery("input[type='radio'][name='field']:checked");
    selectedField = selected.val();
    var append = "gtin_query.php?gtin=" + number + "&field=" + selectedField;
    jQuery.ajax({
        type: "GET",
        url: "http://www.tcarisland.com/wp-content/plugins/gtin/" + append,
        success: function (data) {
            jQuery("#gtin_data").html(data);
        }
    });
}

function search_specific_gtin(gtin_number) {
    var append = "gtin_specific.php?gtin_cd=" + gtin_number.substring(1);
    var link = "http://www.tcarisland.com/wp-content/plugins/gtin/" + append;
    var idname = "." + gtin_number.substring(1);
    if (jQuery(idname).is(":empty")) {
        jQuery.ajax({
            type: "GET",
            url: "http://www.tcarisland.com/wp-content/plugins/gtin/" + append,
            success: function (data) {
                jQuery(idname).hide();
                jQuery(idname).html(data);
                jQuery(idname).fadeIn(1000);
            }
        });
    } else {
        jQuery(idname).fadeOut(1000, function() {
            jQuery(this).html("");
        });
    }

}
function search_gtin() {
    var number = jQuery("#searchfield").val();
    var selectedField = "";
    var selected = jQuery("input[type='radio'][name='field']:checked");
    selectedField = selected.val();
    var append = "gtin_query.php?gtin=" + number + "&field=" + selectedField;
    jQuery.ajax( {
        type : "GET",
        url : "http://www.tcarisland.com/wp-content/plugins/gtin/" + append,
        success : function( data ) {
            jQuery("#gtin_data").html(data);
        }
    });
}


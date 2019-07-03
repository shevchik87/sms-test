$(document).ready(function() {

    $('.js-user-autocomplete').autocomplete({
        source: $('.js-user-autocomplete').data('autocomplete-url'),
        minLength: 2,
        select: function(event, ui) {
            console.log(ui);
            $(".js-user-autocomplete").val(ui.item.label);
            $("#form_userId").val(ui.item.value);
            return false;
        }
    });


    $('.js-country-autocomplete').autocomplete({
        source: $('.js-country-autocomplete').data('autocomplete-url'),
        minLength: 2,
        select: function(event, ui) {
            console.log(ui);
            $(".js-country-autocomplete").val(ui.item.label);
            $("#form_countryId").val(ui.item.value);
            return false;
        }
    });

    $("#form_apply").click(function( event ) {
        console.log( "Handler for .submit() called." );
        if ($('.js-country-autocomplete').val() == '') {
            $("#form_countryId").val(null);
        }
        if ($('.js-user-autocomplete').val() == '') {
            $("#form_userId").val(null);
        }
    });
});

jQuery(document).ready(function($) {
    var taxField = $('<span style="">Tax in %: </span><input type="text" name="tax_rate" id="tax-rate" value="" style="margin-right: 15px;" size="5"/>');
    taxField.on('keyup', function(){
        setCookie('pe-tax', $(this).val(), 365);
        $('input.gross-price-field').each(changeTax);
    });
    
    $('.language-selector').before(taxField);
    var tax = getCookie('pe-tax');
    if(tax !== null){
        $('#tax-rate').val(tax);
    }
    var changeTax = function(){
        if($(this).val().length > 0){
            $(this).next().val(Number(Number($(this).val())*(1+(Number($('#tax-rate').val()/100)))).toFixed(4));
        }
    };
    
    var addGross = function(){
        $(this).hide();
        var input = $('<input type="text" value="" style="text-align: right;">');
        if($(this).val().length > 0){
            input.val(Number(Number($(this).val())*(1+(Number($('#tax-rate').val()/100)))).toFixed(4));
        }
        //input.keyup(function(){
        $(input).focusout(function(){
            $(this).prev().val(Number(Number($(this).val())/(1+(Number($('#tax-rate').val()/100)))).toFixed(4));
            $(this).val(Number($(this).val()).toFixed(4));
            $(this).prev().trigger('change');
            $(this).prev().trigger('focusout');
        });
        $(this).after(input);
    };
    $('input.gross-price-field').each(addGross);
    
    $('#form-product-extra').on('product-extra-reload', function(){
        $(this).find('input.gross-price-field').each(addGross);
    });

    setInterval(function(){
        $('.product-extra-table').each(function(){
            if(typeof($(this).attr('changed')) == 'undefined'){
                $(this).find('input.gross-price-field').each(addGross);
                $(this).attr('changed', 0);
            }
        });
    }, 1000);
});
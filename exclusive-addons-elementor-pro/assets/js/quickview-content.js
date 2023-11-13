   /*
    * Quick view
    */

   ;(function($){
    "use strict";
    
   $(document).on('click', '.exadquickview', function (event) {
    event.preventDefault();

    var $this = $(this);
    var productID = $this.data('product-id');
    //var tmpl_id = $('.elementor-widget-exad-woo-products .exad-woo-products').data('quickview-tmp-id');

    $('.exad-modal-quickview-body').html(''); /*clear content*/
    $('#exad-viewmodal').addClass('exadquickview-open wlloading');
    $('#exad-viewmodal .exad-close-btn').hide();
    $('.exad-modal-quickview-body').html('<div class="exad-loading"><div class="wlds-css"><div style="width:100%;height:100%" class="wlds-ripple"><div></div><div></div></div>');
    
    var data = {
        id: productID,
        action: "exad_quickview",
    };
    $.ajax({
        url: exad_ajax_object.ajax_url,
        data: data,
        method: 'POST',
        success: function (response) {
            setTimeout(function () {
                $('.exad-modal-quickview-body').html(response);
                $('#exad-viewmodal .exad-close-btn').show();
            }, 300 );
           
        },
        complete: function () {
            $('#exad-viewmodal').removeClass('wlloading');
            $('.exad-modal-quickview-dialog').css("background-color","#ffffff");
        },
        error: function () {
            console.log("Quick View Not Loaded");
        },
        
    });

});
$('.exad-close-btn').on('click', function(event){
    $('#exad-viewmodal').removeClass('exadquickview-open');
    $('body').removeClass('exadquickview');
    $('.exad-modal-quickview-dialog').css("background-color","transparent");
});

})(jQuery);
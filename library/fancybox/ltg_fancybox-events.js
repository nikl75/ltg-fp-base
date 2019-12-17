var tGalInfoID;

$(document).on('onActivate.fb', function( e, instance, slide ) {
    // Your code goes here

    tGal = instance.group[0].opts.fbid;
    tGalInfoID = '#holzh-infobox-'+tGal;

});

$(document).on('beforeClose.fb', function( e, instance, slide ) {
    hideHohlzhInfo();
});


// Create template for the button
$.fancybox.defaults.btnTpl.info = '<button data-fancybox-holzh-info class="fancybox-button fancybox-button--info" title="Info">' +
    '<svg viewBox="0 0 24 24">' +
        '<path d="M12,0C5.4,0,0,5.4,0,12s5.4,12,12,12s12-5.4,12-12S18.6,0,12,0z M14,21.2h-3v-9.1h-3V9H14V21.2z M12.5,6.4 c-1.1,0-1.9-0.9-1.9-1.9s0.9-1.9,1.9-1.9s1.9,0.9,1.9,1.9S13.5,6.4,12.5,6.4z"/>' +
    '</svg>' +
'</button>';

// Make button clickable using event delegation
$('body').on('click', '[data-fancybox-holzh-info]', function() {
    showHolzhInfo();
});
$('body').on('click', '.holzh-info', function(){
    hideHohlzhInfo();
});


// Customize buttons
$( '[data-fancybox]' ).fancybox({
    buttons : [
        'info',
        'close',
        'thumbs',
        // 'zoom',
        // 'share',
        'slideShow',
        // 'fullScreen',
        // 'download'
    ]
});

function showHolzhInfo() {
    $(tGalInfoID).addClass('is-shown').removeClass('is-hidden');
}

function hideHohlzhInfo() {
    $(tGalInfoID).addClass('is-hidden').removeClass('is-shown');
}

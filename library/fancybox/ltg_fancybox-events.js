var tGalInfoID;

$(document).on('onActivate.fb', function( e, instance, slide ) {
    // Your code goes here

    tGal = instance.group[0].opts.fancybox.slice(4);
    tGalInfoID = '#sike-infobox-'+tGal;

});





// Customize buttons
$( '[data-fancybox]' ).fancybox({
    buttons : [
        // 'info',
        'close',
        'thumbs',
        // 'zoom',
        // 'share',
        'slideShow',
        // 'fullScreen',
        // 'download'
    ]
});

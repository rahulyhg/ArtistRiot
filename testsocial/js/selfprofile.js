$(document).ready(function() {

    //$('[data-toggle="tooltip"]').tooltip({'placement': 'top'});
    $('#hint').popover({trigger: 'hover', 'placement': 'left', content: 'content-popover'});
    $('[data-toggle="tooltip"]').tooltip({'placement': 'right'});
     $('[rel="tooltip"]').tooltip({'placement': 'right'});
     
    $(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
   
});
$(document).ready(function() {
    $("#check_scales").on('change', function() {
        if($("input.check_scales").is(':checked')) {
            $("#scales_filter").removeClass('d-none');
        } else {
            $("#scales_filter").addClass('d-none');
        }
    });
    $("#check_manufacturers").on('change', function() {
        if($("input.check_manufacturers").is(':checked')) {
            $("#manufacturer_filter").removeClass('d-none');
        } else {
            $("#manufacturer_filter").addClass('d-none');
        }
    })
});
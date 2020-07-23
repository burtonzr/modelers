$(document).ready(function() {
    $("#model-type-id").on('change', function(e) {
        e.preventDefault();
        var modelType = $("#model-type-id").val();
        console.log(modelType);
        if(modelType == 1) {
            $("#scales-naval").load(
                "scales_naval", function() {

                }
            );
        }
    });
});
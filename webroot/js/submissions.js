$(document).ready(function() {
    $("#model-type-id").on('change', function(e) {
        e.preventDefault();
        var modelType = $("#model-type-id").val();
        if(modelType == 1) {
            $("#scales-naval").removeClass('d-none');
            $("#scales-aircraft").addClass('d-none');
            $("#scales-armor").addClass('d-none');
            $("#scales-automotive").addClass('d-none');
            $("#scales-dioramas").addClass('d-none');
            $('#scales-trains').addClass('d-none');
            $('#scales-space').addClass('d-none');
            $("#scales-naval").load(
                "scales_naval", function() {

                }
            );
        } else if(modelType == 2) {
            $("#scales-aircraft").removeClass('d-none');
            $("#scales-naval").addClass('d-none');
            $("#scales-armor").addClass('d-none');
            $("#scales-automotive").addClass('d-none');
            $("#scales-figures").addClass('d-none');
            $("#scales-dioramas").addClass('d-none');
            $('#scales-trains').addClass('d-none');
            $('#scales-space').addClass('d-none');
            $("#scales-aircraft").load(
                "scales_aircraft", function() {

                }
            );
        } else if (modelType == 3) {
            $("#scales-automotive").removeClass('d-none');
            $("#scales-naval").addClass('d-none');
            $("#scales-aircraft").addClass('d-none');
            $("#scales-armor").addClass('d-none');
            $("#scales-figures").addClass('d-none');
            $("#scales-dioramas").addClass('d-none');
            $('#scales-trains').addClass('d-none');
            $('#scales-space').addClass('d-none');
            $("#scales-automotive").load(
                "scales_automotive", function() {

                }
            );
        } else if (modelType == 4) {
            $("#scales-armor").removeClass('d-none');
            $("#scales-naval").addClass('d-none');
            $("#scales-aircraft").addClass('d-none');
            $("#scales-automotive").addClass('d-none');
            $("#scales-figures").addClass('d-none');
            $("#scales-dioramas").addClass('d-none');
            $('#scales-trains').addClass('d-none');
            $('#scales-space').addClass('d-none');
            $("#scales-armor").load(
                "scales_armor", function() {

                }
            );
        } else if(modelType == 5) {
            $("#scales-figures").removeClass('d-none');
            $("#scales-figures").text("There are no scales for Figures.");
            $("#scales-naval").addClass('d-none');
            $("#scales-aircraft").addClass('d-none');
            $("#scales-automotive").addClass('d-none');
            $("#scales-armor").addClass('d-none');
            $("#scales-dioramas").addClass('d-none');
            $('#scales-trains').addClass('d-none');
            $('#scales-space').addClass('d-none');
        } else if (modelType == 6) {
            $("#scales-trains").removeClass('d-none');
            $("#scales-naval").addClass('d-none');
            $("#scales-aircraft").addClass('d-none');
            $("#scales-automotive").addClass('d-none');
            $("#scales-figures").addClass('d-none');
            $("#scales-armor").addClass('d-none');
            $("#scales-dioramas").addClass('d-none');
            $('#scales-space').addClass('d-none');
            $("#scales-trains").load(
                "scales_trains", function() {

                }
            );
        } else if (modelType == 7) {
            $("#scales-dioramas").removeClass('d-none');
            $("#scales-armor").addClass('d-none');
            $("#scales-naval").addClass('d-none');
            $("#scales-aircraft").addClass('d-none');
            $("#scales-automotive").addClass('d-none');
            $("#scales-figures").addClass('d-none');
            $('#scales-trains').addClass('d-none');
            $('#scales-space').addClass('d-none');
            $("#scales-dioramas").load(
                "scales_dioramas", function() {

                }
            );
        } else if(modelType == 8) {
            $("#scales-space").removeClass('d-none');
            $("#scales-space").text("There are no scales for Spacecraft/Sci-Fi.");
            $("#scales-naval").addClass('d-none');
            $("#scales-aircraft").addClass('d-none');
            $("#scales-automotive").addClass('d-none');
            $("#scales-armor").addClass('d-none');
            $("#scales-figures").addClass('d-none');
            $("#scales-dioramas").addClass('d-none');
            $('#scales-trains').addClass('d-none');
        }
    });
});
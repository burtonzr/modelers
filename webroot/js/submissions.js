$(document).ready(function() {
    // Save image file name 
    var removed = "";
    $("#mainImage").removeAttr('required');
    $("#changeImageButton").on('click', function() {
        $("#changeImageButton").addClass('d-none');
        $("#changeImage").removeClass('d-none');
        var imageName = $("#mainImage").val();
        removed       = $("#mainImageHidden").remove();
        $("#newImagePath").html(imageName);
    });
    $("#cancelMainImage").on('click', function() {
        $("#changeImageButton").removeClass('d-none');
        $("#changeImage").addClass('d-none');
        $("#newImagePath").html();
        removed.insertAfter("#mainImage");
    });
    //Adding more images
	$("#add_image").click(function() {
		num_images = parseInt($("#num_images").val(), 10);
		empty = false;
		for(i = 1; i <= num_images; i++) {
			if($("#ImageFile" + i).val() === "") {
				empty = true;
				break;
			}
		}
		if(empty === true) {
			alert("Please select a file for each image before adding another!");
		} else {
			$("#uploads_table > tbody").prepend('<tr><td></td><td>&nbsp;</td></tr>');
			$("#ImageFile" + num_images).appendTo($("#uploads_table > tbody > tr:first > td:first"));
			$(this).parent("td").parent("tr").children("td:first").append('<input type="file" name="data[Image][file][]" id="ImageFile' + (num_images + 1) + '" />');
			$("#num_images").val(num_images + 1);
			if((num_images + 1) >= 25) {
				$(this).remove();
			}
		}
	});
    $("#manufacturer_id").on('change', function(e) {
        var manufacturer = $("#manufacturer_id").val();
        
        if(manufacturer == 28) {
            $("#other-manufacturer").removeClass('d-none');
        } else {
            $("#other-manufacturer").addClass('d-none');
        }
    });

    $("#model-type-id").on('change', function(e) {
        e.preventDefault();
        var modelType = $("#model-type-id").val();

        // submission categories
        $("#category-naval").addClass('d-none');
        $("#category-aircraft").addClass('d-none');
        $("#category-automotive").addClass('d-none');
        $("#category-armor").addClass('d-none');
        $("#category-figures").addClass('d-none');
        $("#category-trains").addClass('d-none');
        $("#category-dioramas").addClass('d-none');
        $("#category-space").addClass('d-none');

        // scales
        $("#scales-naval").addClass('d-none');
        $("#scales-aircraft").addClass('d-none');
        $("#scales-armor").addClass('d-none');
        $("#scales-automotive").addClass('d-none');
        $("#scales-figures").addClass('d-none');
        $("#scales-dioramas").addClass('d-none');
        $('#scales-trains').addClass('d-none');
        $('#scales-space').addClass('d-none');

        if(modelType == 1) {
            // submission categories
            $("#category-naval").removeClass('d-none');
            $("#category-naval").load(
                "submissioncategory_naval", function() {

                }
            );
            
            
            // scales
            $("#scales-naval").removeClass('d-none');
            $("#scales-naval").load(
                "scales_naval", function() {

                }
            );
        } else if(modelType == 2) {
            // submission categories
            $("#category-aircraft").removeClass('d-none');
            $("#category-aircraft").load(
                "submissioncategory_aircraft", function() {
                    
                }
            );

            // scales
            $("#scales-aircraft").removeClass('d-none');
            $("#scales-aircraft").load(
                "scales_aircraft", function() {

                }
            );
        } else if (modelType == 3) {
            // submission categories
            $("#category-automotive").removeClass('d-none');
            $("#category-automotive").load(
                "submissioncategory_automotive", function() {

                }
            );

            // scales
            $("#scales-automotive").removeClass('d-none');
            $("#scales-automotive").load(
                "scales_automotive", function() {

                }
            );
        } else if (modelType == 4) {
            // submission categories
            $("#category-armor").removeClass('d-none');
            $("#category-armor").load(
                "submissioncategory_armor", function() {

                }
            );

            // scales
            $("#scales-armor").removeClass('d-none');
            $("#scales-armor").load(
                "scales_armor", function() {

                }
            );
        } else if(modelType == 5) {
            // submission categories
            $("#category-figures").removeClass('d-none');
            $("#category-figures").load(
                "submissioncategory_figures", function() {

                }
            );

            // scales
            $("#scales-figures").removeClass('d-none');
            $("#scales-figures").text("There are no scales for Figures.");
        } else if (modelType == 6) {
            // submission categories
            $("#category-trains").removeClass('d-none');
            $("#category-trains").load(
                "submissioncategory_trains", function() {

                }
            );

            // scales
            $("#scales-trains").removeClass('d-none');
            $("#scales-trains").load(
                "scales_trains", function() {

                }
            );
        } else if (modelType == 7) {
            // submission categories
            $("#category-dioramas").removeClass('d-none');
            $("#category-dioramas").load(
                "submissioncategory_dioramas", function() {

                }
            );

            // scales
            $("#scales-dioramas").removeClass('d-none');
            $("#scales-dioramas").load(
                "scales_dioramas", function() {

                }
            );
        } else if(modelType == 8) {
            // submission categories
            $("#category-space").removeClass('d-none');
            $("#category-space").load(
                "submissioncategory_spacecraft", function() {

                }
            );

            // scales
            $("#scales-space").removeClass('d-none');
            $("#scales-space").text("There are no scales for Spacecraft/Sci-Fi.");
        }
    });
});
document.addEventListener("DOMContentLoaded", function(event){
    var modal = document.getElementById("myModal");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // This button will increment the value
    $('[data-quantity="plus"]').click(function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('data-field');
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        var maxVal = parseInt($('input[name='+fieldName+']').attr('max'));
        // If is not undefined && current value is below the maxt
        if (!isNaN(currentVal)) {
            console.log(maxVal);

            // Set value to max if number is bigger than max
            if(currentVal >= maxVal) {
                // Show message that value is maxed
                modal.style.display = "block";
                if(fieldName == "body_care") {
                    $('p[name=popup]').text('Value of '+ fieldName +' can\'t be greater than ' + maxVal);

                }
                else {
                    $('p[name=popup]').text('Value of '+ fieldName +' can\'t be greater than ' + maxVal);
                }
                $('input[name='+fieldName+']').val(maxVal)
                // When the user clicks on <span> (x), close the modal
                document.body.addEventListener('click', function() {
                    modal.style.display = "none";
                }, true); 

            }
            // Check which field to see with how much we increment it
            if(fieldName != 'meat' && fieldName != 'fish') {
                // if value is below max
                if(currentVal < maxVal) {
                    // Increment
                    $('input[name='+fieldName+']').val(currentVal + 1);
                }
            }
            else {
                if(currentVal < maxVal) {
                    $('input[name='+fieldName+']').val(currentVal + 100);
                }
            }
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
        }
    });
    // This button will decrement the value till 0
    $('[data-quantity="minus"]').click(function(e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('data-field');
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        var maxVal = parseInt($('input[name='+fieldName+']').attr('max'));
        // If it isn't undefined or its greater than 0
        if (!isNaN(currentVal) && currentVal > 0) {
            // Set value to max if value is bigger than max
            if(currentVal > maxVal) {
                $('span[name=' + fieldName +']').text('Value can\'t be greater than ' + maxVal);
                console.log( $('span[name=' + fieldName +']'));
                // $('input[name='+fieldName+']').val(maxVal)
            }
            if(fieldName != 'meat' && fieldName != 'fish') {
                // Decrement one
                $('input[name='+fieldName+']').val(currentVal - 1);
            }
            else {
                $('input[name='+fieldName+']').val(currentVal - 100);
            }
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
        }
    });
});
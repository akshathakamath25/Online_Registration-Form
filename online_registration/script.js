$(document).ready(function() {
    $('#registrationForm').on('submit', function(event) {
        event.preventDefault();  // Prevents the form from submitting normally
  
        var formData = $(this).serialize();  // Serialize form data
  
        $.ajax({
            url: 'submit_form.php',  // PHP script to handle form submission
            type: 'POST',
            data: formData,
            success: function(response) {
                try {
                    var data = JSON.parse(response); // Parse JSON response
                    if (data.error) {
                        alert(data.error);  // Show error if fields are missing
                    } else {
                        $('#result').show();
                        $('#submittedName').text('Name: ' + data.name);
                        $('#submittedEmail').text('Email: ' + data.email);
                        $('#submittedAge').text('Age: ' + data.age);
                        $('#submittedPhone').text('Phone: ' + data.phone);
                        $('#submittedAddress').text('Address: ' + data.address);
                    }
                } catch (e) {
                    alert("Error parsing response: " + e.message);
                }
            },
            error: function() {
                alert('There was an error processing the form.');
            }
        });
    });
  });
  
  
$(document).on('click', '#registernav', function(){

    $('#regdialog').empty();
    $('#regdialog').removeClass();
    $('#password').val("");
    $('#firstname').val("");
    $('#confirm').val("");
    $('#user').val("");
    $('#pass').val("");
    $('#accounttype').val("");
    $('#accesscode').val("");

    $('#registerformdiv').hide();
    $('#registerinitial').show();
});
$(document).on('click', '#registerinitialstudent', function(){
    $('#registerformdiv').show();
    $('#registerinitial').hide();
    $('.student-only-form').show();
    $('.teacher-only-form').hide();
    $('#accounttype').val("student");
});
$(document).on('click', '#registerinitialteacher', function(){
    $('#registerformdiv').show();
    $('#registerinitial').hide();
    $('.student-only-form').hide();
    $('.teacher-only-form').show();
    $('#accounttype').val("teacher");
});
$(document).on('click', '#registersubmit', function(){
	$('#registersubmit').attr("disabled", true);
    $('#regdialog').empty();
    $('#regdialog').removeClass();
	$.ajax({
        type: "POST",
        url: "users.php/register",
        data: $("#registerform").serialize(), // serializes the form's elements.
        success: function(data)
        {
            var jsonObject = JSON.parse(data);
            //use json to update dialog box and inform user of success or failure
            if(jsonObject.message == "Success."){
                $('#regdialog').addClass('alert alert-success');
                $('#regdialog').prepend("<center>"+"Success. You can now log in."+"</center>");
                $('#pass').val("");
                $('#confirm').val("");
                $('#user').val("");
                
                $('#registersubmit').attr("disabled", false);
            
            }else{
                $('#regdialog').addClass('alert alert-danger');
                $('#regdialog').prepend("<center>"+jsonObject.message+"</center>");
                $('#registersubmit').attr("disabled", false);
            }
            
        }
        });
});
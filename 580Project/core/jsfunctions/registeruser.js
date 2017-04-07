$(document).on('click', '#registernav', function(){

    $('#regdialog').empty();
    $('#regdialog').removeClass();
    $('#password').val("");
    $('#confirm').val("");
    $('#user').val("");
    $('#pass').val("");
});
$(document).on('click', '#registersubmit', function(){
	$('#registersubmit').attr("disabled", true);
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
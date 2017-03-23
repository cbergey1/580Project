$(document).on('click', "#loginnav", function(){
  $('#logindialog').empty();
  $('#logindialog').removeClass();
});
$(document).on("click", '#loginsubmit', function() {
  $('#logindialog').empty();
  $('#logindialog').removeClass();

 $.ajax({
      type: "POST",
      url: "users.php/login",
      data: $("#loginform").serialize(), // serializes the form's elements.
      success: function(data){   
          var jsonObject = JSON.parse(data);
          //use json to update dialog box and inform user of success or failure
          if(jsonObject.message == "Success"){
            //reloads page to change navbar to logged in navbar
             window.location.replace("index.php");
          }else{
             $('#logindialog').addClass('alert alert-danger');
             $('#logindialog').prepend("<center>"+jsonObject.message+"</center>");
          }
      }
  });
return false;
});
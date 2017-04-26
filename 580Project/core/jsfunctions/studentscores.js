//change this to id of the navbar selection
$(document).on('click', '#studentscoresmodallink', function(){
	$("#studentscorestablebody").empty();
	$.ajax({
        type: "GET",
        url: "users.php/studentscores",
        success: function(data)
        {
            var jsonObject = JSON.parse(data);
            //use json to update dialog box and inform user of success or failure
            if(jsonObject.success == true){
                
                for(i = 0; i<jsonObject.scores.length; i++){
                    
                    var tablestring = "";
                    
                    tablestring = tablestring.concat("<tr><td><center>"+jsonObject.scores[i].studentid+"</center></td>");
                    if(jsonObject.scores[i].countvert != -1){
                        tablestring = tablestring.concat("<td><center>"+jsonObject.scores[i].countvert+"</center></td>");
                    }else{
                        tablestring = tablestring.concat("<td><center>Not Attempted</center></td>");
                    }
                    if(jsonObject.scores[i].countshape != -1){
                        tablestring = tablestring.concat("<td><center>"+jsonObject.scores[i].countshape+"</center></td>");
                    }else{
                        tablestring = tablestring.concat("<td><center>Not Attempted</center></td>");
                    }
                    if(jsonObject.scores[i].simpleadd != -1){
                        tablestring = tablestring.concat("<td><center>"+jsonObject.scores[i].simpleadd+"</center></td>");
                    }else{
                        tablestring = tablestring.concat("<td><center>Not Attempted</center></td>");
                    }
                    if(jsonObject.scores[i].simplesub != -1){
                        tablestring = tablestring.concat("<td><center>"+jsonObject.scores[i].simplesub+"</center></td>");
                    }else{
                        tablestring = tablestring.concat("<td><center>Not Attempted</center></td>");
                    }
                    if(jsonObject.scores[i].simplespell != -1){
                        tablestring = tablestring.concat("<td><center>"+jsonObject.scores[i].simplespell+"</center></td>");
                    }else{
                        tablestring = tablestring.concat("<td><center>Not Attempted</center></td>");
                    }
                    if(jsonObject.scores[i].simplerhyme != -1){
                        tablestring = tablestring.concat("<td><center>"+jsonObject.scores[i].simplerhyme+"</center></td>");
                    }else{
                        tablestring = tablestring.concat("<td><center>Not Attempted</center></td></tr>");
                    }

                    
                    $("#studentscorestablebody").append(tablestring);
                    
                }

            
            }else{
               alert("failure");
            }
            
        }
        });
});
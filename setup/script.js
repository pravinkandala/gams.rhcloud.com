$(document).ready(function() {
    $("#next").click(function() {


        var dbuname = $("#dbuname").val();
        var dbpass = $("#dbpass").val();
        var dbname = $("#dbname").val();
        var date = $("#date").val();



        // Returns successful data submission message when the entered information is stored in database.
        var dataString = 'uname=' + dbuname + '&pass=' + dbpass + '&dname=' + dbname + '&smdt=' + date;
        if (dbuname == '' || dbname == '' || dbpass == '' || date == '') {
            alert("Please Fill All Fields");
        } else {
            //AJAX code to submit form.
            $.ajax({
                type: "POST",
                url: "users.php",
                data: dataString,
                cache: false,
                success: function(result) {
                    //alert(result);
                    $("#contain").html(result);
                }
            });
        }



        return false;
    });
});









$('#contain').on('click', '#next1', function() {
    var sec2 = $("#sections").val();
    var sec3 = $("#sections3").val();
    var sec4 = $("#sections4").val();
    var nosub = $("#num-members").val();
    var nosub3 = $("#num-members3").val();
    var nosub4 = $("#num-members4").val();
    var i;
    var arr = new Array();

    for (i = 0; i < nosub; i++) {
        arr.push($("#sub" + i).val());

    }
    
    var jsonOut = '{ "2" : { "sec":"'+sec2+'", "nosub":"'+nosub+'" , "subs":'+JSON.stringify(arr)+'}';
    arr=[];
    for (i = 0; i < nosub3; i++) {
        arr.push($("#sub3" + i).val());
    }
    jsonOut += ', "3" : { "sec":"'+sec3+'", "nosub":"'+nosub3+'" , "subs":'+JSON.stringify(arr)+'}';
    arr=[];
    for (i = 0; i < nosub4; i++) {
        arr.push($("#sub4" + i).val());
    }
    jsonOut += ', "4" : { "sec":"'+sec4+'", "nosub":"'+nosub4+'" , "subs":'+JSON.stringify(arr)+'} }';
    
     
    
     /*var jsonOut = { 
                        sec: sec2,
                        nosub:nosub,
                        subs : arr ,
                    };*/
 

    var dataString = 'sec=' + sec2 + '&nosub=' + nosub;
    if (sec2 == '' || nosub == '' ) {
        alert("Please Fill All Fields");
    } 
    else {
        //AJAX code to submit form.
        
        /*
       var jsonstr = JSON.stingify(jsonOut);
        */
        $.ajax({
            type: "POST",
            url: "submit1.php",
            data: jsonOut,
            cache: false,
            contentType: "application/json",
            success: function(result) {
                //alert(result);
                $("#contain").html(result);
            }
        });
    }
    return false;
});




$(document).on('click', '#next0', function()
{
    
    var nosub = $("#num-members").val();
    var i;
    var jsonArr = new Array();
    var temp = new Array();

    for (i = 0; i < nosub; i++) {

        temp=[]
        temp.push($("#name" + i).val());
        temp.push($("#pass"+i).val());
        if(document.getElementById('admin'+i).checked)
        {
            temp.push("Administrator");
        }
        else if(document.getElementById('user'+i).checked)
        {    temp.push("User");
        }
        jsonArr.push(temp);        

    }

    console.log(JSON.stringify(jsonArr));

    $.ajax({
            type: "POST",
            url: "submit.php",
            data: JSON.stringify(jsonArr),
            cache: false,
            contentType: "application/json",
            success: function(result) {
                //alert(result);
                $("#contain").html(result);
            },
            error: function(result){ console.log(result);}
        });

});



//$(body).on('click', '#next0', function() {
  //  alert("HELLO 1");
    /*var nosub = $("#num-members").val();
    
    var i;
    var usr = new Array();
    var pass = new Array();
    var ust = new Array();
alert("HELLO");
    for (i = 0; i < nosub; i++) {
        usr.push($("#name" + i).val());
        pass.push($("#pass"+i).val());
        pass.push($("#btn"+i).val());
        alert("Bye");

    }

    
    var jsonOut = '{ "2" : { "sec":"'+sec2+'", "nosub":"'+nosub+'" , "subs":'+JSON.stringify(arr)+'}';
    arr=[];
    for (i = 0; i < nosub3; i++) {
        arr.push($("#sub3" + i).val());
    }
    jsonOut += ', "3" : { "sec":"'+sec3+'", "nosub":"'+nosub3+'" , "subs":'+JSON.stringify(arr)+'}';
    arr=[];
    for (i = 0; i < nosub4; i++) {
        arr.push($("#sub4" + i).val());
    }
    jsonOut += ', "4" : { "sec":"'+sec4+'", "nosub":"'+nosub4+'" , "subs":'+JSON.stringify(arr)+'} }';
    
     

     /*var jsonOut = { 
                        sec: sec2,
                        nosub:nosub,
                        subs : arr ,
                    };
 

  /*  var dataString = 'sec=' + sec2 + '&nosub=' + nosub;
    if (sec2 == '' || nosub == '' ) {
        alert("Please Fill All Fields");
    } 
    else {
        //AJAX code to submit form.
        
        /*
       var jsonstr = JSON.stingify(jsonOut);
        */
  /*      $.ajax({
            type: "POST",
            url: "submit1.php",
            data: jsonOut,
            cache: false,
            contentType: "application/json",
            success: function(result) {
                //alert(result);
                $("#contain").html(result);
            }
        });
    }
    return false;
});*/










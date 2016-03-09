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
                url: "submit.php",
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
    var nosub = $("#num-members").val();
    var i;
    var arr = new Array();

    for (i = 0; i < nosub; i++) {
        arr.push($("#sub" + i).val());

    }
    console.log(arr);

    var dataString = 'sec=' + sec2 + '&nosub=' + nosub;
    if (sec2 == '' || nosub == '' ) {
        alert("Please Fill All Fields");
    } 
    else {
        //AJAX code to submit form.
        $.ajax({
            type: "POST",
            url: "submit1.php",
            data: dataString,
            cache: false,
            success: function(result) {
                //alert(result);
                $("#contain1").html(result);
            }
        });
    }
    return false;
});
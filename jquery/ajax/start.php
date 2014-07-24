<!DOCTYPE html>
<html>
<head>
	<title>ajax_complete_example</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript">
	//ajax request
	$.ajax({
	type : "POST",
	url	 : "destination.php",
    data : {
                        name       	: "name",
                        email  		: "email",
                        company 	: "company",
                        phone       : "+91-9873252330",
                        country 	: "country",
                        state     	: "state",
     },
   	dataType : "json",
	beforeSend : function(){
	console.log(" :::: before_send ::::");
	           	 },
	timeout: 10000,
	success :function(response){
			console.log(" :::: success ::::");	
			console.log(response);
	},
   	error: function(x, t, m) {
       if(t==="timeout") {
           alert("got timeout");
       } else {
           alert(t);
       }
   	}	
	}); //ajax over
	</script>
</head>
<body>
see console
</body>
</html>
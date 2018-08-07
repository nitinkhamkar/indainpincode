   <?php 
	if (isset($_GET['pincode'])) {
		$pincode=$_GET['pincode'];
	$lines = file_get_contents("http://postalpincode.in/api/pincode/$pincode");
    echo $lines;
    exit;
           
    }
    ?>
<!DOCTYPE html>
<html>
<title> API example </title>
<head>
<link rel="stylesheet" type="text/css" href="public\bootstrap.min.css">
<script src="public\jquery-3.1.0.min.js"></script>
<style type="text/css">
	html, body {
  height: 100%;
}



.vertical-center {
  min-height: 100%;  /* Fallback for vh unit */
  min-height: 100vh; /* You might also want to use
                        'height' property instead.
                        
                        Note that for percentage values of
                        'height' or 'min-height' properties,
                        the 'height' of the parent element
                        should be specified explicitly.
  
                        In this case the parent of '.vertical-center'
                        is the <body> element */

  /* Make it a flex container */
  display: -webkit-box;
  display: -moz-box;
  display: -ms-flexbox;
  display: -webkit-flex;
  display: flex; 
  
  /* Align the bootstrap's container vertically */
    -webkit-box-align : center;
  -webkit-align-items : center;
       -moz-box-align : center;
       -ms-flex-align : center;
          align-items : center;
  
  /* In legacy web browsers such as Firefox 9
     we need to specify the width of the flex container */
  width: 100%;
  
  /* Also 'margin: 0 auto' doesn't have any effect on flex items in such web browsers
     hence the bootstrap's container won't be aligned to the center anymore.
  
     Therefore, we should use the following declarations to get it centered again */
         -webkit-box-pack : center;
            -moz-box-pack : center;
            -ms-flex-pack : center;
  -webkit-justify-content : center;
          justify-content : center;
}
div { margin:20px;
    display: block;
}

/*.container {
  background: SILVER;
}*/
.footer {
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    background-color: black;
    color: white;
    text-align: center;
}
.table th {
   text-align: center;   
}

</style>
	



</head>
<body>
	<div class="container text-center jumbotron" style="margin-top:40px;margin-bottom:40px;border-radius: 15px">
      
  
        <div class= "text-center text-dark text-success">
        <h1>Pincode API for india</h1></div>
	    <div style="background-color: white;">  

            <div class="row">
			      	<div class="col-md-2">
					  <label  class="form-control-md" style="font-size: 21px;" for="apipincode"><strong>Enter Pincode:</strong></label>
					</div>
			
				
					<div class="col-md-2">
					   <input class="form-control form-control-md" type="text" id="apipincode" value=""   required/>
					</div>

					<div class="col-md-2">
					  <button type="button"  id="getpin" class="btn btn-primary" onclick="callpin();" >Search</button> 
					</div>
		    </div>
		</div> 

		<div style="background-color: white;">  		 
			 <div class="row">
					  <div class="table-responsive" style="border-radius:10px;    margin-bottom: 40px;">
					  <table  class="table-striped table" style="width:100%; ">
					  	<thead>
					  	<tr>
					  		<th>Sr No.</th>
					  		<th>Post Office</th>
					  		<th>Block/Taluka</th>
					  		<th>District</th>
					  		<th>State</th>
					  		<th>Country</th>
					  	</tr>
					  </thead>
					  <tbody id="dattb">
					  </tbody>
						
					  </table>
					 
					  </div>
					 
	        </div>
	    </div>
        <div class="col-md-12 footer" >
 		<h5>Helo</h5>
		</div>
	 
				  
</div>


       	
<script type="text/javascript">
	function callpin(){
	   
     $("#dattb").children("tr").remove();
    var pincode=$('#apipincode').val();
    
    var village= new Array();
    var taluka=new Array();
  //  var objkey= new Array();
    var cnt=0;
    var district;
    var state;
    var country;
   if (pincode == "")
    alert('please fill the required field')
  else if (isNaN(pincode)== true)
    alert('please enter number only!')
  else if (pincode.length <6 ||pincode.length >6) 
    alert('please enter only six digit');
  else{
      
   //Ajax Load data from ajax
        $.ajax({
    //    url : "api_test.php",
        data:{pincode:pincode},
        type: "GET",
        dataType: "JSON",
        beforeSend: function() {
        $("#getpin").prop('disabled',true);
        },
        success: function(data)
        {   
          $("#getpin").prop('disabled',false);
       // var response=JSON.parse(data); 
         var response=data; 
         if(response.Status=='Error')
         {
            $("#dattb").append("<tr><td colspan='6'>"+ response.Message+"! it  seems wrong pin</td></tr>");
         }else{
         appendTableColumn(response.PostOffice);
       }

 
        
      /*  $.each(response.PostOffice[0], function(k, v) {
         objkey.push(k);
        });*/
     
   /*     var temp='';
	    for (i in response.PostOffice) {	
		    village.push((response.PostOffice[i].Name));
		    
            if(temp!=response.PostOffice[i].Taluk)
            {
             taluka.push((response.PostOffice[i].Taluk));
            }
		   
		    temp=response.PostOffice[i].Taluk;
		    
            if(cnt==0)
            {
		  //  taluka=response.PostOffice[i].Taluk;
    		district=response.PostOffice[i].District;
     		state=response.PostOffice[i].State;
     		country=response.PostOffice[i].Country;
         	}
         cnt++;
  	    }


// usage example:

         var taluka_un = taluka.filter( onlyUnique );
	     var JSONObj = { "village":village, "taluka":taluka_un,"district ":district, "state":state,"country":country };

        console.log(JSONObj);*/

          
          /*   $('[name="ad_id"]').val(data.id);
             $('select[name="post_id"]').val(data.designation_id).change();*/
      
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert(errorThrown);
        }
        });

    }  //else 


 /* // jQuery preflight request
const Http = new XMLHttpRequest();
const url='http://postalpincode.in/api/pincode/413701';
Http.open("GET", url);
//Http.setRequestHeader( 'Access-Control-Allow-Origin', '*');
//Http.setRequestHeader( 'Content-Type', 'application/json' );
Http.send();

Http.onreadystatechange=(e)=>{
 rescall(Http.responseText);
}    */
 
}
function appendTableColumn(response){
	$.each(response, function(i,row){
      $("#dattb").append("<tr><td>" + (++i) + "</td><td>" + (response[i].Name) + "</td><td>" + response[i].Taluk + "</td><td>"+ response[i].District + "</td><td>"+ response[i].State + "</td><td>"+ response[i].Country + "</td></tr>");
   //  console.log(row);
    
    })

                  
}
 function onlyUnique(value, index, self) { 
    return self.indexOf(value) === index;
}
 
	   </script>

</body>

</html>
<script>
    
    var Stable=new Array();
    var dtable=new Array();
    
function source()
  {
      
    var e = document.getElementById("source");
    var strUser = e.options[e.selectedIndex].value;
    document.getElementById("stab").innerHTML="";
   // alert(strUser);   
    
    daySelect = document.getElementById('stab');       
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() { 
    if (xhttp.readyState == 4 && xhttp.status == 200)
    {
         var c = JSON.parse(xhttp.responseText);
          // alert(c.length);
        for(var i=0;i<c.length;i++)
        {
             myOption = document.createElement("option");
             myOption.text = c[i];
             myOption.value = c[i];
             daySelect.appendChild(myOption);

        }
        
    }
  };
      xhttp.open("GET", "process.php?q=" + strUser, true);
      xhttp.send();
      
 
}


    
    
function dest()
  {
      
    var e = document.getElementById("destination");
    var strUser = e.options[e.selectedIndex].value;
    document.getElementById("dtab").innerHTML="";
   // alert(strUser);   
    
    daySelect = document.getElementById('dtab');       
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() { 
    if (xhttp.readyState == 4 && xhttp.status == 200)
    {
         var c = JSON.parse(xhttp.responseText);
        //   alert(c.length);
        for(var i=0;i<c.length;i++)
        {
             myOption = document.createElement("option");
             myOption.text = c[i];
             myOption.value = c[i];
             daySelect.appendChild(myOption);

        }
        
    }
  };
      xhttp.open("GET", "process.php?q=" + strUser, true);
      xhttp.send();
 
}

    
    
    
    
    
    
function destination(){
 
    
    var e = document.getElementById("destination");
    var strUser = e.options[e.selectedIndex].value;
    document.getElementById("dtab").innerHTML="";
   // alert(strUser);
    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      var c = JSON.parse(xhttp.responseText);
      //  alert(c);
        
    }
  };
  xhttp.open("GET", "process.php", true);
  xhttp.send();
 
}
    
    
    function Extract()
    {
      
        var method=" ";
        
        var element = document.getElementById("source");
        var src1 = element.value;
        
          var element = document.getElementById("destination");
          var dst1 = element.value;
          var element = document.getElementById("stab");
          var src = element.value;
        
         var element = document.getElementById("dtab");
         var dst = element.value;
       
        if(document.getElementById("ovr").checked)
            method="overwrite";
        else
            method="append";
        
        
     //   alert("Source"+" "+src1+" "+"Dest"+" "+dst1); //This will track which source and which dest database is
        
        var e = document.getElementById("stab");
        var STable= e.options[e.selectedIndex].value;
        
        var e = document.getElementById("dtab");
        var DTable = e.options[e.selectedIndex].value;
        
              
        
       // alert(STable+" "+DTable);
        
       
        var jsonString = JSON.stringify(STable);
        var jsonString2 = JSON.stringify(DTable);
        src1=JSON.stringify(src1);
        dst1=JSON.stringify(dst1);
        method=JSON.stringify(method);
        
        $.ajax({
        type: "POST",
        url: "desprocss.php", 
        data: {data : jsonString,data1:jsonString2,Source:src1,Dest:dst1,meth:method}, //bhai dekho isme mene 4 values pass ke ha
        cache: false,

        success: function(data){ //aur ye success function ha ye tab call hoga jab waha se to echo me ya koi chez return kar rha hoga
            get(data);
        }
    }) ;
        
    }
    
    function get(data){
        document.getElementById("my").innerHTML=data;
        document.getElementById("my").showModal();
       // alert(data);
    }

    
    
    
    

</script>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>DataWare Housing</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom Google Web Font -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>

    <!-- Add custom CSS here -->
    <link href="css/landing-page.css" rel="stylesheet">
    
    <style>
    
        b{
           color: aliceblue; 
        }
    
    </style>

</head>

<body>

   
    <div class="intro-header">

        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-message">
                        <h1>Data Warehousing</h1>
                        
                        <hr class="intro-divider">
                        <ul class="list-inline intro-social-buttons">
                            <li>
                                <select name="destination" class="form-control" id="source" onchange="source()">
                                   <option>Source Database</option>
                                    <?php
		                     $link = mysql_connect("localhost" , "root" , "code13") or die("We couldn't connect to server");
		                     $res = mysql_query("SHOW DATABASES");
		                     while ($row = mysql_fetch_assoc($res)) {
			                    echo '<option value="'.$row['Database'].'">'.$row['Database'].'</option>';
		                      }
	                         ?>
                                    
                                    </select>
                            </li>
                            <li>
                                <select name="stab" class="form-control" id="stab">
                                    <option selected>Source Table</option>
                                    
                                                    </select>
                            </li>
                            <li>
                                <select name="destination" class="form-control" id="destination" onchange="dest()">
                                    <option>Destination Database</option>
                                    
                                    <?php
		                     $link = mysql_connect("localhost" , "root" , "code13") or die("We couldn't connect to server");
		                     $res = mysql_query("SHOW DATABASES");
		                     while ($row = mysql_fetch_assoc($res)) {
			                    echo '<option value="'.$row['Database'].'">'.$row['Database'].'</option>';
		                      }
                                    ?>
                                                                   
                                </select>
                            </li>
                            
                            <li>
                                <select name="dtab" class="form-control" id="dtab">
                                    <option selected>Destination Table</option>
                                    
                                </select>
                            </li>
                            <br><br>
                            <label class="radio-inline">
                             <input type="radio" name="optradio" id="ovr"><b>overwrite</b>
                              </label>
                            <label class="radio-inline">
                          <input type="radio" name="optradio" id="app"><b>Append</b>
                            </label>
                            <br><br>
                            <button type="button" class="btn btn-primary btn-lg" onclick="Extract()">Extract</button>
                            <dialog id="my">This is a dialog window</dialog>
                            
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.intro-header -->

    
    
    <!-- JavaScript -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.js"></script>

</body>

</html>

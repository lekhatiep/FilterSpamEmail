<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tool lọc email</title>
    <!-- Latest compiled and minified CSS -->
    <link rel='shortcut icon'  href='processing/abc.png' />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/style.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
 <div class="container">
    <div class="row">
      <div class="col-md-12"><h3 class="text-center">Lọc email</h3></div>
      <div class="col-md-5">
<div id="here"></div>     
             <label>Chọn file mail spam,block...</label>
             <input class="form-control" type="file" name="file" id="file" accept=".csv">

             <br>
             <textarea readonly class="form-control" name="" id="uploaded_file1" cols="30" rows="10"></textarea>
             <div id="content" style="display:none;"></div>
              <button id="btn_loadfilter" class="btn btn-success">Load List email filter</button>
      </div>
      <div class="col-md-2" style="margin-top: 100px">
       
      </div>
      <div class="col-md-5">          
             <label>Danh sách mail</label>
             <input  class="form-control" type="file" name="file2" id="file2" accept=".csv">
             <br>
             <textarea readonly class="form-control" id="uploaded_file2" cols="30" rows="10"></textarea>
             <div id="content2" style="display: none"></div>
             <button id="btn_allemail" class="btn btn-success">Load all email</button>
            <!--  <button id="update">Cập nhật danh sách</button> -->
      </div>
      <div class="col-md-12" style="margin-top: 50px">
              <button id="btnsosanh" class="btn btn-primary btn-block" name="btn" onclick="sosanh()">Filter Email</button>
      </div>
      <div class="col-md-12">
            <div id="dsemail" class="form-control" style="display: none"></div>
             <a id="downfile" class="btn btn-success" href="#" onclick='downloadCSV({file:"stock-data.csv"});'>Down file csv</a>
      </div>
      
    </div>

<progress  id="prog" value="0" max="100" style="display: none"></progress>
<div id="here"></div>
 </div> 
 <script>
  
 </script>
    <script type="text/javascript" src="assets/js/main.js"></script>
    <script type="text/javascript" src="assets/js/jquery.form.min.js"></script>
    <script type="text/javascript">
      function sosanh(){
        // document.getElementById('btnsosanh').style.display="block";
        var string1 = document.getElementById('content').textContent;
        var string2 = document.getElementById('content2').textContent;
        var array1 = string1.split(" ");
        var array2 = string2.split(" ");   
        for(i=0; i<array1.length; i++){
          for(j=0; j<array2.length; j++){
            if(array1[i] == array2[j]){
              array1.splice(i,1);
              array2.splice(j,1);
              i-=1;
              j-=1;
            }
          }
        }
          var new_Arr = array1.concat(array2);
          console.log(new_Arr);
          var arremail=new_Arr;
          var listemail=new Array();
          for(i=0;i<arremail.length;i++)
          {
              listemail.push({"email":arremail[i]});
          }
          console.log(listemail);
          var jsonObject = JSON.stringify(listemail);
          var array = typeof jsonObject !='object'?JSON.parse(jsonObject):jsonObject;
          var str='';
          for(i=0;i<=array.length;i++){
            var line='';
            for(index in listemail[i]){
              if(line =!'') line+=','
                line +=listemail[i][index];
            }
            str +=line+'\r\n';
          }
          //console.log(str); 
          document.getElementById('dsemail').innerHTML=new_Arr.join('\r\n');
          
      }
      function downloadCSV(args){
          var data, filename,link;
          var csv =document.getElementById('dsemail').textContent;
          if(csv == null) return;
          filename = args.filename || 'email.csv';
          if(!csv.match(/^data:text\/csv/i)){
             csv ='data:text/csv;charset=utf-8,'+csv;
          }
          data = encodeURI(csv);
          link = document.createElement('a');
          link.setAttribute('href',data);
          link.setAttribute('download',filename);
          link.click();
      }
    </script>
</body>
</html>
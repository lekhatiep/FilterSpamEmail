$(document).ready(function(){
	$(document).on('change','#file',function(){
		var property = document.getElementById("file").files[0];
		var file_name = property.name;
		var file_extension = file_name.split('.').pop().toLowerCase();
		var file_size = property.size;
		if(jQuery.inArray(file_extension,['csv','xlsx'])== -1){
			alert("Chỉ hỗ trợ file định dạng CSV, XLSX");
			return false;
		}
		if(file_size>4000000)
		{
			alert("Dung lượng file tối đa 2M");
		}
		else
		{
			if(jQuery.inArray(file_extension,['csv'])== 0){
				var form_data = new FormData();
				form_data.append("file",property);
				$.ajax({
					url:'import-db',
					method:"post",
					data:form_data,
					contentType:false,
					cache:false,
					processData:false,
					beforeSend:function(){
						$('#uploaded_file1').html(" File are uploading...");
						
					},
					success:function(data){
						console.log(data);
						alert(data)
					}
				});
			}
			else
			{
				var form_data = new FormData();
				form_data.append("file",property);
				$.ajax({
					url:'psxls1.php',
					method:"post",
					data:form_data,
					contentType:false,
					cache:false,
					processData:false,
					beforeSend:function(){
						$('#uploaded_file1').html("<label class='text-success'> file are uploading...</label>");
					},
					success:function(data){
						// alert(data);
						$('#uploaded_file1').html(data);
						$('#content').html(data);
					}
				});
			}
		}
	});
	$(document).on('change','#file2',function(){
		var property = document.getElementById("file2").files[0];
		var file_name = property.name;
		var file_extension = file_name.split('.').pop().toLowerCase();
		if(jQuery.inArray(file_extension,['csv','xlsx'])== -1){
			alert("Chỉ hỗ trợ file định dạng CSV, XLSX");
			return false;
		}
		var file_size = property.size;
		if(file_size>4000000)
		{
			alert("Dung lượng file tối đa 2M");
		}
		else
		{
			if(jQuery.inArray(file_extension,['csv'])== 0)
			{
				var form_data = new FormData();
				form_data.append("file2",property);
				$.ajax({
					url:'import-email',
					method:"post",
					data:form_data,
					contentType:false,
					cache:false,
					processData:false,
					beforeSend:function(){
						$('#uploaded_file2').html("File are uploading...");
					},
					success:function(data){
						
					}
				});
			}
			else{
				var form_data = new FormData();
				form_data.append("file2",property);
				$.ajax({
					url:'psxls2.php',
					method:"post",
					data:form_data,
					contentType:false,
					cache:false,
					processData:false,
					beforeSend:function(){
						$('#uploaded_file2').html("<label class='text-success'> Img uploading...</label>");
					},
					success:function(data){
						// alert(data);
						$('#uploaded_file2').html(data);
						$('#content2').html(data);
					}
				});
			}
			
		}
	});

	$(document).on('click','#btnsosanh',function(){
		if($('#content').text() =='' && $('#content2').text() =='')
		{
			alert('vui long kiem tra file up');	
		}
		else{
			$('#downfile').css("display","block");		
		}
	});
	$(document).on('click','#btn_allemail',function(){
		$.ajax({
			url:'showallemail',
			contentType:false,
			cache:false,
			processData:false,
			success:function(data){
				 if($.trim(data))
				 {
				 	$('#uploaded_file2').html(data);
					$('#content2').html(data);
				 }
				 else{
				 	$('#uploaded_file2').html("No data");
				 }
			}
		});
	});
	$(document).on('click','#btn_loadfilter',function(){
		$.ajax({
			url:'show',
			contentType:false,
			cache:false,
			processData:false,
			success:function(data){
				 if($.trim(data))
				 {
				 	$('#uploaded_file1').html(data);
					$('#content').html(data);
				 }
				 else{
				 	$('#uploaded_file1').html("No data");
				 }
			}
		});
	});

});

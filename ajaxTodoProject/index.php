<?php

include_once('db.php');

$query = "select * from contact";
$res = mysqli_query($con,$query);
?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
	<link rel="stylesheet" href="styles.css">
	<script src="https://cdn.tailwindcss.com"></script>
	<title>Ajax todo</title>
</head>
<body class="">
<div class="modal-container">
	<div class="modal-box">
		<button class="text-red-500 text-gray-100 close-btn"id="close-btn">
			<i class="fas fa-times-circle"></i>
		</button>
		<div class="modal-header">
			<h1 class="pt-5">
				abuse
			</h1>
		</div>
		<div class="modal-body" id='modalBody'>
		  <form id="submitBtn">
			</form>

			<form id='editBtn'>

			</form>

		</div>	  	
	</div>		
</div>
<div class="container mx-auto">

	<h1 class="text-center text-2xl uppercase py-3 border-b border-indigo-500 text-fuchsia-900 font-semibold">Todo </h1>
	<div class="container">
			<div class="">
				<button type="button" class="capitalize border bg-green-600 text-gray-100 px-2 py-1 mt-2 rounded hover:bg-green-700 shadow" id="modalButton" >add todo</button>
			</div>
				<table class="table-auto border-collapse border border-slate w-full p-2 mt-5 rounded">
				<thead>
					<tr class="bg-sky-900 text-gray-100 text-xl capitalize">
						<th class="border border-slate
						p-2" id='idname'>id</th>
						<th class="border border-slate p-2">name</th>
						<th class="border border-slate p-2">email</th>
						<th class="border border-slate p-2">contact</th>
						<th class="border border-slate p-2" >edit</th>
						<th class="border border-slate p-2">delete</th>

					</tr>
				</thead>
				<tbody id="showData">
				
				</tbody>
			</table>
		</div>
</div>

	<script>
		
		// show todo
		const showProduct = ()=>{
			var xhr = new XMLHttpRequest();
			xhr.open('GET','processing.php?show','true');
			var values = new Array();	
			var show = '';		
			xhr.onload = function(){
				if(this.status == 200){
					
					values = JSON.parse(this.responseText);
					
					for(i in values){
						var id=values[i].id;
						show+="<tr class='text-black-100  text-xl'>";
						show+="<td  class='border border-slate p-5' id='btnId'>"+values[i].id+"</td>"
						+ "<td  class='border border-slate p-5'>"+ values[i].name+ "</td>"+
						"<td  class='border border-slate p-5'>"+ values[i].email+"</td>"+
						"<td  class='border border-slate p-5'>"+ values[i].phone+"</td>"+
						"<td  class='border border-slate p-5'>"+
						"<button class='bg-green-500 px-2 rounded text-gray-100 hover:bg-green-600' onclick='editTodo("+id+")'>edit</button>"+
						"</td>" + "<td class='border border-slate p-5'  >" + "<button class='bg-red-500 px-2 rounded text-gray-100 hover:bg-red-600' id='deleteBtn' onclick='deleteTodo("+id+")'>delete</button>" + "</td>";
						show+="</tr>";

						
					}
					document.getElementById('showData').innerHTML = show;
					console.log(document.getElementById('btnId').innerText);

				}
			}
			xhr.send();
		}
		showProduct();

		// show modal
		document.getElementById('modalButton').addEventListener('click',()=>{
		  	addHtml = '<input class="mt-2 px-2 " type="text" required id="name"        placeholder="name..." name="">'+
				'<input class="my-2 px-2 py-1" type="text" required id="email" name="" placeholder="email...">'+
				'<input  class="mb-2 px-2 " type="text" required id="phonenumber" name="" placeholder="phonenumber....">'
				+'<button class="bg-green-500 text-gray-100 border border-green-500 px-1 py-1 text-xl rounded hover:bg-green-700 transition" type="submit">submit</button>';
			document.getElementById('editBtn').innerHTML = "";
			document.getElementById('submitBtn').innerHTML = addHtml;

	  	document.querySelector('.modal-container').style.display = 'block';
		})
		// hide modal
		document.getElementById('close-btn').addEventListener('click',()=>{
		document.querySelector('.modal-container').style.display = 'none';
		})
		// add todo

		document.getElementById('submitBtn').addEventListener('submit',(e)=>{
			e.preventDefault();
			var name = document.getElementById('name').value;
			var email = document.getElementById('email').value;
			var phonenumber = document.getElementById('phonenumber').value;

	    document.querySelector('.modal-container').style.display = 'none';
      var params = "name="+name+"&email="+email+"&phonenumber="+phonenumber;
			var xhr = new XMLHttpRequest();
			xhr.open('POST','processing.php?addTodo','true');
			xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
			xhr.onload = function(){
				if(this.status == 200){
					showProduct();
				}
			}
			xhr.send(params);
			document.getElementById('name').value = "";
			document.getElementById('email').value = "";
			document.getElementById('phonenumber').value = "";

		})

		// delete todo
		function deleteTodo(id){
			const idValue = parseInt(id);
			var xhr = new XMLHttpRequest();
			xhr.open('GET',"processing.php?deleteId="+idValue,true);
			xhr.onload=function(){
				if(this.status == 200){
					//console.log(this.responseText);
					showProduct();
				}
			}
			xhr.send();
		}

		// Get Single product by id
		function getSingleProduct(id){
			var xhr = new XMLHttpRequest();
			var value;
			xhr.open('GET','processing.php?editId='+id,true);
			xhr.onload = function(){
				if(this.status == 200){
					value = JSON.parse(this.responseText);

					addHtml = '<input class="mt-2 px-2 " type="text" required id="name" value="'+ value.name +'" placeholder="name..." name="">'+
					'<input class="my-2 px-2 py-1" type="text" required id="email" name="" value ="'+ value.email +'" placeholder="email...">'+
					'<input  class="mb-2 px-2 " type="text" required id="phonenumber" value="'+ value.phone +'" name="" placeholder="phonenumber....">'
					+'<button class="bg-green-500 text-gray-100 border border-green-500 px-1 py-1 text-xl rounded hover:bg-green-700 transition">edit</button>';
					document.getElementById('editBtn').innerHTML = addHtml;
					document.getElementById('submitBtn').innerHTML = "";
					document.querySelector('.modal-container').style.display = 'block';
				}
			}
			xhr.send();

			

		}

    // edit product
		function editTodo(id){
			id = parseInt(id);
			getSingleProduct(id)
			    // whenever editBtn is clicked

				document.getElementById('editBtn').addEventListener('submit',(e)=>{
					e.preventDefault();
					const name =document.getElementById('name').value;
					const email =document.getElementById('email').value;
					const phonenumber =document.getElementById('phonenumber').value;
					var params = "name="+name+"&email="+email+"&phonenumber="+phonenumber;
					var xhr1 = new XMLHttpRequest();
					xhr1.open("POST","processing.php?editedId="+id,true);
					xhr1.setRequestHeader('Content-type','application/x-www-form-urlencoded');
					xhr1.onload = function(){
						if(this.status == 200){
							console.log(this.responseText);
							//
							document.getElementById('name').value = "";
							document.getElementById('email').value = "";
							document.getElementById('phonenumber').value = "";
					    document.querySelector('.modal-container').style.display = 'none';
							id=0;
							showProduct();
						}
					}
					xhr1.send(params);
					
					

				})
				showProduct();
		}

	</script>



</body>
</html>
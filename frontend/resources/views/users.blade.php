<!DOCTYPE html>
<html lang="vi">

<head>
<meta charset="UTF-8">
<title>Quản lý Users</title>

<style>
body{
 font-family: Arial;
 background:#f4f6f9;
}

.container{
 width:700px;
 margin:auto;
 margin-top:50px;
 background:white;
 padding:20px;
 border-radius:10px;
 box-shadow:0 0 10px rgba(0,0,0,0.1);
}

h2{
 text-align:center;
}

input{
 padding:10px;
 border:1px solid #ccc;
 border-radius:5px;
}

#name{
 width:200px;
}

button{
 padding:8px 12px;
 border:none;
 border-radius:5px;
 cursor:pointer;
}

.add{
 background:#28a745;
 color:white;
}

.edit{
 background:#ffc107;
}

.delete{
 background:red;
 color:white;
}

table{
 width:100%;
 border-collapse:collapse;
 margin-top:20px;
}

th,td{
 padding:10px;
 border-bottom:1px solid #ddd;
 text-align:center;
}

th{
 background:#007bff;
 color:white;
}

.search{
 margin-left:20px;
}
</style>

</head>

<body>

<div class="container">

<h2>Quản lý Users</h2>

<input type="text" id="name" placeholder="Nhập tên">
<button class="add" onclick="addUser()">Thêm</button>

<input type="text" id="search" class="search" placeholder="Tìm user..." onkeyup="searchUser()">

<table>
<thead>
<tr>
<th>ID</th>
<th>Tên</th>
<th>Hành động</th>
</tr>
</thead>

<tbody id="list"></tbody>

</table>

</div>

<script>

const API = "https://xdpmweb-d2i0.onrender.com";

let users=[];

function loadUsers(){

 fetch(API + "/users")
 .then(res=>{
  if(!res.ok){
   throw new Error("Server error: "+res.status);
  }
  return res.json();
 })
 .then(data=>{
  users=data;
  renderUsers(data);
 })
 .catch(err=>{
  console.error(err);
  alert("Không tải được dữ liệu từ API");
 });

}

function renderUsers(data){

 let html="";

 data.forEach(u=>{

  html+=`
  <tr>
   <td>${u.id}</td>
   <td>${u.name}</td>
   <td>
    <button class="edit" onclick="editUser(${u.id})">Sửa</button>
    <button class="delete" onclick="deleteUser(${u.id})">Xóa</button>
   </td>
  </tr>
  `;

 });

 document.getElementById("list").innerHTML=html;

}

function addUser(){

 const name=document.getElementById("name").value.trim();

 if(name===""){
  alert("Tên không được để trống");
  return;
 }

 fetch(API + "/users",{

  method:"POST",
  headers:{
   "Content-Type":"application/json"
  },
  body:JSON.stringify({name:name})

 })
 .then(res=>res.json())
 .then(()=>{
  document.getElementById("name").value="";
  loadUsers();
 });

}

function deleteUser(id){

 if(!confirm("Bạn chắc chắn muốn xóa?")) return;

 fetch(API + "/users/"+id,{
  method:"DELETE"
 })
 .then(()=>loadUsers());

}

function editUser(id){

 const name=prompt("Nhập tên mới");

 if(!name) return;

 fetch(API + "/users/"+id,{

  method:"PUT",
  headers:{
   "Content-Type":"application/json"
  },
  body:JSON.stringify({name:name})

 })
 .then(()=>loadUsers());

}

function searchUser(){

 const keyword=document.getElementById("search").value.toLowerCase();

 const filtered=users.filter(u =>
  u.name.toLowerCase().includes(keyword)
 );

 renderUsers(filtered);

}

loadUsers();

</script>

</body>
</html>
const express = require("express");
const mysql = require("mysql2");
const cors = require("cors");

const app = express();

app.use(cors());
app.use(express.json());

const db = mysql.createConnection(process.env.DATABASE_URL);

db.connect(err=>{
 if(err){
  console.log("Database error:",err);
 }else{
  console.log("Connected MySQL");
 }
});
app.get("/", (req, res) => {

 res.send(`
  <h2>Danh sách nhóm đăng ký</h2>
git remote add origin https://github.com/NTD2K3IT/xdpmweb.git
  <ul>
  <li><a href="https://ctxh.free.nf/">Giao diện trang chủ</a></li>
   <li><a href="/users">Tất cả usres</a></li>
   <li><a href="/users/1">Users 1</a></li>
   <li><a href="/users/2">Users 2</a></li>
   <li><a href="/users/3">Users 3</a></li>
  </ul>
 `);

});

// Lấy danh sách users
app.get("/users",(req,res)=>{

 db.query("SELECT * FROM users",(err,result)=>{

  if(err) return res.send(err);

  res.json(result);

 });

});

// Lấy user theo id
app.get("/users/:id",(req,res)=>{

 const id = req.params.id;

 db.query("SELECT * FROM users WHERE id=?",[id],(err,result)=>{

  if(err) return res.send(err);

  res.json(result);

 });

});


// Thêm user
app.post("/users",(req,res)=>{

 const name = req.body.name;

 db.query("INSERT INTO users(name) VALUES(?)",[name],(err,result)=>{

  if(err) return res.send(err);

  res.json({
   message:"User added",
   id: result.insertId
  });

 });

});


// Xóa user
app.delete("/users/:id",(req,res)=>{

 const id = req.params.id;

 db.query("DELETE FROM users WHERE id=?",[id],(err,result)=>{

  if(err) return res.send(err);

  res.json({
   message:"User deleted"
  });

 });

});
// Sửa user
app.put("/users/:id",(req,res)=>{

 const id = req.params.id;
 const name = req.body.name;

 db.query(
  "UPDATE users SET name=? WHERE id=?",
  [name,id],
  (err,result)=>{

   if(err) return res.send(err);

   res.json({
    message:"User updated"
   });

  }
 );

});

const PORT = process.env.PORT || 3000;

app.listen(PORT,()=>{
 console.log("Server running on port", PORT);
});
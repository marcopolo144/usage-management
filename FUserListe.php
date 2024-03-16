<?php include("../JULIANA/Head/index.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
          
        <div class="col-lg-4 shadow-sm bg-body">
           <h6 class="bg-body">
            <div class="alert alert-danger error_message alert-dismissible fade show mt-2" role="alert" style="display:none">
            <strong>Holy guacamole!</strong> You should check in on some of those fields below.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="alert alert-success success_message alert-dismissible fade show mt-2" role="alert" style="display:none">
            <strong>Holy guacamole!</strong> You should check in on some of those fields below.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            </h6>
           <form action="POST" id="datas" class="form-vertical ">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username">
                <span class="text-danger" id="verify"></span>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email">
            </div>

            <div class="input-box">
                <label for="passwor">Password</label><br>
               <h6 class="input-group">
               <input type="password" name="password" class="form-control w-75" id="password">
                <i class="far fa-eye-slash mt-3" id="eye"></i>
               </h6>
            </div>

            <div class="form-group">
                <label for="photo">Image</label>
                <input type="file" class="form-control" name="photo" id="photo">
            </div>

            <button class="btn btn-secondary btn-sm float-end mt-2" type="button" id="register">Register</button>
            <br><br>
        </form>
           </div>

           <div class="col-lg-8">
                <table class="table table-striped  shadow-sm bg-body">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>    
                        </tr>
                    </thead>
                    <tbody id="usercontainer"></tbody>
                    <tfoot>
                        <tr>
                            <td id="userT"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
          </div>
    </div>
    <script>
           $(document).ready(function(){
        alert("oouoououo")
    })
function show_message(status,message,durree){
    if(status==200){
      var msg_box=document.querySelector('.success_message');
    }else{
      var msg_box=document.querySelector('.error_message');
    }
    msg_box.innerHTML=message;
    msg_box.style.display='block';
    setTimeout(function(){
    msg_box.style.display='none';
    },durree)
  }

    </script>
</body>
</html>
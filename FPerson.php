<?php include('../JULIANA/Head/index.php') ;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
 <div class="mt-5 container">
 <div class="row">
  <div class="col-lg-8 offset-md-2">
  <div class="panel panel-default">
  <div class="panel-body input-group">
    <div class="error_message bg-body alert-danger" style="display:none"></div>
    <div class="success_message bg-body alert-success" style="display:none"></div>
    <input type="text" id="search" class="form-control">
    &nbsp     &nbsp
    <input type="hidden" id="pagination" class="form-control">
    &nbsp     &nbsp
    <input type="hidden" id="total" class="form-control">
      
    <button class="btn btn-primary btn-sm" type="button" onclick="show_modal()"><i class="fas fa-plus"></i></button>
  
  </div>
</div>
  </div>
 </div>
  <div class="row">
    <div class="col-lg-8 offset-md-2">
      <table class="table table-bordered bg-light mt-2 " id="tablep">
        <thead class="mt-2 bg-danger">
          <tr>
            <th>Image</th>
            <th>Code</th>
            <th>Full Name</th>
            <th>Date Register</th>
            <th>Date Leave</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="container"></tbody>
      </table>
    </div>
  </div>
 </div>



<div class="modal" tabindex="-1" id="modals">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">INFO GENERAL</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onClick="hide_modal();"></button>
      </div>
      <div class="modal-body">
      <form action="POST" id="datas">
                <div class="form-group">
                   <label for="codep">Code</label>
                   <input type="text" class="form-control codep"  name="codepd" id="codep" disabled="disabled">
                   <input type="hidden" class="form-control codep"  name="codep" id="codep">
                </div>

                <div class="form-group">
                   <label for="namep">Name</label>
                   <input type="text" class="form-control"  name="namep" id="namep" >
                </div>

                <div class="form-group">
                   <label for="firstnamep">FirstName</label>
                   <input type="text" class="form-control"  name="firstnamep" id="firstnamep" >
                </div>

                <div class="form-group">
                   <label for="birthday">Birthday</label>
                   <input type="date" class="form-control date"  name="birthdayp"  id="birthdayp">
                </div>

                <div class="form-group">
                   <label for="birthday">Datecreted</label>
                   <input type="date" class="form-control date"  name="datecreated" id="datecreated">
                </div>

                
                <div class="form-group">
                   <label for="photo">Photo</label>
                   <input type="file" class="form-control"  name="photo" id="photo">
                </div>

                <button class="btn-sm btn-primary btn mt-2 float-endx" type="button" id="savePerson">Save</button>
                <button class="btn-sm btn-primary btn mt-2 float-end" type="button" id="updatePerson">Update</button>

            </form>
      </div>
     
    </div>
  </div>
</div>

    <script>
      $(function(){
    $('#datecreated').prop('min', function(){
        return new Date().toJSON().slice(0,10).split('/').reverse().join('-');
    });
});
        save()
        getCodep()
        getAll()
        Edit()
        update()
        Delete()
        pagination()
        function getCodep(){
            $.ajax({
                url:'DatasPerson.php',
                method:'POST',
                data:{action:'getCode'},
                success:function(response){
                  $('.codep').val(response)
                }
            })
        }

      
        function getAll(champ=null,page=null){
         
          const d="IMAGES/";
            var container=document.getElementById('container');
            var pagination=document.getElementById('pagination');
            var total=document.getElementById('total');
            document.getElementById('search').addEventListener('keyup',getAll);
            champ=  document.getElementById('search').value;
            
            $.ajax({
                url:'DatasPerson.php',
                method:'POST',
                data:{action:'AllPerson',champ:champ,page:page},
                dataType:'json',
                success:function(response){
                 // alert(response)
                  if(response.data.length > 0){
                    total.innerHTML=" Total Register   :"+response.data.length;
                    pagination.innerHTML=response.pagination;
                    container.innerHTML=""
                    for (i in response.data) {
                     var rows=document.createElement('tr');
                     rows.innerHTML=`
                     <td><img src=${d+response.data[i].photo} width="50px" height="40px" ></td>
                     <td>${response.data[i].codep.replace(champ.toUpperCase(),'<span class="text-danger">$&</span>')}</td>
                     <td>${response.data[i].firstnamep +' &'+ response.data[i].namep.replace(champ.toUpperCase(),'<span class="text-danger">$&</span>')}</td>
                     <td>${new Date(response.data[i].datecreated).toJSON().slice(0,10).split('-').reverse().join('/')}</td>
                     <td>${new Date(response.data[i].dateleave).toJSON().slice(0,10).split('-').reverse().join('/')}</td>
                     <td><span class="btn btn-primary btn-sm btn_edit" type="button" codep=${response.data[i].codep}><i class="fas fa-edit"></i></span>
                     <span class="btn btn-danger btn-sm btn_delete" type="button" codep=${response.data[i].codep}><i class="fas fa-trash"></i></span></td>
                     `
                     container.appendChild(rows) 
                    }
                  }else{
                    container.innerHTML="No data to display";
                  }
                }
            })
        }
        function save(){
          $(document).on('click','#savePerson',function(){
            datas=new FormData($('#datas')[0]);
            datas.append('action','savePerson');
            $.ajax({
              url:'DatasPerson.php',
                method:'POST',
                cache:false,
                contentType:false,
                processData: false,
                data:datas,
                dataType:'json',
                success:function(response){
                  show_message(response.status,response.message,3000)
                    $('#datas')[0].reset()
                    getAll()
                    getCodep()
                    hide_modal()
                }
            })
          })
        }

        function show_modal(){
          var modal=document.getElementById("modals");
          modal.style.display='block';
          modal.style.top='30px'
        }

        
        function hide_modal(){
          var modal=document.getElementById("modals");
          modal.style.display='none';
        }

        function show_message(status,message,durree){
          if(status==200){
            var msg_box=document.querySelector('.success_message');
             document.getElementById('search').style.display='none';
          }else{
            var msg_box=document.querySelector('.error_message');
            document.getElementById('search').style.display='none';

          }
          msg_box.innerHTML=message;
          msg_box.style.display='block';
          setTimeout(function(){
          msg_box.style.display='none';
          document.getElementById('search').style.display='block';



          },durree)

        }

        function Edit(){
         $(document).on('click','.btn_edit',function(){
          var codep=$(this).attr('codep');
          $.ajax({
                url:'DatasPerson.php',
                method:'POST',
                data:{action:'Edit',codep:codep},
                dataType:'json',
                success:function(response){
                  $('.codep').val(response.codep)
                  document.getElementById('namep').value=response.namep;
                  document.getElementById('firstnamep').value=response.firstnamep;
                  document.getElementById('birthdayp').value=response.birthdayp;
                  document.getElementById('datecreated').value=response.datecreated;
                  
                  show_modal()
                  
                }
            })
         })
        }



        
        function Delete(){
         $(document).on('click','.btn_delete',function(){
          var codep=$(this).attr('codep');
          if(confirm("Are you sure delete this data????????")){
            $.ajax({
                url:'DatasPerson.php',
                method:'POST',
                data:{action:'Delete',codep:codep},
                dataType:'json',
                success:function(response){
                  show_message(response.status,response.message,3000)
                  getAll()
                  getCodep()
                  //hide_modal()
                  
                }
            })
          }
         })
        }

        function update(){
          $(document).on('click','#updatePerson',function(){

            datas=new FormData($('#datas')[0]);
            datas.append('action','updatePerson');
            $.ajax({
              url:'DatasPerson.php',
                method:'POST',
                cache:false,
                contentType:false,
                processData: false,
                data:datas,
                dataType:'json',
                success:function(response){
                  show_message(response.status,response.message,3000)
                    $('#datas')[0].reset()
                    getAll()
                    getCodep()
                    hide_modal()
                }
            })
          })
        }
        function pagination(){
          $(document).on('click','.page',function(){
            var page=$(this).attr('page');
            getAll('',page)
          })
        }
    </script>
</body>
</html>
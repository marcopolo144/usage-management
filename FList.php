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
            <div class="col-lg-10 offset-md-1 table-responsive">
            <h6><input type="text" class="w-50 m p-2 border-2" id="campo"> <select name="" id="" class="float-end w-25 m p-2 border-2"></select></h6>
                <table class="table table-striped table-sm bg-body shadow-lg mt-2" id="mytable">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>FirstName</th>
                            <th>Birthday</th>
                            <th>Register Date</th>
                            <th>Leave Date</th>
                            <th>Spent Day</th>
                            <th>Rest Day</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="container"></tbody>
                    <tfoot>
                      <tr>
                        <td>Total</td>
                        <td colspan="9" id="nT" class="bg-info"></td>
                      </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>


    <div class="modal" tabindex="-1" id="info">
    <div class="modal-dialog modal-dialog-centered  modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">DESCRIBE PEOPLE</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


   <script>
    getTRestDay()
    function getTRestDay(){
        var container=document.getElementById('container');
        var nT=document.getElementById('nT');
        document.getElementById('campo').addEventListener('keyup',  getTRestDay);
        var campo=document.getElementById('campo').value;
        $.ajax({
            type: "POST",
            url: "DatasPerson.php",
            data: {action:'getRestDay',campo:campo},
            dataType: "json",
            success: function (response) {
              //alert(response)
              container.innerHTML="";
               nT.innerHTML=response.data.length;
                if(response.data.length > 0){
                  for(i in response.data){
                    var rows=document.createElement('tr');
                    rows.innerHTML=`
                    <td>${response.data[i].codep}</td>
                    <td>${response.data[i].namep}</td>
                    <td>${response.data[i].firstnamep}</td>
                    <td>${response.data[i].birthdayp}</td>
                    <td>${new Date(response.data[i].datecreated).toJSON().slice(0,10).split('-').reverse().join('/')}</td>
                    <td>${new Date(response.data[i].dateleave).toJSON().slice(0,10).split('-').reverse().join('/')}</td>
                    <td>${response.data[i].spentday}</td>
                    <td>${response.data[i].restday}</td>
                    <td><button class="btn btn-primary btn-sm float-end" type="button"><i class="fas fa-plus"></i></button></td>
                    
                    `;
                    container.appendChild(rows)
                  }
                }else{
                    container.innerHTML='No dat to displaY';
                }
            }
        });
    }
    $(document).on('click','tbody tr',function(){
        var info=document.getElementById('info');
       
    var n0=$(this).find('td:eq(0)').text();
    var n1=$(this).find('td:eq(1)').text();
    var n2=$(this).find('td:eq(2)').text();
    var n3=$(this).find('td:eq(3)').text();
    var n4=$(this).find('td:eq(4)').text();
    var n5=$(this).find('td:eq(5)').text();
    var n6=$(this).find('td:eq(6)').text();
    var n7=$(this).find('td:eq(7)').text();
    var n8=$(this).find('td:eq(8)').text();
    $('.modal-body').html(`
    <ol class="list-group">
    <li class="list-group-item d-flex justify-content align-items-start">
    <div class="ms-2 me-auto"> 
     ID
    </div>
    <span class="badge bg-primary rounded-pill">${n0}</span>
  </li>
  <li class="list-group-item d-flex justify-content align-items-start">
    <div class="ms-2 me-auto"> 
     Name
    </div>
    <span class="badge bg-primary rounded-pill">${n1}</span>
  </li>

  <li class="list-group-item d-flex justify-content align-items-start">
    <div class="ms-2 me-auto"> 
     Name
    </div>
    <span class="badge bg-primary rounded-pill">${n2}</span>
  </li>

  <li class="list-group-item d-flex justify-content align-items-start">
    <div class="ms-2 me-auto"> 
     Birthday
    </div>
    <span class="badge bg-primary rounded-pill">${n3}</span>
  </li>

  <li class="list-group-item d-flex justify-content align-items-start">
    <div class="ms-2 me-auto"> 
     Register Date
    </div>
    <span class="badge bg-primary rounded-pill">${n4}</span>
  </li>

  <li class="list-group-item d-flex justify-content align-items-start">
    <div class="ms-2 me-auto"> 
  Leave Date
    </div>
    <span class="badge bg-primary rounded-pill">${n5}</span>
  </li>

  
  <li class="list-group-item d-flex justify-content align-items-start">
    <div class="ms-2 me-auto"> 
   Spent Day
    </div>
    <span class="badge bg-primary rounded-pill">${n6}</span>
  </li>

  <li class="list-group-item d-flex justify-content align-items-start">
    <div class="ms-2 me-auto"> 
   Rest Day
    </div>
    <span class="badge bg-primary rounded-pill">${n7}</span>
  </li>

</ol>
    `)
    $("#info").modal('show');

    })
   </script> 
</body>
</html>
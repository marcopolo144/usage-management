<?php include('../JULIANA/Head/index.php') ;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
        <div class="col">
     <div class="bg-light" style="none">
      <span class="alert-danger error_message" style="display:none"></span>
      <span class="alert-success success_message" style="display:none"></span>

     </div>
            <div class="col-md-5 shadow-sm offset-md-4">
                <form action="POST" class="form-horizontal" id="datas">
                    <div class="form-group">
                        <input type="file" name="photo" id="photo" class="form-control">
                    </div>

                    <div class="form-group mt-2">
                        <textarea name="desp" id="" cols="10" rows="4" class="form-control"></textarea>
                    </div>

                    <div class="form-group mt-2">
                        <button type="button" class="float-end btn btn-primary" id="save">save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        save()
  function save(){
          $(document).on('click','#save',function(){
            datas=new FormData($('#datas')[0]);
            datas.append('action','saveImage');
            $.ajax({
              url:'DatasPerson.php',
                method:'POST',
                cache:false,
                contentType:false,
                processData: false,
                data:datas,
                dataType:'json',
                success:function(response){
                    //alert(response)
                  //show_message(response.status,response.message,3000)
                    $('#datas')[0].reset()
                   
                }
            })
          })
        }
        getimage()
        function getimage(){
            $.ajax({
                url:'DatasPerson.php',
                method:'POST',
                data:{action:'getImage'},
                success:function(response){
                
                }
            })
        }
    </script>
</body>
</html>
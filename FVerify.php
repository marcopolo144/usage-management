<?php include('../JULIANA/Head/index.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <div class="container mt-5  col-md-8 offset-md-2">
    <fieldset>
   
  <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3">
    <div class="col-5">
      <div class="p-3 border bg-light"><input type="text" class="form-control  border-4" maxlength="8" style="text-transform: uppercase" id="search" placeholder="enter user Id">
      <span class="text-danger" style="display:nones" id="message"></span>
    
    </div>
    </div>
  
   
    <div class="col-7">
      <div class="p-3 border bg-light text-justify" id="text">
      <div class="accordion accordion-flush bg-body shadow-lg" id="accordionFlushExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingOne">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
      How to search user ??
      </button>
    </h2>
    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body text-bold">To search for a user, simply enter the user ID</div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
        Accordion Item #2
      </button>
    </h2>
    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
        Accordion Item #3
      </button>
    </h2>
    <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the third item's accordion body. Nothing more exciting happening here in terms of content, but just filling up the space to make it look, at least at first glance, a bit more representative of how this would look in a real-world application.</div>
    </div>
  </div>
</div>
      </div>
    </div>
    
  </div>
  </fieldset>
</div>
<script>
    $(document).ready(function () {
    
        getSearch()
     
      
      function getSearch(){
        const d="IMAGES/";
        var data=$('#text').html();
        $('#search').keyup(function (e) { 
           var text=e.target.value;
           $("#message").text('No data for this ID :' +text.toUpperCase())

            if(text.length >=6){
                $("#message").show()

            }else{
                $("#message").hide()

            }
           if(text.length >=5){
            $.ajax({
                type: "POST",
                url: "DatasPerson.php",
                dataType:'json',
                data: {text:text,action:'Search'},
                success: function (response) {
                 if(response.codep){
                $("#message").hide()
                  $('#text').html(`
                  <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                   Code
                        <span class="badge bg-primary rounded-pill">${response.codep}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                    Name
                        <span class="badge bg-primary rounded-pill">${response.namep}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                       FirstName
                        <span class="badge bg-primary rounded-pill">${response.firstnamep}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                     Register Date
                     <span class="badge bg-primary rounded-pill">${new Date(response.datecreated).toJSON().slice(0,10).split('-').reverse().join('/')}</span>

                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                       Date Leave
                        <span class="badge bg-primary rounded-pill">${new Date(response.dateleave).toJSON().slice(0,10).split('-').reverse().join('/')}</span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                    <img src=${d+response.photo}  width="400px" heigth="150px"/>
                    </li>
                    </ul>
                  
                  `)
                 }else{
                    $('#text').html(data)
                 }
                }
            });
           }else{

           }
        });
      }
    })
</script>
</body>
</html>
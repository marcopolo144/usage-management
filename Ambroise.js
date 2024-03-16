check();
register();

var verify="JULIANA";
function check(){
  $(document).on("keyup","#username",function(){
    var mot=$(this).val() ? $(this).val() :$("#username").val();
    if(mot.length >=8){
        $.ajax({
            type: "POST",
            url: "DatasUser.php",
            data:{mot:mot},
            dataType: "json",
            success: function (response) {
               if(response.username){
                verify=response.username;
            
                $("#verify").text("username not availlable")
               }else{
                verify="JULIANA";
                $("#verify").text("")
               }
            }
        });
    }
  })
}
//fin show paassword
function register(){
    $(document).on("click","#register",function(){
     
        var F=new FormData($("#datas")[0]);
        F.append('action','saveUser');
        if(verify=="JULIANA"){
            $.ajax({
                type: "POST",
                url: "DatasUser.php",
                Cache:false,
                processData: false,
                contentType: false,
                data:F,
                dataType: "json",
                success: function (response) {
                    $("#datas")[0].reset();
                show_message(response.status,response.message,3000);  
                }
             });
        }else{
            $("#verify").text("username not availlable") 
        }
    })
} 


window.onload=function(){
    
    getUser()
    $(document).on('click','.btn-delete',function(){
        var id=$(this).attr('id');
        var F=new FormData();
        F.append('action','delete');
        F.append('id',id);
        if(confirm("Are you sure to delete this data ????")){
            $.ajax({
                type: "POST",
                url: "DatasUser.php",
                Cache:false,
                processData: false,
                contentType: false,
                data:F,
                dataType: "json",
                success: function (response) {
                    '<object type="text/html" data="FUserListe.php"></object>'
                }
             });
        }
    })
    }   

//get user
function getUser(){
    var F=new FormData();
    F.append('action','getUser');
    $.ajax({
        type: "POST",
        url: "DatasUser.php",
        Cache:false,
        processData: false,
        contentType: false,
        data:F,
        dataType: "json",
        success: function (response) { 
            //alert(response)
            if(response.data.length > 0){
                $('#usercontainer').html('');
               // containeruser.innerHTML="";
               $('#userT').text('Total :' + response.data.length);
                for(i in response.data){
                    var rows=document.createElement('tr');
                    rows.innerHTML=`
                    <td>${response.data[i].id}</td>
                    <td>${response.data[i].username}</td>
                    <td>${response.data[i].email}</td>
                    <td class=${response.data[i].status==1 ? 'bg-primary a' :'bg-danger a'}>${response.data[i].status ==1 ? 'Active' : 'bg-danger'}</td>
                    <td>
                     <button class="btn btn-primary btn-sm btn-edit" id=${response.data[i].id}><i class=" fas fa-edit"></i></button>
                     <button class="btn btn-danger btn-sm btn-delete" id=${response.data[i].id}><i class=" fas fa-trash"></i></button>
                    </td>`;
                    $('#usercontainer').append(rows);
                }

            }else{
                $('#usercontainer').html("<tr><td>NO data to display</td></tr>");
            }
        }
     });
}




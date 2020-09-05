$(document).ready(function(){
    
    ClassicEditor
        .create( document.querySelector( '#body' ) )
        .catch( error => {
            console.error( error );
        } );

        
        $('#selectAllBoxes').click(function(event){

            if(this.checked){
    
                $('.checkBoxes').each(function(){
    
                    this.checked = true;
    
                })
            }else{
    
                $('.checkBoxes').each(function(){
    
                    this.checked = false;
    
                })
    
    
            }
        });

        $(".delete_link").on('click', function(){
            let id = $(this).attr("rel");
            let delete_url = "posts.php?delete="+id+" ";
            $('#Modal').modal();
            $(".modal_delete_link").attr("href", delete_url);
            
        });

       
        

});


// let div_box = "<div id='load-screen'><div id='loading'></div></div>";
// $('body').prepend(div_box);

// $('#load-screen').delay(700).fadeOut(600, function(){
//     $(this).remove();
// });




function loadUsersOnline(){
    $.get("functions.php?onlineusers=result", function(data){
        $(".useronline").text(data);
    });
}

setInterval(function(){
    loadUsersOnline();
}, 500);
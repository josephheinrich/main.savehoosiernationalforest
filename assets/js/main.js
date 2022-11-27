function deletePost(div) {
    if (confirm("Are you sure you want to delete this post?")) {
    console.log("clicked");
    var postID = this.id;
    console.log(div.id);
    $.ajax({

        url : '../../archive/deletepost.php?postID=' + div.id,
        type : 'POST',
        success : function (result) {
           console.log (result); // Here, you need to use response by PHP file.
           location.reload();
        },
        error : function () {
           console.log ('error');
        }
   
      });
    }
}

function registeredSuccess() {
        $.ajax({
    
            url : '../../sendEmail.php',
            type : 'POST',
            success : function (result) {
               console.log ("registered success: " + result); // Here, you need to use response by PHP file.
            },
            
            error : function () {
               console.log ("registered success: " + 'error');
            }
       
          });
}
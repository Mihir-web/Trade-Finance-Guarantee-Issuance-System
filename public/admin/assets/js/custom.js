$(function () {
	$.ajaxSetup({
		cache: false,
		headers: {
			"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
		}
	});
	
	setTimeout(function(){
		$('.alert-dismissible').remove();
	}, 2000);

$('.delete_record').on('click', function(e){
    e.preventDefault();
    var rid = $(this).attr('rid');
    let url = $(this).attr('href');
    swal({
        title: "Are you sure?",
        text: "Want to delete this record",
        icon: "warning",
        buttons: ["Cancel", "Yes, Delete!"],
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: url,
                type: 'POST',
                data: {id: rid},
                success: function(res){
                    location.reload();
                }
            })
        }
    });
})


$('.delete_notifications').on('click', function(e){
    e.preventDefault();
    var uid = $(this).attr('uid');
    let url = $(this).attr('href');
    swal({
        title: "Are you sure?",
        text: "Want to delete all notifications",
        icon: "warning",
        buttons: ["Cancel", "Yes, Delete!"],
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: url,
                type: 'POST',
                data: {user_id: uid},
                success: function(res){
                    location.reload();
                }
            })
        }
    });
})

$('.publish_status').on('change', function(){
    var rid = $(this).attr('rid');
    let url = $(this).attr('url');
    let status = $(this).val();

        $.ajax({
                url: url,
                type: 'POST',
                data: {id: rid, status: status},
                success: function(res){
                    location.reload();
                }
            });
})

$('.vote_radio').on('change', function(){
    var rid = $(this).attr('rid');
    let url = $(this).attr('url');
    let vote = $(this).val();
    let user_id = $(this).attr('user_id');
    let vote_status ;
    
    if(vote == 1){
        vote_status = "Abstaint";
    }else{
        vote_status = "Against";
    }
    swal({
        title: "Your vote is '"+vote_status+"'",
        text: "Want to submit this vote",
        icon: "warning",
        buttons: ["Cancel", "Submit"],
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: url,
                type: 'POST',
                data: {bill_id: rid, vote: vote, user_id: user_id},
                success: function(res){
                    location.reload();
                }
            });
        }
    });
       
})

});
// $('.fancybox').fancybox({
//     clickContent: 'close',
//     buttons: ['close']
//   })


 setInterval(() => {
        $("#alert_msg").addClass('d-none');    
    }, 3000);


    $('body').on('click','.submitComment',function(e){
        e.preventDefault();
        var id = $(this).val();
        if($('#commenttext'+id).val()==''){
            alert('Please write a Comment First!');
        }
        else{
            var action = $(this).attr('action');
                    var action_get_comment = $(this).attr('action_get_comment');
            var commentForm = $('#commentForm_'+id).serialize();
            $.ajax({
                type: 'POST',
                url: action,
                data: commentForm,
                success: function(data){
                    getComment(id,action_get_comment);
                    $('#commentForm_'+id)[0].reset();
                    $('#view_comment'+id).html(data); 
    
                },
            });
        }
    
    });
    function getComment(id,action_get_comment){
        $.ajax({
            url: action_get_comment,
            data: {bill_id:id},
            success: function(data){
                $('#comment_'+id).html(data); 
                $('#comment_'+id).animate({scrollTop: 800+11100},1200);
            }
        });
    }
    
   
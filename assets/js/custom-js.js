$(document).on('click','#postComment',function(){
  var form = $('#commentForm').serialize();
  var url = $('#commentForm').attr('action');
    $.ajax({
      url:url,
      dataType:'json',
      data:form,
      type:'post',
      beforeSend: function()
      {
        $('.alert_error h1').empty();
        $('.alert_error ul').empty();
      },success:function(data)
      {
        if(data.status == true)
        {
          $('.show_comments').last().append("<p>تم التعليق بنجاح ، الآن نإنتظار المراجعة للنشر.</p>"+data.result);
          $('#commentForm')[0].reset();
        }
      },error:function(data_error,exception)
      {
        if(exception == 'error')
        {
          alert(data_error);
        }
      }
    });
    return false;
  });

  $(document).on('click','#CompComment',function(){
    var form = $('#commentForm').serialize();
    var url = $('#commentForm').attr('action');
      $.ajax({
        url:url,
        dataType:'json',
        data:form,
        type:'post',
        beforeSend: function()
        {
          $('.alert_error h1').empty();
          $('.alert_error ul').empty();
        },success:function(data)
        {
          if(data.status == true)
          {
            $('.show_comments').last().append("<p>تم التعليق بنجاح ، الآن نإنتظار المراجعة للنشر.</p>"+data.result);
            $('#commentForm')[0].reset();
          }
        },error:function(data_error,exception)
        {
          if(exception == 'error')
          {
            alert(data_error);
          }
        }
      });
      return false;
    });

$(".my-rating-6").starRating({
  totalStars: 5,
  emptyColor: 'lightgray',
  hoverColor: 'salmon',
  starSize: 25,
  activeColor: 'cornflowerblue',
  initialRating: 0,
  useFullStars: true,
  strokeWidth: 0,
  useGradient: true,
  readOnly: $(this).attr('data-readonly'),
  callback: function(currentRating, $el){
      var url = $el.attr('data-href');
      var post = $el.attr('data-post-id');
      $.ajax({
      	  headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: url,
          method: 'POST',
          data:{
               post_id: post,
               value: currentRating
          }
      });
  }
});
if($('.my-rating-6[data-readonly="true"]').length){
    $('.my-rating-6[data-readonly="true"]').starRating('setReadOnly', true);
}


$(".my-rating-competition").starRating({
  totalStars: 5,
  emptyColor: 'lightgray',
  hoverColor: 'salmon',
  starSize: 25,
  activeColor: 'cornflowerblue',
  initialRating: 0,
  useFullStars: true,
  strokeWidth: 0,
  useGradient: true,
  readOnly: $(this).attr('data-readonly'),
  callback: function(currentRating, $el){
      var url = $el.attr('data-href');
      var post = $el.attr('data-post-id');
      $.ajax({
      	  headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: url,
          method: 'POST',
          data:{
               sub_id: post,
               value: currentRating
          }
      });
  }
});
if($('.my-rating-competition[data-readonly="true"]').length){
    $('.my-rating-competition[data-readonly="true"]').starRating('setReadOnly', true);
}

$(".my-rating-7").starRating({
  readOnly: true,
  starSize: 25,
  activeColor: 'cornflowerblue',
});
setTimeout(function() {
    $('#flash-message').fadeOut('fast');
}, 5000); // <-- time in milliseconds


$("#likeBtn").on('click',function(){
    var post_id = $(this).data("post");
    var url = $(this).data("url");
    var type = $(this).data("type");
    var clas = $(this).attr('class');

    $.ajax({
    	headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        type:'POST',
        url: url,
        data: {
        	post_id,
        	type
        },
        success: function(){
        	if(clas == 'def_btn')
        	{
        		$('#likeBtn').removeClass('def_btn');
        		$('#likeBtn').addClass('like_btn');	
        	}	
            else
            {
            	$('#likeBtn').removeClass('like_btn');
        		$('#likeBtn').addClass('def_btn');
            }
        }
        
    });
});

$("#favBtn").on('click',function(){
    var post_id = $(this).data("post");
    var url = $(this).data("url");
    var clas = $('#favIcon').attr('class');

    $.ajax({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        type:'POST',
        url: url,
        data: {
          post_id,
        },
        success: function(){
          if(clas == 'fa fa-heart-o fa-3x')
          {
            $('#favIcon').removeClass('fa fa-heart-o fa-3x');
            $('#favIcon').addClass('fa fa-heart fa-3x'); 
          } 
            else
            {
              $('#favIcon').removeClass('fa fa-heart fa-3x');
            $('#favIcon').addClass('fa fa-heart-o fa-3x');
            }
        }
        
    });
});

$(document).on('click','#modalLoginBtn',function(){
var form = $('#modalLogin').serialize();
var url = $('#modalLogin').attr('action');


  $.ajax({
    url:url,
    dataType:'json',
    data:form,
    type:'post',
    success:function(data)
    {
       if(data.status == true)
       {
         location.reload();
          //$('#myModal2').fadeOut('fast');
       }
       else
       {
        $('#myModal2').modal('toggle');
        alert('Date you entered are not true');
       }
    },error:function(data_error,exception)
    {
      if(exception == 'error')
      {
        alert(data_error);
      }
    }
  });    
return false;
});


$(document).on('click','#modalRegisterBtn',function(){
var form = $('#modalRegister').serialize();
var url = $('#modalRegister').attr('action');
  $.ajax({
    headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
    url:url,
    dataType:'json',
    data:form,
    type:'post',

    success:function(data)
    {
       if(data.status == true)
       {
          $('#myModal1').modal('toggle'); window.location.href='';
          // $('#myModal2').modal('show');
          
       }
       else
       {
        $('#myModal1').modal('toggle');
        alert('Date you entered are not true');
       }
    },error:function(data_error,exception)
    {
      if(exception == 'error')
      {
        alert(data_error);
      }
    }
  });    
return false;
});
$('.social-link').on('click', function(){
var target = $(this).attr('data-target');
var href = $(this).attr('data-href');
var text = $(this).attr('data-text');
if(target == 'facebook'){
openWindow('https://www.facebook.com/sharer.php?u='+ href);
}else if(target == 'twitter'){
openWindow('https://twitter.com/intent/tweet?url='+ href + '&text='+text);
}
});

function openWindow(link=null){
window.open(link, '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');
}
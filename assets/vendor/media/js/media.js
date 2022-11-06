$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
// featured img button
$('.featured-image').click(function(e){
    e.preventDefault();
    $('#modalAlert').attr('data-target-id', $(this).attr('data-id') )
    $('#modalAlert').attr('data-custom-type', $(this).attr('data-custom-type') );
    $('#modalAlert').attr('data-multi', $(this).attr('data-multi') );
    $('.img-attachment').removeClass('highlight-img');
    var model = $('#modalAlert');
    model.modal('show');
});

// load latest media
$('#chooseFromMedia').click(function(){ 
    $.ajax({
        type: "get",
        url: routes.base,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function(results){
        var output = '';
        output += '<div class="row"><div class="col-md-12"><div class="white-box" style="max-height: 500px;overflow-y: auto;" >';
        for(let attach in results) {
            var dataSRC = results[attach].src;
            if( results[attach].url.max ){
                dataSRC = results[attach].url.max;
            }else if( results[attach].url.medium ){
                dataSRC = results[attach].url.medium;
            }
            dataSRC = mainURL+'/'+dataSRC;
            output += '<div class="IMGparent">';
            output += ' <img data-width="'+results[attach].width+'" data-src="' + dataSRC + '" alt="' + ( (results[attach].alt && results[attach].alt != null)? results[attach].alt : '') + '"  data-id="' + results[attach].id + '" class="img-responsive img-attachment" src="' + results[attach].src + '" />';
            output += '<span style="display:none;" class="Sdata" data-ID="' + results[attach].ID + '" data-url="' + results[attach].src + '" data-date="' + results[attach].post_modified + '" data-user="' + results[attach].user + '" data-alt="' + results[attach].alt + '"></span>';
            output += '</div>';
        }
    output += '</div></div></div>';

        $('#mediaIMGS').html(output);
    });

});

var order = 0;


$(document).on('click','.img-attachment',function(){

    var multi = $('#modalAlert').attr('data-multi');
    multi = (multi == '1')? false : true;

    var data_src = $(this).attr('data-src');
    var data_alt = $(this).attr('alt');
    var data_id = $(this).attr('data-id');




    $(this).attr( 'data-order',  ++order  );

    var parentID = $('#modalAlert').attr('data-target-id');
    if( !multi ){
        $('.img-attachment').not($(this)).removeClass('highlight-img');
    }

    $(this).toggleClass('highlight-img');
    var selected = $(this).hasClass('highlight-img');

    if( selected ){
        $.ajax({
           url: ExtractLinkVars(routes.get,data_id),
        }).done(function(res){
            appendForm(res);
        });
        parentID.att;
    }else{
        console.log('no');
    }

    /*
    if( $('#modalAlert[data-custom-type="select"]').length > 0 ){
        var parentID = $('#modalAlert').attr('data-target-id');
        if( !multi ){
            $('.img-attachment').not($(this)).removeClass('highlight-img');
        }

        $(this).toggleClass('highlight-img');
        var selected = $(this).hasClass('highlight-img');

        if( selected ){
            $.ajax({
               url: ExtractLinkVars(routes.get,data_id),
            }).done(function(res){
                appendForm(res);
            });
            parentID.att;
        }else{
            console.log('no');
        }
    }else{

        tinyMCE.execCommand( 'mceInsertContent' , false, '<img alt="'+data_alt+'" src="'+data_src+'"/>');
        $('#modalAlert').modal('hide');

    }
    */
});
$('#ok_btn').click(function(){


    var multi = $('#modalAlert').attr('data-multi');
    multi = (multi == '1')? false : true;

    var himg = $('img.highlight-img');
    var data_src = himg.attr('data-src');
    var data_alt = ( himg.attr('alt') )? himg.attr('alt') : '';
    var data_id = himg.attr('data-id');



    
    if( $('#modalAlert[data-custom-type="select"]').length > 0 ){
        

    var outputs = {};
    var parentID = $('#modalAlert').attr('data-target-id');
    var current_multi = $('#modalAlert').attr('data-multi');
    current_multi = (current_multi == '1')? false : true;
    var the_multi_sign = (current_multi)? '[]' : '';
    $('img.highlight-img').each(function(index, value){
        var src   = himg.attr('src');
        var width   = himg.attr('data-width');
        if( width < 600 ){
            alert('يرجى اختيار صورة كبيرة ، لاتقل عرضاً عن 750 بكسل');
            return false;
        }
        var imgID = himg.attr('data-id');
        outputs[himg.attr('data-order')] =  "<div class='featuredImagePlace' ><input type='hidden' name='"+parentID+the_multi_sign+"' value='"+imgID+"' /><img src='"+src+"' /><span class='featuredimgClose'>X</span></div>";

    });

    var output = $.map(outputs, function(value, index) {
        return [value];
    });
    output = output.concat(outputs);
    $('#'+parentID).find('.imgParent').html(output);
    }else{
    if( data_alt.length <= 0 ){
         alert('يرجى كتابة النص البديل ( ALT ) للصورة المختارة ');
         return false;
    }
    tinyMCE.execCommand( 'mceInsertContent' , false, '<img alt="'+data_alt+'" src="'+data_src+'"/>');
    $('#modalAlert').modal('hide');

}
});
$(document).on('click','.featuredimgClose',function(){
    console.log('asdfasdf');
    $(this).parent().remove();
});

if( $('input[media_type=true]').length > 0 ){
    var our_IDs = [];
    $('input[media_type=true]').each(function(){
        our_IDs.push( $(this).val() );
    });
    cosnole.log(our_IDs);
}

$('#altsave').click(function(){
    var alttext = $('#altinput').val();
    var imgID = $('#altinput').attr('data-id');
    $.ajax({
        url: "{{ url('/admin/media/ajaxSaveAlt') }}",
        type:'post',
        data:{
            id: imgID,
            alt: alttext
        },
        success:function(data){
            $('#altoutput').html(data);
            $('img[data-id='+imgID+']').attr('alt', alttext);
        }
    })
})

function ExtractLinkVars(link, val=null, type=1)
{
    let match = link.match(/{(\w+)\??}/);
    if (type == 1) {
        if (typeof val === 'string') {
            return link.replace(match[0], val);
        } else {
            return link.replace(match[0], val[match[1]]);
        }
    } else {
        return match[1] ? match : false ;
    }
}

function appendForm(data){
    var imgSRC = '';
    
    var imgSRC = data.url.tiny;
    if( data.url.max ){
        imgSRC = data.url.max;
    }else if( data.url.medium ){
        imgSRC = data.url.medium;
    }

    var output = '';
    output += '<form data-id="'+data.id+'" style="display: none" id="SelectionForm">';
    output += '<div class="form-group"><span class="output" style=" display: block; text-align: center; "></span>';
    output += '<a href="'+mainURL+'/'+imgSRC+'" target="_blank" style=" display: block; "> رابط الصورة اضغط هنا </a>';
    output += '<label for="">العنوان</label>';
    output += '<input name="title" type="text" class="form-control" value="'+ ((data.title && data.title != null )? data.title : '') +'">';
    output += '</div>';
    output += '<div class="form-group">';
    output += '<label for="">الوصف</label>';
    output += '<input name="description" type="text" class="form-control" value="'+ ((data.description && data.description != null )? data.description : '')   +'">';
    output += '</div>';
    output += '<div class="form-group">';
    output += '<label for="" >النص البديل</label>';
    output += '<input style=" border: 2px solid red; background: grey; color: #fff; " name="alt" type="text" class="form-control" value="'+ ((data.alt && data.alt != null )? data.alt : '') +'">';
    output += 'النص البديل هو وصف للصورة مش مجرد كلمة alt ';    
    output += '</div>';
    output += '<button id="SelectionSubmitButton" type="button" class="btn btn-block btn-success">حفظ</button>';
    output += '</form>';

    $('#Selection').html(output);

    setTimeout(function(){
        $('#SelectionForm').fadeIn();
    }, 1000);
    $('#SelectionSubmitButton').on('click', function(){
        $('#SelectionForm').submit();
    });
    $('#SelectionForm').on('submit', SubmitSelectionForm);
}

function SubmitSelectionForm(e){
    e.preventDefault();
    var id = $(this).attr('data-id');
    var data = $('#SelectionForm').serializeJSON();
    console.log(data);

    $.ajax({
        url: ExtractLinkVars(routes.update, id),
        method: 'PUT',
        data: data
    }).done(function(res){
        $('#SelectionForm span.output').html('<b style="color:green;">تم الحفظ بنجاح.</b>');
        $('img[data-id='+res.id+']').attr('alt', res.alt);
        $('img[data-id='+res.id+']').attr('description', res.description);
    }).error(function(){
        $('#SelectionForm span.output').html('<b style="color:red;">حدث خطأ ما ، لم يتم الحفظ.</b>');
    })
}
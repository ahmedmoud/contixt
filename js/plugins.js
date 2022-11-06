$(function(){
    
    "use strict";
    
    $('.single-carousel').owlCarousel({
    loop:true,
    margin:10,
    responsiveClass:true,
    autoplay:true,
    autoplayTimeout:5000,
    autoplayHoverPause:true,
    responsive:{
        0:{
            items:1,
            nav:true
        },
        600:{
            items:1,
            nav:false
        },
        1000:{
            items:1,
            nav:true,
            loop:false
        }
    }
});

    $('.multiple-carousel').owlCarousel({
    loop:true,
    margin:10,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:true
        },
        600:{
            items:2,
            nav:false
        },
        1000:{
            items:3,
            nav:true,
            loop:false
        }
    }
});
    
    $(window).scroll(function() {    
    var scroll = $(window).scrollTop();

    if (scroll >= 250) {
        
        $('.more-stories').css('left','0');
		
    } else {
       
        $('.more-stories').css('left','-400px');

    }
	
	}); 
    
    $('.more-stories i').click(function(){
        
        $('.more-stories').css('display','none');
        
    });
    
    
     $('.recent-carousel').owlCarousel({
    loop:true,
    margin:10,
    
    autoplay:true,
    autoplayTimeout:5000,
    autoplayHoverPause:true,
    
    
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:true
        },
        600:{
            items:1,
            nav:false
        },
        1000:{
            items:4,
            nav:true,
            loop:false
        }
    }
});
 
});
// $('#myModal1').on('shown.bs.modal', function () {
//     var fimg = $('#myModal1').find('img.captchaIMG');
//     fimg.removeClass('tempcaptchaIMG');
//     fimg.attr('src','');
//     fimg.attr('src', 'https://www.setaat.com/getCaptchaIMg?_CAPTCHA');
// 	//grecaptcha.render("captcha1", {sitekey: "6LcpjGEUAAAAAOd_RtXvnph5_027KXmYKeZmdllt", theme: "light"});
// });

// $('#myModal2').on('shown.bs.modal', function () {
//     var simg = $('#myModal2').find('img.captchaIMG');
//     simg.removeClass('tempcaptchaIMG');
//     simg.attr('src','');
//     simg.attr('src', 'https://www.setaat.com/getCaptchaIMg?_CAPTCHA');	//grecaptcha.render("captcha2", {sitekey: "6LcpjGEUAAAAAOd_RtXvnph5_027KXmYKeZmdllt", theme: "light"});
// });



$('.navX').click(function(){
    $('#myNavbar').removeClass('show');

});
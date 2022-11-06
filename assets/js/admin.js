$(function() {
    $(".preloader").fadeOut();
    $('[data-toggle="tooltip"]').tooltip();
    // ==============================================================
    // Login and Recover Password
    // ==============================================================
    $('#to-recover').on("click", function() {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });

    setTimeout(function(){
        $('.flash').slideUp();
    }, 5000);

    $('#RateSelect').on('change', function(){
        location.href = '/admin/permissions/'+ $(this).val()
    });
});

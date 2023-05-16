$(document).ready(function () {
    $('.select2').select2({
        theme: 'bootstrap4',
        width: '100%'
        // theme: "bootstrap-5",
    });

    $('.select2.multiple').select2({
        theme: 'bootstrap4',
        placeholder: 'Pilih Semua yang Ada',
        width: '100%'
    });
    
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        if(!($('#wrapper').hasClass('toggled'))){
            $('.sidebar-brand a').removeClass("toggled-brand");
        } else {
            $('.collapse.show').removeClass('show');
            $('#dropdown-menu').attr("aria-expanded","false");
            $('#dropdown-menu').addClass('collapsed');
            $('.sidebar-brand a').addClass("toggled-brand");
        }
        $("#wrapper").toggleClass("toggled");
    });
    $(".toggled-brand").click(function(e) {
    // $(".sidebar-brand a").click(function(e) {
        e.preventDefault();
        if(!($('#wrapper').hasClass('toggled'))){
            if($(this).is("#dropdown-menu") ){
                $('.sidebar-brand a').removeClass("toggled-brand");
                $("#wrapper").toggleClass("toggled");
            }
        }
    });
});
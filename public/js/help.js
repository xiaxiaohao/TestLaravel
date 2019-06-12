$(function(){
    $("ul li").click(function (e) {
        $(e.target).addClass();
        let $x= $(e.target).attr('id');
        $('#category_id').val($x);
    })

    $('.btn-primary').click(function () {
        $(window).attr('location', '/view');
    });

    $('.btn-info').click(function () {
        var id = $(this).attr("id");

        var url = "http://www.kinfy.com/api/down?id=";

        window.open(url+id);

    });

    $('.btn-warning').click(function () {
        var id = $(this).attr("id");

        var url = "http://www.kinfy.com/api/del?id=";

        window.open(url+id);

    });



})
$(function(){
    $("ul li").click(function (e) {
        $(e.target).addClass();
        let $x= $(e.target).attr('id');
        $('#category_id').val($x);
    })

    $('.add').click(function () {
        $(window).attr('location', '/view');
    });

    $('.download').click(function () {
        var id = $(this).attr("id");

        var url = "http://www.kinfy.com/api/down?id=";

        window.open(url+id);

    });

    $('.del').click(function () {
        var id = $(this).attr("id");

        var url = "http://www.kinfy.com/api/del?id=";

        window.open(url+id);

    });



})
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

        $.ajax({
            type: "POST",  //提交方式
            url: "/api/del",//路径
            data: {
                "id": id

            },//数据，这里使用的是Json格式进行传输

            success: function (result) {//返回数据根据结果进行相应的处理
                if (result.errcode = 200) {
                    alert("删除成功");
                    window.location.reload()
                }
            }
        });


    })


})
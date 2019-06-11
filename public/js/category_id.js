$(function(){
    $("ul li").click(function (e) {
        $(e.target).addClass();
        let $x= $(e.target).attr('id');
        $('#category_id').val($x);
    })
})
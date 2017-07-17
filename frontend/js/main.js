// не ругайте за качество jQuery? первый раз его использую,
// в сновном фронт пишу на AngularJs ))

$(".comment-comment").hide();
$(".reply").click(function () {
    $(".comment-comment").hide();
    $(".edit-comment").hide();

    console.log($(this).parent().next(".comment-comment").show())
});

$(".edit-comment").hide();
$(".edit").click(function () {
    $(".comment-comment").hide();
    $(".edit-comment").hide();
    console.log(
        $(this)
            .parent()
            .next(".comment-comment")
            .next(".edit-comment")
            .show())
});

$(".remove").click(function () {
    var commentId = $(this)
        .parent()
        .next(".comment-comment")
        .next(".edit-comment")
        .children()
        .next()
        .children()
        .next()
        .next("input[name='comment_id']").val();

    $.post( "/remove-comment", { comment_id: commentId} );
});


//todo send normal ajax request from send comments
$(".input").keypress(function (event) {
    if (event.which === 13) {
        event.preventDefault();
        $(this).nextUntil(".comment-comment");

    }
});

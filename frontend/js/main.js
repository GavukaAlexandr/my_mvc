// $('.input').keypress(function(e) {
//     if(e.which === 13) {
//         jQuery(this).blur();
//         jQuery('.submit').focus().click();
//     }
// });
// $("#submit").hide();
$(".comment-comment").hide();
$(".reply").click(function () {
    $(".comment-comment").hide();
   $(this).next(".comment-comment").show()
});

//todo send normal ajax request from send comments
$(".input").keypress(function (event) {
    if (event.which === 13) {
        event.preventDefault();
        console.log($(this).nextUntil(".comment-comment"));
        // jQuery("#submit").click();
    }
});

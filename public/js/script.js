AOS.init();

$(window).scroll(function () {
  var sticky = $(".header"),
    scroll = $(window).scrollTop();
  if (scroll >= 100) sticky.addClass("fixed");
  else sticky.removeClass("fixed");
});
// $(".tabs").hide();
// $(".servicesSec li").click(function () {
//   var tab = $(this).attr("id");
//   $("." + tab)
//     .addClass("active")
//     .siblings()
//     .removeClass("active");
//   $(".tabContent ." + tab)
//     .addClass("active")
//     .siblings()
//     .removeClass("active");
// });

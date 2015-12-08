$(document).ready(function () {
  $( "#link-help" ).click(function() {
    $("#cover").fadeIn("fast");
    $("#dialog-help").fadeIn("fast");
  });
  $( "#link-forgot" ).click(function() {
    $("#cover").fadeIn("fast");
    $("#dialog-forgot").fadeIn("fast");
  });
  $( ".dialog-close" ).click(function() {
    $("#cover").fadeOut("fast");
    $(".dialog-box").fadeOut("fast");
  });
});

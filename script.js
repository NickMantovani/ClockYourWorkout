$(document).ready(function () {
    $(window).scroll(function () {
      // sticky navbar script
      if (this.scrollY > 50) {
        $(".navbar").addClass("sticky");
      } else {
        $(".navbar").removeClass("sticky");
      }
  });
  
  
    $(".navbar .menu li a").click(function () {
      $("html").css("scrollBehavior", "smooth");
    });

  });
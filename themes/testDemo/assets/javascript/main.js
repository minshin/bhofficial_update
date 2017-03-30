$(function(){
  blogisotope = function () {
      var e, t = $(".blog-masonry").width(),
          n = Math.floor(t);
      if ($(".blog-masonry").hasClass("masonry-true") === true) {
          n = Math.floor(t * .3033);
          e = Math.floor(t * .04);
          if ($(window).width() < 1023) {
              if ($(window).width() < 768) {
                  n = Math.floor(t * 1)
              } else {
                  n = Math.floor(t * .48)
              }
          } else {
              n = Math.floor(t * .3033)
          }
      }
      return e
  };
  var r = $(".blog-masonry");
  bloggingisotope = function () {
      r.isotope({
          itemSelector: ".post-masonry",
          animationEngine: "jquery",
          masonry: {
              gutterWidth: blogisotope()
          }
      })
  };
  bloggingisotope();
  $(window).smartresize(bloggingisotope)

  
  //滚动时 动画
  new WOW().init();

})

//滚动导航栏监听
$(window).scroll(function () {

  if($('#myCarousel').offset()){
    var menu_top = $('#myCarousel').offset().top;
    if ($(window).scrollTop() >= menu_top+50){
     $('.navbar-default').css({'backgroundColor':'#fff'});

    }
    else {

            $('.navbar-default').css({'backgroundColor':'rgba(255,255,255,.02)'});
    }
  }
});

$(window).load(function () {
  $('#loader').fadeOut(); // will first fade out the loading animation
              $('#loader-wrapper').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website.
          $('body').delay(350).css({'overflow-y':'visible'});

// 服务项目导航
var scheduleTab = function() {
  $('.schedule-container').css('height', $('.schedule-content.active').outerHeight());

  $(window).resize(function(){
    $('.schedule-container').css('height', $('.schedule-content.active').outerHeight());
  });

  $('.schedule a').on('click', function(event) {

    event.preventDefault();

    var $this = $(this),
      sched = $this.data('sched');

    $('.schedule a').removeClass('active');
    $this.addClass('active');
    $('.schedule-content').removeClass('active');

    $('.schedule-content[data-day="'+sched+'"]').addClass('active');
})
};
    scheduleTab();
    // lazyload
    $("img").lazyload({
      placeholder : "{{'assets/img/loading.gif' |theme}}",
         effect: "fadeIn"
   });



// banner 动画效果
$('#bootstrap-touch-slider').bsTouchSlider();






})

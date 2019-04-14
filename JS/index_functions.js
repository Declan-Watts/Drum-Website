//Preloader
$(window).on('load', function () {
  preloaderFadeOutTime = 1000;
  function hidePreloader() {
    var preloader = $('.spinner-wrapper');
    preloader.fadeOut(preloaderFadeOutTime);
  }

  hidePreloader();
});
//Scroll down fade away script
$(function () {
  var fade = $('.scrolldown');
  $(window).on('scroll', function () {
    var st = $(this).scrollTop();
    fade.css({
      opacity: 1 - st / 250,
    });
  });

});

$(document).ready(function () {
  /* Toggles the Burger Menu */
  $('#slide-toggle').click(function () {
    $('body').toggleClass('toggled');
    $('header').toggleClass('toggled');
    $('#sidenav').toggleClass('toggled');

  });

  $('#slide-close').click(function () {
    $('body').toggleClass('toggled');
    $('header').toggleClass('toggled');
    $('#sidenav').toggleClass('toggled');
  });
});

/* Creates the parallax effect */

$(window).scroll(function () {
  var scrollTop = $(this).scrollTop();
  $('.header-bg').css('top', -(scrollTop * 0.5) + 'px');
  $('#c1').css('top', 100 - (scrollTop * 0.2) + 'px');
  $('#c2').css('top', 240 - (scrollTop * 0.2) + 'px');
  $('#c3').css('top', 380 - (scrollTop * 0.2) + 'px');
  $('#c4').css('top', 520 - (scrollTop * 0.2) + 'px');
});

$(window).scroll(function () {
  var scrollTop = $(this).scrollTop();
  $('.header-bg').css('top', -(scrollTop * 0.5) + 'px');
  $('#c1b').css('top', 100 - (scrollTop * 0.2) + 'px');
  $('#c2b').css('top', 100 - (scrollTop * 0.2) + 'px');
  $('#c3b').css('top', 200 - (scrollTop * 0.2) + 'px');
  $('#c4b').css('top', 200 - (scrollTop * 0.2) + 'px');
});

$('.message a').click(function () {
  $('form').animate({ height: 'toggle', opacity: 'toggle' }, 'slow');
});

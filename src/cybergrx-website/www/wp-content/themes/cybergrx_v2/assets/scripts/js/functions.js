var header = document.querySelector('header');

var recalc_sticky_header = debounce(function(evt){
	header_offset();
}, 100);

if (header){
	header_offset();
	window.addEventListener('resize', recalc_sticky_header, false);
}

function header_offset() {
	header.nextElementSibling.style.marginTop = header.offsetHeight + 'px';
}

function debounce(func, wait, immediate){
	var timeout;
	return function(){
		var context = this,
			args = arguments,
			later = function(){
				timeout = null;
				if (!immediate) func.apply(context, args);
			}
		var callNow = immediate && !timeout;
		clearTimeout(timeout);
		timeout = setTimeout(later, wait);
		if (callNow) func.apply(context, args);
	}
}

(function($) {

var min_w = 300;
var vid_w_orig;
var vid_h_orig;

$(function() {

    vid_w_orig = parseInt($('video').attr('width'));
    vid_h_orig = parseInt($('video').attr('height'));

    $(window).resize(function () { fitVideo(); });
    $(window).trigger('resize');

});

function fitVideo() {

    $('#video-viewport').width($('.fullsize-video-bg').width());
    $('#video-viewport').height($('.fullsize-video-bg').height());

    var scale_h = $('.fullsize-video-bg').width() / vid_w_orig;
    var scale_v = $('.fullsize-video-bg').height() / vid_h_orig;
    var scale = scale_h > scale_v ? scale_h : scale_v;

    if (scale * vid_w_orig < min_w) {scale = min_w / vid_w_orig;};

    $('video').width(scale * vid_w_orig);
    $('video').height(scale * vid_h_orig);

    $('#video-viewport').scrollLeft(($('video').width() - $('.fullsize-video-bg').width()) / 2);
    $('#video-viewport').scrollTop(($('video').height() - $('.fullsize-video-bg').height()) / 2);

};

/* Countdown timer */
if (document.getElementById('countdown-timer')) {
	var second = 1000,
		minute = second * 60,
		hour   = minute * 60,
		day    = hour * 24,
		date   = document.getElementById('countdown-timer').dataset.time;

	var countDown = new Date('Sep 30, 2018 00:00:00').getTime(),
		x = setInterval(function() {
			now = new Date().getTime(),
			distance = countDown - now;

			document.getElementById('days').innerHTML = Math.floor(distance / (day)),
			document.getElementById('hours').innerHTML = Math.floor((distance % (day)) / (hour)),
			document.getElementById('minutes').innerHTML = Math.floor((distance % (hour)) / (minute)),
			document.getElementById('seconds').innerHTML = Math.floor((distance % (minute)) / second);
		}, second);
}

$('.chart-row').waypoint(function() {
	var pie = {
        size: 180,
        animate: 2000,
        trackColor: '#9b9b9b',
        barColor: '#f06a3e',
        lineWidth: 10,
        trackWidth: 4,
        scaleLength: 0,
        lineCap: 'square',
        onStep: function(from, to, percent) {
                $(this.el).find('span').text(Math.round(percent));
            }
    }
    $(this.element).find('.chart').each(function(){
		var $this = $(this);
		if ($this.hasClass('bigger-circles') || $this.parent().hasClass('bigger-circles')){
			pie.size = 240;
			$this.css({'width': '240px', 'height': '240px'});
		}
		$(this).easyPieChart(pie);
	});
    }, {
       offset: '100%'
});

$('.box-rows').waypoint(function() {
     $(".box-row:first-child .box:first-child").delay(0).fadeTo('slow', 1);
     $(".box-row:first-child .box:last-child").delay(500).fadeTo('slow', 1);
     $(".box-row:last-child .box:first-child").delay(1500).fadeTo('slow', 1);
     $(".box-row:last-child .box:last-child").delay(2000).fadeTo('slow', 1);
     }, {
       offset: '100%'
});
$('.infographic').waypoint(function() {
    $( '.infographic' ).removeClass('unanimated');
    $(".circle:first-child .description").delay(500).fadeTo('slow', 1);
    $(".circle:nth-child(2) .description").delay(1000).fadeTo('slow', 1);
    $(".circle:last-child .description").delay(1500).fadeTo('slow', 1);
 }, {
       offset: '50%'
});

$('.ba-slider').waypoint(function() {
    $(".ba-slider").addClass("triggered");
}, {
       offset: '75%'
});
$(".image-scrubber .handle").on("mouseenter", function() {
    $(".ba-slider").addClass("slow-trigger")
 });



// Call & init
$(document).ready(function(){
  $('.ba-slider').each(function(){
    var cur = $(this);
    // Adjust the slider
    var width = cur.width()+'px';
    cur.find('.resize img').css('width', width);
    // Bind dragging events
    drags(cur.find('.handle'), cur.find('.resize'), cur);
  });
});

// Update sliders on resize.
// We all do it: i.imgur.com/YkbaV.gif
$(window).resize(function(){
  $('.ba-slider').each(function(){
    var cur = $(this);
    var width = cur.width()+'px';
    cur.find('.resize img').css('width', width);
  });
});

//Drag function for image compare
function drags(dragElement, resizeElement, container) {

  // Initialize the dragging event on mousedown.
  dragElement.on('mouseenter mousedown touchstart', function(e) {

    dragElement.addClass('draggable');
    resizeElement.addClass('resizable');

    // Check if it's a mouse or touch event and pass along the correct value
    var startX = (e.pageX) ? e.pageX : e.originalEvent.touches[0].pageX;

    // Get the initial position
    var dragWidth = dragElement.outerWidth(),
        posX = dragElement.offset().left + dragWidth - startX,
        containerOffset = container.offset().left,
        containerWidth = container.outerWidth();

    // Set limits
    minLeft = containerOffset + 10;
    maxLeft = containerOffset + containerWidth - dragWidth - 10;

    // Calculate the dragging distance on mousemove.
    dragElement.parents().on("mousemove touchmove", function(e) {

      // Check if it's a mouse or touch event and pass along the correct value
      var moveX = (e.pageX) ? e.pageX : e.originalEvent.touches[0].pageX;

      leftValue = moveX + posX - dragWidth;

      // Prevent going off limits
      if ( leftValue < minLeft) {
        leftValue = minLeft;
      } else if (leftValue > maxLeft) {
        leftValue = maxLeft;
      }

      // Translate the handle's left value to masked divs width.
      widthValue = (leftValue + dragWidth/2 - containerOffset)*100/containerWidth+'%';

      //Bind mouseleave event on entire slider so drag doesn't stop when the cursor leaves the handle
      $( ".image-scrubber" ).mouseleave(function() {
          dragElement.removeClass('draggable');
          resizeElement.removeClass('resizable');
      });

      // Set the new values for the slider and the handle.
      // Bind mouseup events to stop dragging.
      $('.draggable').css('left', widthValue).on('mouseup touchend touchcancel', function () {
        $(this).removeClass('draggable');
        resizeElement.removeClass('resizable');
      });
      $('.resizable').css('width', widthValue);
    }).on('mouseup touchend touchcancel', function(){
      dragElement.removeClass('draggable');
      resizeElement.removeClass('resizable');
    });
    e.preventDefault();
  }).on('mouseup touchend touchcancel', function(e){
    dragElement.removeClass('draggable');
    resizeElement.removeClass('resizable');
  });
}


//Slide Down Bios
$(document).ready(function() {

    var t = "#load-inline-container",
        active;

    bio_reclass();

    $(document).ajaxSend(function() {
        // close_bio();
    });

    $(document).ajaxSuccess(function() {
      var last = active.hasClass('last-in-row') ? active : active.nextAll('.last-in-row').eq(0);

      $(t).insertAfter(last).slideDown("fast");

      $("html,body").animate({
          scrollTop: active.offset().top
      }, 500);
    });

    $(".load-inline a").click(function() {
        ajaxit($(this).attr("href"));
        active = $(this).parent();
        return !1
    });

    $("#close-inline").click(function() {
        // close_bio();
    });

    $(window).resize(function() {
        close_bio();
        bio_reclass();
    });

    function bio_reclass(){
      var viewport = $(document).width(),
          mod;

      $('.people-list').each(function(){
        var prevTop = null;
        var $prevEl = $();
        $(this).find('.person').each(function(i, el){
          var $this = $(this);
          var thisTop = $this.offset().top;
          if ( prevTop && prevTop !== thisTop ) {
            $prevEl.addClass('last-in-row')
          } else {
            $prevEl.removeClass('last-in-row')
          }
          prevTop = thisTop;
          $prevEl = $this;
        }).last().addClass('last-in-row');
      });
    }

    function ajaxit(url) {
        $("#load-inline-content").load(url + " " + "#load-target", function(){});
    }

    function close_bio() {
        $(t).slideUp("slow");
    }
});

//Nav gets sticky on scroll-up
// Hide Header on on scroll down
var didScroll;
var lastScrollTop = 0;
var delta = 5;
var navbarHeight = $('header').outerHeight();

$(window).scroll(function(event){
    didScroll = true;
});

setInterval(function() {
    if (didScroll) {
        hasScrolled();
        stickyBanner();
        didScroll = false;
    }
}, 150);

function hasScrolled() {
    var st = $(this).scrollTop();

    // Make sure they scroll more than delta
    if(Math.abs(lastScrollTop - st) <= delta)
        return;

    // If they scrolled down and are past the navbar, add class .nav-up.
    if (st > lastScrollTop && st > navbarHeight){
        // Scroll Down
        $('header').removeClass('nav-down').addClass('nav-up');
    } else {
        // Scroll Up
        if(st + $(window).height() < $(document).height()) {
            $('header').removeClass('nav-up').addClass('nav-down');
        }
    }

    lastScrollTop = st;
}

// Stick the blog banner ad on scroll, and unstick it at the footer
function stickyBanner() {
    if ($('#square-thing').length){
        var window_top = $(window).scrollTop();
        var footer_top = $("#footer").offset().top;
        var div_top = $('#sticky-anchor').offset().top;
        var div_height = $("#square-thing").height();

        if (window_top + div_height > footer_top - 20) {
            $('#square-thing').css({top: (window_top + div_height - footer_top + 20) * -1})}
        else if (window_top > div_top) {
            $('#square-thing').addClass('fix-square');
            $('#square-thing').css({top: 0})
        } else {
            $('#square-thing').removeClass('fix-square');
        }
    }
}

})(jQuery);



// Function to reveal lightbox and adding YouTube autoplay
function revealVideo(div,video_id) {
  var video = document.getElementById(video_id).src;
  document.getElementById(video_id).src = video+'&autoplay=1'; // adding autoplay to the URL
  document.getElementById(div).style.display = 'block';
}

// Hiding the lightbox and removing YouTube autoplay
function hideVideo(div,video_id) {
  var video = document.getElementById(video_id).src;
  var cleaned = video.replace('&autoplay=1',''); // removing autoplay form url
  document.getElementById(video_id).src = cleaned;
  document.getElementById(div).style.display = 'none';
}

/*
Debounce and Throttle are extremely important things to have on hand, particularly when observing rapid-firing events (like resize or mousemove)
They do similar--but distinct--things, which can make them confusing: https://css-tricks.com/the-difference-between-throttling-and-debouncing/
var yourfunction = debounce(function(foo){
	// this will only execute 150ms after the last time it's called (so it waits for your event to settle)
}, 150);
var yourfunction = throttle(function(bar){
	// this will only execute once every 150ms regardless of how many calls it gets (so it fires continuously, but LESS continuously)
}, 150);
*/
function debounce(func, wait, immediate){
	var timeout;
	return function(){
		var context = this,
			args = arguments,
			later = function(){
				timeout = null;
				if (!immediate) func.apply(context, args);
			}
		var callNow = immediate && !timeout;
		clearTimeout(timeout);
		timeout = setTimeout(later, wait);
		if (callNow) func.apply(context, args);
	}
}

function throttle(callback, limit) {
	var wait = false;
	return function() {
		if (wait) {
			return;
		}
		callback.call();
		wait = true;
		setTimeout(function() {
			wait = false;
		}, limit);
	}
}

function hoist(the_function, the_args){
	window[the_function](the_args);
}

// Intersection Observer

var io = 0;
if ('IntersectionObserver' in window &&
	'IntersectionObserverEntry' in window &&
	'intersectionRatio' in window.IntersectionObserverEntry.prototype) {

	// Minimal polyfill for Edge 15's lack of `isIntersecting`
	// See: https://github.com/w3c/IntersectionObserver/issues/211
	if (!('isIntersecting' in window.IntersectionObserverEntry.prototype)) {
		Object.defineProperty(window.IntersectionObserverEntry.prototype,
			'isIntersecting', {
			get: function () {
				return this.intersectionRatio > 0;
			}
		});
	}

	// we passed, so set our JS and CSS hooks
	document.documentElement.classList.add('intersectable');
	io = 1;
}

// Is In View...
document.addEventListener("DOMContentLoaded", function() {
  var elements = document.querySelectorAll(".animate");

  if (io && elements.length) {
    var animateObserver = new IntersectionObserver(animate, {
      threshold: .7
    });
    for (var i = 0; i < elements.length; i++) {
      animateObserver.observe(elements[i]);
    }
  }
  function animate(entries, observer) {
    entries.forEach(function(entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        if (entry.target.hasAttribute('data-on-inview')){
          hoist(entry.target.getAttribute('data-on-inview'), entry.target);
        }
        observer.unobserve(entry.target);
      }
    });
  }
});




// Animate all the numbers
function count_up(container){
	var numbers = container.querySelectorAll('.stat-num');

	for (var i = 0; i < numbers.length; i++) {
		var options = {
				useGrouping: !numbers[i].hasAttribute('data-noformat'),
				prefix: numbers[i].getAttribute('data-prefix') || '',
				suffix: numbers[i].getAttribute('data-suffix') || ''
			},
			to = numbers[i].getAttribute('data-to') || numbers[i].textContent;

		// pad the width of the animating element to prevent the content around it from jumping at every change
		numbers[i].style.minWidth = (options.prefix + to + options.suffix).length * .8 + 'em';

		var num = new CountUp(
			numbers[i],
			numbers[i].getAttribute('data-from') || 0,
			to,
			numbers[i].getAttribute('data-decimals') || 0,
			numbers[i].getAttribute('data-duration') || 2,
			options
		);
		if (!num.error) {
			num.start();
		}
	}
}

if (io) {
  var numbers = document.querySelectorAll('.stat-num');
  for (var i = 0; i < numbers.length; i++) {
    numbers[i].textContent = numbers[i].getAttribute('data-from') || 0;
  }
}

window.onload = function() {
	lax.setup() // init

	document.addEventListener('scroll', function(e) {
	  lax.update(window.scrollY) // update every scroll
	}, false)
}

// lax.addPreset("upAndIn", function(){
// 	return {
// 		"data-lax-opacity": "0 0, 300 1",
// 		"data-lax-translate-y": "0 -300, 300 0"
// 	}
// });

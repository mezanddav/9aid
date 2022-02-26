// Tool for compressing js code: https://jscompress.com/



/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
var nav = {
  nav_id: 'site-navigation',
  container: false,
  button: false,
  menu: false,
  links: false,
  i: false,
  len: false,
  is_open: false,
  init: function(){
    this.container = document.getElementById( this.nav_id );
    if ( ! this.container ) { return; }

    this.button = this.container.getElementsByTagName( 'button' )[0];
    if ( 'undefined' === typeof this.button ) { return; }

    this.menu = this.container.getElementsByTagName( 'ul' )[0];
    if ( 'undefined' === typeof this.menu ) {
		  this.button.style.display = 'none';
		  return;
    }
    
    this.setup();
  },
  setup: function(){
    this.menu.setAttribute( 'aria-expanded', 'false' );
    if ( -1 === this.menu.className.indexOf( 'nav-menu' ) ) {
      this.menu.className += ' nav-menu';
    }

    this.on_click();
    this.on_scroll();
    this.on_mouseup();
    this.on_focus();
    this.on_touch();
  },
  open: function(){
    this.container.className += ' toggled';
    this.button.setAttribute( 'aria-expanded', 'true' );
    this.menu.setAttribute( 'aria-expanded', 'true' );
    this.is_open = true;
    console.log('open');
  },
  close: function(){
    this.container.className = this.container.className.replace( ' toggled', '' );
    this.button.setAttribute( 'aria-expanded', 'false' );
    this.menu.setAttribute( 'aria-expanded', 'false' );
    this.is_open = false;
    console.log('close');
  },
  on_click: function(){
    this.button.onclick = function() {
      if ( -1 !== nav.container.className.indexOf( 'toggled' ) ) {
        nav.close();
      } else {
        nav.open();
      }
    };
  },
  on_focus: function(){
    this.links = this.menu.getElementsByTagName( 'a' );
    for ( i = 0, len = this.links.length; i < len; i++ ) {
      this.links[i].addEventListener( 'focus', nav.toggle_focus, true );
      this.links[i].addEventListener( 'blur', nav.toggle_focus, true );
    }
  },
  on_scroll: function(){
    window.addEventListener('scroll', function(e) {
      if (nav.is_open){
        nav.close();
      }
    }, false);
  },
  on_mouseup: function(){
    window.addEventListener('mouseup', function(e) {
      if (e.target != nav.button && nav.is_open){
        nav.close();
      }
    });
  },
  toggle_focus: function() {
		var self = this;
		while ( -1 === self.className.indexOf( 'nav-menu' ) ) {
			if ( 'li' === self.tagName.toLowerCase() ) {
				if ( -1 !== self.className.indexOf( 'focus' ) ) {
					self.className = self.className.replace( ' focus', '' );
				} else {
					self.className += ' focus';
				}
			}
			self = self.parentElement;
		}
  },
  on_touch: function(){
    ( function( container ){
      var touchStartFn, i,
        parentLink = container.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

      if ( 'ontouchstart' in window ) {
        touchStartFn = function( e ) {
          var menuItem = this.parentNode, i;

          if ( ! menuItem.classList.contains( 'focus' ) ) {
            e.preventDefault();
            for ( i = 0; i < menuItem.parentNode.children.length; ++i ) {
              if ( menuItem === menuItem.parentNode.children[i] ) {
                continue;
              }
              menuItem.parentNode.children[i].classList.remove( 'focus' );
            }
            menuItem.classList.add( 'focus' );
          } else {
            menuItem.classList.remove( 'focus' );
          }
        };

        for ( i = 0; i < parentLink.length; ++i ) {
          parentLink[i].addEventListener( 'touchstart', touchStartFn, false );
        }
      }
    }( this.container ) );
  }
};
nav.init();



/**
 * Lazy load
 */
var dfLazyLoad = new LazyLoad({
	elements_selector: '.loadlzly',
	callback_set: function(el){
		el.classList.add( 'active' );
	},
});



/**
 * Click to scroll
 */
(function($){
	$("a[href*='#']:not([href='#'])").click(function() {
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			if (target.length) {
				$('html,body').animate({
					scrollTop: target.offset().top
				}, 1000);
				return false;
			}
		}
	});
})(jQuery);
<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package eve
 */



if ( ! function_exists( 'eve_foo' ) ) :
	/**
	 * Comment
	 */
  function eve_foo()
  {

	}
endif;



/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function eve_body_classes( $classes )
{
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}



/**
 * Theme verison control
 */
if ( !function_exists( 'eve_verison_control' ) ) :
	/**
	 * Template style loader
	 */
  function eve_verison_control() 
  { 
    $e = get_option('eve_environment_details');
    if( $e == false || empty($e) ){ return time(); }

    $v = get_option('eve_theme_version');
    if( $v === false || empty($v) ){ return '1.0.0'; }
    return $v;
  }
endif;



if ( !function_exists( 'eve_remove_xmlrpc_pingback_ping' ) ) :
  /**
   * Remove XMLrpc method
   */
  function eve_remove_xmlrpc_pingback_ping( $methods )
  {
    unset( $methods['pingback.ping'] );
    return $methods;
  };
endif;



if ( !function_exists( 'eve_disable_emojis_tinymce' ) ) :
  /**
   * Filter function used to remove the tinymce emoji plugin.
   *
   * @param    array  $plugins
   * @return   array  Difference betwen the two arrays
   */
  function eve_disable_emojis_tinymce( $plugins )
  {
    if ( is_array( $plugins ) )
    {
      return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
      return array();
    }
  }
endif;



if ( !function_exists( 'eve_itsme_disable_feed' ) ) :
  /**
   * Redirect feed page
   */
  function eve_itsme_disable_feed() 
  {
    wp_die( __( 'No feed available, please visit the <a href="'. esc_url( home_url( '/' ) ) .'">homepage</a>!' ) );
  }
endif;



if ( !function_exists( 'eve_pre_get_posts' ) ) :
  /**
   * Alter query in pre-get
   */
  function eve_pre_get_posts( $query )
  {
    if( is_admin() ) { return $query; }

    if( isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'job' ) {
    
      // Example for URL query
      $location = ( isset( $_GET['location'] ) && is_numeric( $_GET['location'] ) ) ? intval( $_GET['location'] ) : false;
      if( $location )
      {
        // Example to alter the query
        $query->set('meta_key', 'icf_office');
        $query->set('meta_value', $_GET['location']);
      } 
    }
    return $query;
  }
endif;



if ( !function_exists( 'eve_inline_style' ) ) :
	/**
	 * Template style loader
	 */
  function eve_inline_style()
  { 
    echo "<style>";
    echo file_get_contents( get_template_directory() . '/inline.css' ); 
    
    global $template;
    $local_template = basename($template);
    if( !empty($local_template) && is_string($local_template) )
    {
      $local_template_path = get_template_directory() .'/css/'. $local_template .'.css';

      if( file_exists($local_template_path) )
      {
        echo file_get_contents( $local_template_path );
      }
    }

    echo "</style>\r\n";
  }
endif;



if ( !function_exists( 'eve_cf7_api_settings' ) ) :
	/**
	 * CF7 API settings
	 */
  function eve_cf7_api_settings()
  {
    $wpcf7 = array(
      'apiSettings' => array(
        'root' => esc_url_raw( rest_url( 'contact-form-7/v1' ) ),
        'namespace' => 'contact-form-7/v1',
      ),
      'recaptcha' => array(
        'messages' => array(
          'empty' =>
            __( 'Please verify that you are not a robot.', 'contact-form-7' ),
        ),
      ),
    );
    
    if ( defined( 'WP_CACHE' ) && WP_CACHE ) {
      $wpcf7['cached'] = 1;
    }

    $wpcf7 = json_encode( $wpcf7 );
    $wpcf7 = '/* <![CDATA[ */ var wpcf7 = '. $wpcf7  .'; /* ]]> */';

    echo "<script type='text/javascript'>". $wpcf7 ."</script>\n";
  }
endif;



if ( !function_exists( 'eve_fonts_url' ) ) :
  /**
   * Register custom fonts.
   */
  function eve_fonts_url() {
    $fonts_url = '';

    $font_families = array();
    $font_families[] = 'Montserrat:400,700';

    $query_args = array(
      'family' => urlencode( implode( '|', $font_families ) ),
      // 'subset' => urlencode( 'latin,latin-ext' ),
      // 'subset' => urlencode( 'latin' ),
    );

    $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

    return esc_url_raw( $fonts_url );
  }
endif;



if ( !function_exists( 'eve_resource_hints' ) ) :
  /**
   * Add preconnect for Google Fonts.
   *
   * @since eve 1.0
   *
   * @param array  $urls           URLs to print for resource hints.
   * @param string $relation_type  The relation type the URLs are printed.
   * @return array $urls           URLs to print for resource hints.
   */
  function eve_resource_hints( $urls, $relation_type ) {
    if ( wp_style_is( 'progresseve-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
      $urls[] = array(
        'href' => 'https://fonts.gstatic.com',
        'crossorigin',
      );
    }
    return $urls;
  }
endif;



if ( !function_exists( 'eve_ignore_sticky' ) ) :
  // the function that does the work
  function eve_ignore_sticky($query)
  {
    // sure we're were we want to be.
    if ( is_home() && $query->is_main_query() )
      $query->set('ignore_sticky_posts', true);
  }
endif;



if ( !function_exists( 'eve_custom_excerpt_length' ) ) :
  function eve_custom_excerpt_length( $length )
  {
    return 26;
  }
endif;



if ( !function_exists( 'eve_new_excerpt_more' ) ) :
  function eve_new_excerpt_more( $more )
  {
    return '...';
  }
endif;



if ( ! function_exists( 'eve_cpt_redirect_post' ) ) :
  function eve_cpt_redirect_post()
  {
    $queried_post_type = get_query_var('post_type');
    if ( is_single() && 'transformations' ==  $queried_post_type ) {
      wp_redirect( get_post_type_archive_link( 'transformations' ), 301 );
      exit;
    }
  }
endif;



if ( ! function_exists( 'eve_cpt_change_sort_order' ) ) :
  function eve_cpt_change_sort_order( $query )
  {
    if( is_archive() && is_post_type_archive( 'members' ) ):
      //If you wanted it for the archive of a custom post type use: is_post_type_archive( $post_type )
      //Set the order ASC or DESC
      $query->set( 'order', 'ASC' );
      //Set the orderby
      // $query->set( 'orderby', 'title' );
    endif;    
  };
endif;



if ( ! function_exists( 'eve_remove_jquery_migrate' ) ) :
  /**
   * Dequeue jQuery Migrate script in WordPress.
   */
  function eve_remove_jquery_migrate( &$scripts)
  {
    if( ! is_admin() ) {
      $scripts->remove( 'jquery' );
      $scripts->add( 'jquery', false, array( 'jquery-core' ), '1.12.4' );
    }
  }

endif;



if ( ! function_exists( 'eve_print_base_url' ) ) :
	/**
	 * Print base url in the head
	 */
  function eve_print_base_url()
  {
?><base href="<?php echo rtrim(get_site_url(),'/').'/'; ?>">
<?php
	}
endif;



if ( ! function_exists( 'eve_binary_thumbnail_upscale' ) ) :
	/**
	 * Upscale from small image fix
	 */
	function eve_binary_thumbnail_upscale() {
    if ( !$crop ) return null; 

    $aspect_ratio = $orig_w / $orig_h;
    $size_ratio = max($new_w / $orig_w, $new_h / $orig_h);
    $crop_w = round($new_w / $size_ratio);
    $crop_h = round($new_h / $size_ratio);
    $s_x = floor( ($orig_w - $crop_w) / 2 );
    $s_y = floor( ($orig_h - $crop_h) / 2 );
    
    return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
	}
endif;



if ( !function_exists( 'eve_theme_icons' ) ) :
	/**
	 * Theme svg icons
	 */
  function eve_theme_icons()
  {
?><svg xmlns="http://www.w3.org/2000/svg" width="0" height="0" display="none">
<symbol id="9aid-logo" viewBox="0 0 100 96"><path d="M57.47,66.39h9.3V26.26a17.35,17.35,0,0,0-9,13.2l-1.4,11.78h0a2.77,2.77,0,0,1,1.22,5.4L56.18,57c-.17-.34-.34-.67-.53-1a28.75,28.75,0,0,1-3.91-15.5L52.19,28a8.32,8.32,0,0,0-2.11-5.83A8.27,8.27,0,0,0,48,28l.44,12.52A28.58,28.58,0,0,1,44.5,56c-.19.33-.35.67-.52,1l-1.47-.33a2.77,2.77,0,1,1,1.16-5.41h.07L42.35,39.46a17.35,17.35,0,0,0-9-13.2V66.39h9.3a15.17,15.17,0,0,0,5.5,9.13,5.6,5.6,0,0,1,1.9,1.94A5.51,5.51,0,0,1,52,75.52a15.22,15.22,0,0,0,5.5-9.13m2-17.43,1.1-9.19A14.54,14.54,0,0,1,64,32V52.55H62.42a5.53,5.53,0,0,0-3-3.59M58.25,59.34a5.56,5.56,0,0,0,4.17-4H64v8.3H57.72a15,15,0,0,0-.55-4ZM36.17,32a14.56,14.56,0,0,1,3.42,7.76l1.1,9.2a5.49,5.49,0,0,0-2.94,3.59H36.17Zm6.26,31.61H36.17v-8.3h1.57a5.56,5.56,0,0,0,4.16,4l1.08.24a15.37,15.37,0,0,0-.55,4m12-3.43a12.46,12.46,0,0,1,.48,3.43H51.47a3.45,3.45,0,0,1,2.72-3.37Zm-5.77,12a12.38,12.38,0,0,1-3.16-5.85h3.16Zm-3.47-8.62a12.46,12.46,0,0,1,.48-3.43l.27.06a3.46,3.46,0,0,1,2.72,3.37Zm4.86-3.91a6.32,6.32,0,0,0-3.3-2.11c0-.08.08-.16.13-.24a32,32,0,0,0,3.17-7.51,31.2,31.2,0,0,0,3.17,7.51l.12.24a6.3,6.3,0,0,0-3.3,2.11m1.39,6.68h3.16a12.38,12.38,0,0,1-3.16,5.85Z" style="fill:#ffcd00"/><path d="M45.85,12.52,50,9.57l4.17,2.95L52.61,7.76l4.24-2.94H51.63L50,0l-1.6,4.82H43.2l4.24,2.94Z" style="fill:#fff"/><path d="M24.25,18.12l4.18-2.94,4.17,2.94L31,13.36l4.24-2.94H30L28.42,5.6l-1.6,4.83H21.6l4.24,2.94Z" style="fill:#fff"/><path d="M12.62,20.9,11,25.73H5.8l4.24,3L8.45,33.42l4.17-2.94,4.18,2.94-1.59-4.75,4.24-3H14.22Z" style="fill:#fff"/><path d="M6.83,51.32,11,54.26,9.41,49.5l4.24-2.94H8.42l-1.6-4.82-1.6,4.83H0L4.24,49.5,2.65,54.26Z" style="fill:#fff"/><path d="M14.22,67.46l-1.6-4.82L11,67.47H5.8L10,70.4,8.45,75.16l4.17-2.94,4.18,2.94L15.21,70.4l4.24-2.94Z" style="fill:#fff"/><path d="M30.06,82.76l-1.6-4.82-1.6,4.82H21.63l4.24,2.94-1.58,4.76,4.17-2.94,4.17,2.94L31.05,85.7l4.23-2.94Z" style="fill:#fff"/><path d="M51.63,88.3,50,83.48l-1.6,4.82H43.2l4.24,2.94L45.86,96,50,93.06,54.2,96l-1.59-4.76,4.24-2.94Z" style="fill:#fff"/><path d="M73.2,82.76l-1.6-4.82L70,82.76H64.78L69,85.7l-1.59,4.76,4.17-2.94,4.18,2.94L74.19,85.7l4.24-2.94Z" style="fill:#fff"/><path d="M89,67.46l-1.6-4.82-1.6,4.83H80.62l4.24,2.94-1.59,4.76,4.17-3,4.18,3L90,70.4l4.24-2.94Z" style="fill:#fff"/><path d="M100,46.5H94.77l-1.6-4.82-1.6,4.83H86.35l4.24,2.94L89,54.2l4.17-3,4.18,3-1.59-4.76Z" style="fill:#fff"/><path d="M83.27,33.36l4.17-2.94,4.17,2.94L90,28.6l4.24-2.93H89l-1.6-4.83-1.6,4.83H80.61l4.24,2.93Z" style="fill:#fff"/><path d="M71.67,5.61l-1.6,4.82H64.84l4.23,2.95-1.58,4.76,4.18-2.95,4.17,2.95-1.58-4.76,4.23-2.94H73.26Z" style="fill:#fff"/></symbol>
<symbol id="9gag-logo" viewBox="0 0 100 100"><path d="M100,50V25L75.21,12.48C61.57,5.62,50.23,0,50,0S38.43,5.62,24.79,12.48L0,25v9.81L24.79,47.26c13.64,6.86,25,12.48,25.21,12.48s7-3.32,15.08-7.38S79.8,45,79.87,45,80,49.54,80,55.13V65.28L65.3,72.66c-8.08,4.07-14.88,7.43-15.1,7.48s-7-3.23-15.1-7.3S20.23,65.45,20,65.45c-.75,0-19.28,9.47-19.16,9.79S49.25,100,49.92,100c.27,0,11.65-5.6,25.29-12.47h0L100,75.05ZM50,39.83A112.76,112.76,0,0,1,39.72,35C34.38,32.25,30,30,30,29.87,30,29.58,49.4,20,50,20s20,9.6,20,9.9S50.66,39.77,50,39.83Z" style="fill:#010101"/></symbol>
<symbol id="i-logo" viewBox="0 0 10 10"></symbol>
</svg>
<?php 
  }
endif;



if ( !function_exists( 'progresseve_scripts' ) ) :
	/**
	 * Template scripts and style loader
	 */
	function progresseve_scripts() { 

    /**
     * 
     * Load JS files
     * 
     * (function() {
     *   var wf = document.createElement('script');
     *   wf.src = '<?php echo get_template_directory_uri(); ?>/js/eve.js?v=<?php echo eve_verison_control(); ?>';
     *   wf.type = 'text/javascript';
     *   document.body.appendChild(wf);
     * })();
     */

    /**
     * 
     * Load CSS files
     * 
     * (function() {
     *   var css = document.createElement('link');
     *   css.rel = 'stylesheet';
     *   css.href = '<?php echo get_template_directory_uri(); ?>/css/swiper.css?v=<?php echo eve_verison_control(); ?>';
     *   css.type = 'text/css';
     *   var godefer = document.getElementsByTagName('link')[0];
     *   godefer.parentNode.insertBefore(css, godefer);
     * })();
     */

    /**
     * 
     * Load CSS background images (OLD METHOD, USE THE LAZY LOAD OPTION FOR THIS)
     * 
     * (function() {
     *   var container = document.getElementById( 'section__bg' );
     *   if ( !container ) { return; }
     *   var image = new Image();
     *   image.src = container.dataset.bg;
     *   image.onload = function() {
     *     container.style.backgroundImage = "url('"+ image.src +"')";
     *     container.classList.add( 'active' );
     *   }
     * })();
     */

?><script type='text/javascript'>
var nav={nav_id:"site-navigation",container:!1,button:!1,menu:!1,links:!1,i:!1,len:!1,is_open:!1,init:function(){if(this.container=document.getElementById(this.nav_id),!!this.container)return(this.button=this.container.getElementsByTagName("button")[0],"undefined"!=typeof this.button)?(this.menu=this.container.getElementsByTagName("ul")[0],"undefined"==typeof this.menu?void(this.button.style.display="none"):void this.setup()):void 0},setup:function(){this.menu.setAttribute("aria-expanded","false"),-1===this.menu.className.indexOf("nav-menu")&&(this.menu.className+=" nav-menu"),this.on_click(),this.on_scroll(),this.on_mouseup(),this.on_focus(),this.on_touch()},open:function(){this.container.className+=" toggled",this.button.setAttribute("aria-expanded","true"),this.menu.setAttribute("aria-expanded","true"),this.is_open=!0,console.log("open")},close:function(){this.container.className=this.container.className.replace(" toggled",""),this.button.setAttribute("aria-expanded","false"),this.menu.setAttribute("aria-expanded","false"),this.is_open=!1,console.log("close")},on_click:function(){this.button.onclick=function(){-1===nav.container.className.indexOf("toggled")?nav.open():nav.close()}},on_focus:function(){for(this.links=this.menu.getElementsByTagName("a"),i=0,len=this.links.length;i<len;i++)this.links[i].addEventListener("focus",nav.toggle_focus,!0),this.links[i].addEventListener("blur",nav.toggle_focus,!0)},on_scroll:function(){window.addEventListener("scroll",function(){nav.is_open&&nav.close()},!1)},on_mouseup:function(){window.addEventListener("mouseup",function(a){a.target!=nav.button&&nav.is_open&&nav.close()})},toggle_focus:function(){for(var a=this;-1===a.className.indexOf("nav-menu");)"li"===a.tagName.toLowerCase()&&(-1===a.className.indexOf("focus")?a.className+=" focus":a.className=a.className.replace(" focus","")),a=a.parentElement},on_touch:function(){(function(a){var b,c,d=a.querySelectorAll(".menu-item-has-children > a, .page_item_has_children > a");if("ontouchstart"in window)for(b=function(a){var b,c=this.parentNode;if(!c.classList.contains("focus")){for(a.preventDefault(),b=0;b<c.parentNode.children.length;++b)c!==c.parentNode.children[b]&&c.parentNode.children[b].classList.remove("focus");c.classList.add("focus")}else c.classList.remove("focus")},c=0;c<d.length;++c)d[c].addEventListener("touchstart",b,!1)})(this.container)}};nav.init();

var _extends=Object.assign||function(t){for(var e=1;e<arguments.length;e++){var n=arguments[e];for(var o in n)Object.prototype.hasOwnProperty.call(n,o)&&(t[o]=n[o])}return t},_typeof="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t};!function(t,e){"object"===("undefined"==typeof exports?"undefined":_typeof(exports))&&"undefined"!=typeof module?module.exports=e():"function"==typeof define&&define.amd?define(e):t.LazyLoad=e()}(this,function(){"use strict";function t(t,e,n){var o=e._settings;!n&&i(t)||(C(o.callback_enter,t),R.indexOf(t.tagName)>-1&&(N(t,e),I(t,o.class_loading)),E(t,e),a(t),C(o.callback_set,t))}var e={elements_selector:"img",container:document,threshold:300,thresholds:null,data_src:"src",data_srcset:"srcset",data_sizes:"sizes",data_bg:"bg",class_loading:"loading",class_loaded:"loaded",class_error:"error",load_delay:0,callback_load:null,callback_error:null,callback_set:null,callback_enter:null,callback_finish:null,to_webp:!1},n=function(t){return _extends({},e,t)},o=function(t,e){return t.getAttribute("data-"+e)},r=function(t,e,n){var o="data-"+e;null!==n?t.setAttribute(o,n):t.removeAttribute(o)},a=function(t){return r(t,"was-processed","true")},i=function(t){return"true"===o(t,"was-processed")},s=function(t,e){return r(t,"ll-timeout",e)},c=function(t){return o(t,"ll-timeout")},l=function(t){return t.filter(function(t){return!i(t)})},u=function(t,e){return t.filter(function(t){return t!==e})},d=function(t,e){var n,o=new t(e);try{n=new CustomEvent("LazyLoad::Initialized",{detail:{instance:o}})}catch(t){(n=document.createEvent("CustomEvent")).initCustomEvent("LazyLoad::Initialized",!1,!1,{instance:o})}window.dispatchEvent(n)},f=function(t,e){return e?t.replace(/\.(jpe?g|png)/gi,".webp"):t},_="undefined"!=typeof window,v=_&&!("onscroll"in window)||/(gle|ing|ro)bot|crawl|spider/i.test(navigator.userAgent),g=_&&"IntersectionObserver"in window,h=_&&"classList"in document.createElement("p"),b=_&&function(){var t=document.createElement("canvas");return!(!t.getContext||!t.getContext("2d"))&&0===t.toDataURL("image/webp").indexOf("data:image/webp")}(),m=function(t,e,n,r){for(var a,i=0;a=t.children[i];i+=1)if("SOURCE"===a.tagName){var s=o(a,n);p(a,e,s,r)}},p=function(t,e,n,o){n&&t.setAttribute(e,f(n,o))},y=function(t,e){var n=b&&e.to_webp,r=o(t,e.data_src),a=o(t,e.data_bg);if(r){var i=f(r,n);t.style.backgroundImage='url("'+i+'")'}if(a){var s=f(a,n);t.style.backgroundImage=s}},w={IMG:function(t,e){var n=b&&e.to_webp,r=e.data_srcset,a=t.parentNode;a&&"PICTURE"===a.tagName&&m(a,"srcset",r,n);var i=o(t,e.data_sizes);p(t,"sizes",i);var s=o(t,r);p(t,"srcset",s,n);var c=o(t,e.data_src);p(t,"src",c,n)},IFRAME:function(t,e){var n=o(t,e.data_src);p(t,"src",n)},VIDEO:function(t,e){var n=e.data_src,r=o(t,n);m(t,"src",n),p(t,"src",r),t.load()}},E=function(t,e){var n=e._settings,o=t.tagName,r=w[o];if(r)return r(t,n),e._updateLoadingCount(1),void(e._elements=u(e._elements,t));y(t,n)},I=function(t,e){h?t.classList.add(e):t.className+=(t.className?" ":"")+e},L=function(t,e){h?t.classList.remove(e):t.className=t.className.replace(new RegExp("(^|\\s+)"+e+"(\\s+|$)")," ").replace(/^\s+/,"").replace(/\s+$/,"")},C=function(t,e){t&&t(e)},O=function(t,e,n){t.addEventListener(e,n)},k=function(t,e,n){t.removeEventListener(e,n)},x=function(t,e,n){O(t,"load",e),O(t,"loadeddata",e),O(t,"error",n)},A=function(t,e,n){k(t,"load",e),k(t,"loadeddata",e),k(t,"error",n)},z=function(t,e,n){var o=n._settings,r=e?o.class_loaded:o.class_error,a=e?o.callback_load:o.callback_error,i=t.target;L(i,o.class_loading),I(i,r),C(a,i),n._updateLoadingCount(-1)},N=function(t,e){var n=function n(r){z(r,!0,e),A(t,n,o)},o=function o(r){z(r,!1,e),A(t,n,o)};x(t,n,o)},R=["IMG","IFRAME","VIDEO"],S=function(e,n,o){t(e,o),n.unobserve(e)},M=function(t){var e=c(t);e&&(clearTimeout(e),s(t,null))},j=function(t,e,n){var o=n._settings.load_delay,r=c(t);r||(r=setTimeout(function(){S(t,e,n),M(t)},o),s(t,r))},D=function(t){return t.isIntersecting||t.intersectionRatio>0},T=function(t){return{root:t.container===document?null:t.container,rootMargin:t.thresholds||t.threshold+"px"}},U=function(t,e){this._settings=n(t),this._setObserver(),this._loadingCount=0,this.update(e)};return U.prototype={_manageIntersection:function(t){var e=this._observer,n=this._settings.load_delay,o=t.target;n?D(t)?j(o,e,this):M(o):D(t)&&S(o,e,this)},_onIntersection:function(t){t.forEach(this._manageIntersection.bind(this))},_setObserver:function(){g&&(this._observer=new IntersectionObserver(this._onIntersection.bind(this),T(this._settings)))},_updateLoadingCount:function(t){this._loadingCount+=t,0===this._elements.length&&0===this._loadingCount&&C(this._settings.callback_finish)},update:function(t){var e=this,n=this._settings,o=t||n.container.querySelectorAll(n.elements_selector);this._elements=l(Array.prototype.slice.call(o)),!v&&this._observer?this._elements.forEach(function(t){e._observer.observe(t)}):this.loadAll()},destroy:function(){var t=this;this._observer&&(this._elements.forEach(function(e){t._observer.unobserve(e)}),this._observer=null),this._elements=null,this._settings=null},load:function(e,n){t(e,this,n)},loadAll:function(){var t=this;this._elements.forEach(function(e){t.load(e)})}},_&&function(t,e){if(e)if(e.length)for(var n,o=0;n=e[o];o+=1)d(t,n);else d(t,e)}(U,window.lazyLoadOptions),U});
var eveLazyLoad = new LazyLoad({ elements_selector: '.loadlzly', callback_set: function(el){ el.classList.add( 'active' ); } });

jQuery(document).ready(function($) {

  (function(){ console.log('<?php echo esc_html(get_bloginfo('name')); ?>'); })();

  $("a[href*='#']:not([href='#'])").click(function(){if(location.pathname.replace(/^\//,"")==this.pathname.replace(/^\//,"")&&location.hostname==this.hostname){var t=$(this.hash);if((t=t.length?t:$("[name="+this.hash.slice(1)+"]")).length)return $("html,body").animate({scrollTop:t.offset().top},1e3),!1}});

});
</script>
<?php

  }
endif;
<?php


/*
Plugin Name: Facebook Page Widget
Plugin URI: http://wojtek1150.pl/pluginy/wordpress-fb-page-plugin/
Description: The Page Plugin lets you easily embed and promote any Facebook Page on your website. Just like on Facebook, your visitors can like and share the Page without having to leave your site.
Author: Wojtek150
Version: 1.2
Author URI: http://wojtek1150.pl/
*/

//actions
add_action( 'admin_menu', 'fpw_add_admin_menu' );
add_action( 'admin_init', 'fpw_settings_init' );

//menu declaration
function fpw_add_admin_menu(  ) { 
    add_menu_page( 'FB Page Widget', 'FB Page Widget', 'manage_options', 'facebook_page_widget', 'fpw_options_page', 'dashicons-facebook' );
}

//create settings page
function fpw_settings_init(  ) { 

    register_setting( 'pluginPage', 'fpw_settings' );

    add_settings_section(
        'fpw_pluginPage_section', 
        '',
        '', 
        'pluginPage'
    );

    add_settings_field( 
        'fpw_app_id', 
        __( 'APP ID', 'wordpress' ), 
        'fpw_app_id_render', 
        'pluginPage', 
        'fpw_pluginPage_section' 
    );

    add_settings_field( 
        'fpw_page_name', 
        __( 'Page name', 'wordpress' ), 
        'fpw_page_name_render', 
        'pluginPage', 
        'fpw_pluginPage_section' 
    );

    add_settings_field( 
        'fpw_width', 
        __( 'Width', 'wordpress' ), 
        'fpw_width_render', 
        'pluginPage', 
        'fpw_pluginPage_section' 
    );

    add_settings_field( 
        'fpw_height', 
        __( 'Height', 'wordpress' ), 
        'fpw_height_render', 
        'pluginPage', 
        'fpw_pluginPage_section' 
    );

    add_settings_field( 
        'fpw_cover', 
        __( 'Cover Photo', 'wordpress' ), 
        'fpw_cover_render', 
        'pluginPage', 
        'fpw_pluginPage_section' 
    );

    add_settings_field( 
        'fpw_posts', 
        __( 'Page Posts', 'wordpress' ), 
        'fpw_posts_render', 
        'pluginPage', 
        'fpw_pluginPage_section' 
    );

    add_settings_field( 
        'fpw_friends', 
        __( 'Friends Faces', 'wordpress' ), 
        'fpw_friends_render', 
        'pluginPage', 
        'fpw_pluginPage_section' 
    );

    add_settings_field( 
        'fpw_position', 
        __( 'Widget position', 'wordpress' ), 
        'fpw_position_render', 
        'pluginPage', 
        'fpw_pluginPage_section' 
    );

}

function fpw_app_id_render(  ) { 
    $options = get_option( 'fpw_settings' );
    ?>
    <input type='text' class='regular-text' name='fpw_settings[fpw_app_id]' value='<?php echo $options['fpw_app_id']; ?>' placeholder='Aplication ID'>
    <p class="description" id="tagline-description">Leave empty to use my API</p>
    <?php
}

function fpw_page_name_render(  ) { 
    $options = get_option( 'fpw_settings' );
    ?>
    <input type='text' class='regular-text' name='fpw_settings[fpw_page_name]' value='<?php echo $options['fpw_page_name']; ?>' placeholder='Page id or name'>
    <p class="description" id="tagline-description">Default: <strong>facebook</strong></p>
    <?php
}

function fpw_width_render(  ) { 
    $options = get_option( 'fpw_settings' );
    ?>
    <input type='number' min='280' max='500' class='regular-text' name='fpw_settings[fpw_width]' value='<?php echo $options['fpw_width']; ?>' placeholder='The pixel width of the embed (Min. 280 to Max. 500)'>
    <p class="description" id="tagline-description">Default: <strong>280px</strong></p>
    <?php
}

function fpw_height_render(  ) { 
    $options = get_option( 'fpw_settings' );
    ?>
    <input type='number' min='130' type='text' class='regular-text' name='fpw_settings[fpw_height]' value='<?php echo $options['fpw_height']; ?>' placeholder='The pixel height of the embed (Min. 130)'>
    <p class="description" id="tagline-description">Default: <strong>280px</strong></p>
    <?php
}

function fpw_cover_render(  ) { 
    $options = get_option( 'fpw_settings' );
    ?>
    <label for='cover_photo'>
        <input type='checkbox' id='cover_photo' name='fpw_settings[fpw_cover]' <?php checked( $options['fpw_cover'], 1 ); ?> value='1'>
        Hide Cover Photo
    </label>	
    <?php
}

function fpw_posts_render(  ) { 
    $options = get_option( 'fpw_settings' );
    ?>
    <label for='page_posts'>
        <input type='checkbox' id='page_posts' name='fpw_settings[fpw_posts]' <?php checked( $options['fpw_posts'], 1 ); ?> value='1'>
        Show Page Posts
    </label>	
    <?php
}

function fpw_friends_render(  ) { 
    $options = get_option( 'fpw_settings' );
    ?>
    <label for='faces'>
        <input type='checkbox' id='faces' name='fpw_settings[fpw_friends]' <?php checked( $options['fpw_friends'], 1 ); ?> value='1'>
        Show Friends Faces
    </label>	
    <?php
}


function fpw_position_render(  ) { 
    $options = get_option( 'fpw_settings' );
    ?>
    <select name='fpw_settings[fpw_position]'>
        <option value='1' <?php selected( $options['fpw_position'], 1 ); ?>>Right center</option>
        <option value='2' <?php selected( $options['fpw_position'], 2 ); ?>>Left center</option>
    </select>
    <?php
}

function fpw_options_page() { 
    ?>
    <form action='options.php' method='post'>
        <h2>Facebook Page Widget settings</h2>
        <?php if( isset($_GET['settings-updated']) ) { ?>
            <div id="message" class="updated">
                <p><strong><?php _e('Settings saved.') ?></strong></p>
            </div>
        <?php } ?>
        <?php
        settings_fields( 'pluginPage' );
        do_settings_sections( 'pluginPage' );
        submit_button();
        ?>
    </form>
    <?php
}

function render_fpw_widget() {
	$options = get_option('fpw_settings');
        if($options['fpw_page_name'] ) {
            $page_name = $options['fpw_page_name'];
        } else {
            $page_name = "facebook";
        }
	if($options['fpw_width'] ) {
            $widget_width = $options['fpw_width'];
        } else {
            $widget_width = "280";
        }
        if($options['fpw_height'] ) {
            $widget_height = $options['fpw_height'];
        } else {
            $widget_height = "280";
        } 
        if($options['fpw_cover'] ) {
            $cover = "true";
        } else {
            $cover = "false";
        } 
        if($options['fpw_posts'] ) {
            $posts = "true";
        } else {
            $posts = "false";
        } 
        if($options['fpw_friends'] ) {
            $friends = "true";
        } else {
            $friends = "false";
        } 
        if($options['fpw_position'] == 1 ) {
            $position = 'right';
        } if($options['fpw_position'] == 2 ){
            $position = 'left';                
        }
        else {
            $position = 'right';
        }  	
	$content = sprintf( 
                '<div id="fpw_widget" class="'. $position .'"><div id="fpw_icon"></div><div class="fb-page" '
                . 'data-href="https://www.facebook.com/'. $page_name .'" '
                . 'data-width="'. $widget_width .'" '
                . 'data-height="'. $widget_height .'" '
                . 'data-hide-cover="'. $cover .'" '
                . 'data-show-facepile="'. $friends .'" '
                . 'data-show-posts="'. $posts .'">'
                . '<div class="fb-xfbml-parse-ignore"><blockquote '
                . 'cite="https://www.facebook.com/'. $page_name .'"><a '
                . 'href="https://www.facebook.com/'. $page_name .'">'. $page_name .'</a></blockquote></div></div></div>'
                );
		echo apply_filters( 'show_fpw_widget', $content, $options );
}
add_action ( 'wp_footer', 'render_fpw_widget', 1000 );

//Add JS
function add_fpw_widget_js() {	
        $options = get_option('fpw_settings');
            if ( $options['fpw_app_id'] ) {
                    $app_id = $options['fpw_app_id'];
            } else {
                    $app_id = "936044369739777";
            }           
	$js_content = '<div id="fb-root"></div>
            <script>(function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.3&appId=%s";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, \'script\', \'facebook-jssdk\'));</script>';
        echo sprintf($js_content, $app_id);        
}
add_action ( 'wp_head', 'add_fpw_widget_js' );

//Add CSS
function add_fpw_widget_css() {	
        $options = get_option('fpw_settings');
            if($options['fpw_width'] ) {
                $widget_width = $options['fpw_width'];
            } else {
                $widget_width = "280";
            }
            $content_width = $widget_width + 50;
	echo '<style type="text/css" media="screen">            
                #fpw_widget{
                    position:fixed;
                    top:50%;
                    width: '. $content_width .'px;
                    z-index:999;
                    transition: all .4s cubic-bezier(0.18, 0.89, 0.32, 1.28);                
                    -webkit-transform: translateY(-50%);
                    -moz-transform: translateY(-50%);
                    -ms-transform: translateY(-50%);
                    transform: translateY(-50%);
                }
                #fpw_icon{
                    display:block;
                    width:50px;
                    height:80px;
                    background:#3B5999 url('. plugins_url(). '/fb-page-widget/fb_icon.png) no-repeat 0 10px;
                    background-size:contain;
                }
                #fpw_widget.right{
                    right: -'. $widget_width .'px;            
                }
                #fpw_widget.right:hover{
                    right:0;
                }
                #fpw_widget.left{
                    left: -'. $widget_width .'px;            
                }
                #fpw_widget.left:hover{
                    left:0;
                }
                #fpw_widget.right #fpw_icon{
                    float:left;
                    border-radius:7px 0 0 7px;
                } 
                #fpw_widget.right .fb_iframe_widget{
                    float:right;
                }
                #fpw_widget.left #fpw_icon{
                    float:right;
                    border-radius:0 7px 7px 0;
                } 
                #fpw_widget.left .fb_iframe_widget{
                    float:right;
                }            
            </style>'; 
}
add_action ( 'wp_head', 'add_fpw_widget_css' );
?>
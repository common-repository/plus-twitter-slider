<?php
/**
 * @package plus-twitter-slider
*/
/*
Plugin Name: Plus Twitter Slider
Plugin URI: https://wordpress.org/plugins/plus-twitter-slider/
Description: Thanks for installing Plus Twitter Slider
Version: 1.0
Author: Jose Porit
Author URI: https://wordpress.org/support/profile/twitterslider
*/
class PlusTwitter{
    
    public $options;
    
    public function __construct() {
        $this->options = get_option('plus_twitter_plugin_options');
        $this->plus_twitter_slider_register_settings_and_fields();
    }
    
    public static function add_tw_slider_tools_options_page(){
        add_options_page('Plus Twitter Slider ', 'Plus Twitter Slider  ', 'administrator', __FILE__, array('PlusTwitter','plus_twitter_slider_tools_options'));
    }
    
    public static function plus_twitter_slider_tools_options(){
?>
<div class="wrap">
    <?php screen_icon(); ?>
    <h2>Plus Twitter Slider Configuration</h2>
    <form method="post" action="options.php" enctype="multipart/form-data">
        <?php settings_fields('plus_twitter_plugin_options'); ?>
        <?php do_settings_sections(__FILE__); ?>
        <p class="submit">
            <input name="submit" type="submit" class="button-primary" value="Save Changes"/>
        </p>
    </form>
</div>
<?php
    }
    public function plus_twitter_slider_register_settings_and_fields(){
        register_setting('plus_twitter_plugin_options', 'plus_twitter_plugin_options',array($this,'responsive_twitter_validate_settings'));
        add_settings_section('plus_twitter_main_section', 'Settings', array($this,'plus_twitter_main_section_cb'), __FILE__);
        //Start Creating Fields and Options
        //name options
        add_settings_field('name', 'Twitter Name', array($this,'name_settings'),__FILE__,'plus_twitter_main_section');
         //pageURL
        add_settings_field('id', 'Profile ID', array($this,'pageURL_settings'), __FILE__,'plus_twitter_main_section');
         //marginTop
        add_settings_field('icon', 'Margin Top', array($this,'marginTop_settings'), __FILE__,'plus_twitter_main_section');
        //alignment option
         add_settings_field('position', 'Alignment Position', array($this,'position_settings'),__FILE__,'plus_twitter_main_section');
         
         //color options
         add_settings_field('color', 'Link Color', array($this,'color_settings'),__FILE__,'plus_twitter_main_section');
    //width options
       // add_settings_field('width', 'Width', array($this,'width_settings'),__FILE__,'plus_twitter_main_section');
        //face options
        add_settings_field('theme', 'Widget Theme', array($this,'theme_settings'),__FILE__,'plus_twitter_main_section');
    
    }
    public function responsive_twitter_validate_settings($plugin_options){
        return($plugin_options);
    }
    public function plus_twitter_main_section_cb(){
        //optional
    }
     //pageURL_settings
    public function pageURL_settings() {
        if(empty($this->options['id'])) $this->options['id'] = "";
        echo "<input name='plus_twitter_plugin_options[id]' type='text' value='{$this->options['id']}' />";
    }
    

    //marginTop_settings
    public function marginTop_settings() {
        if(empty($this->options['icon'])) $this->options['icon'] = "150";
        echo "<input name='plus_twitter_plugin_options[icon]' type='text' value='{$this->options['icon']}' />";
    }
    
    //alignment_settings
    public function position_settings(){
        if(empty($this->options['position'])) $this->options['position'] = "right";
        $items = array('right','left');
        echo "<select name='plus_twitter_plugin_options[position]'>";
        foreach($items as $item){
            $selected = ($this->options['position'] === $item) ? 'selected = "selected"' : '';
            echo "<option value='$item' $selected>$item</option>";
        }
        echo "</select>";
    }

       //name_settings
    public function name_settings(){
      if(empty($this->options['name'])) $this->options['name'] = "";
        echo "<input name='plus_twitter_plugin_options[name]' type='text' value='{$this->options['name']}' />";
    }

      //theme_settings
    public function theme_settings(){
        if(empty($this->options['theme'])) $this->options['theme'] = "light";
        $items = array('light','dark');
        echo "<select name='plus_twitter_plugin_options[theme]'>";
        foreach($items as $item){
            $selected = ($this->options['theme'] === $item) ? 'selected = "selected"' : '';
            echo "<option value='$item' $selected>$item</option>";
        }
        echo "</select>";
    }
	
	 //name_settings
    public function color_settings(){
      if(empty($this->options['color'])) $this->options['color'] = "#820bbb";
        echo "<input name='plus_twitter_plugin_options[color]' type='color' value='{$this->options['color']}' />";
    }

     
}
add_action('admin_menu', 'plus_twitter_slider_trigger_options_function');

function plus_twitter_slider_trigger_options_function(){
    PlusTwitter::add_tw_slider_tools_options_page();
}

add_action('admin_init','plus_twitter_slider_trigger_create_object');
function plus_twitter_slider_trigger_create_object(){
    new PlusTwitter();
}
add_action('wp_footer','plus_twitter_slider_add_content_in_footer');
function plus_twitter_slider_add_content_in_footer(){
    
 $o = get_option('plus_twitter_plugin_options');
extract($o);
$responsive_tw = '';
$responsive_tw .= ' <a class="twitter-timeline" data-dnt="true" data-theme="'.$theme.'"  data-link-color="'.$color.'" href="https://twitter.com/'.$name.'" data-width="500" data-height="550" data-widget-id="'.$id.'">Tweets by @'.$name.'</a>' ;
$imgURL = plugins_url('plus-twitter-slider/assets/css/twitter-left.png');
$imgURLR = plugins_url('plus-twitter-slider/assets/css/twitter-right.png');
?>
<style type="text/css">



    .cd-main-content-tw .cd-btn-tw {
	height: 150px;
	width: 47px;
	position:fixed;
	top:<?php echo $icon;?>px;
   <?php if($position=='right'){ ?>

	background:url(<?php echo $imgURLR;?>);

	background-repeat: no-repeat;

	right: 0px;
   <?php } else { ?>

   background:url(<?php echo $imgURL;?>);
   background-repeat: no-repeat;
   left: 0px;
   <?php } ?> 

}

.cd-panel-content-tw {
min-width: 195px !important;
background: #fff;

}




</style>




  <main class="cd-main-content-tw">

        <a href="#0" class="cd-btn-tw"></a>

        <!-- your content here -->

    </main>


<?php if($position=='right'){ ?>
      <div class="cd-panel-tw from-right-tw ">
<?php } else { ?>
      <div class="cd-panel-tw from-left-tw ">
<?php } ?>    
    
        <header class="cd-panel-header-tw">
        
            <h3 style="text-align:center">Twitter Followers Slider</h3>
            <a href="#0" class="cd-panel-close-tw">Close</a>

        </header>
    


        <div class="cd-panel-container-tw" style="width:25%">

            <div class="cd-panel-content-tw">
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

               <?php echo $responsive_tw;?>
<div style="font-size: 9px; color: #808080; font-weight: normal; font-family: tahoma,verdana,arial,sans-serif; line-height: 1.28; text-align: <?php echo $position; ?>; direction: ltr;"><a href="https://www.nationalcprassociation.com/" target="_blank" style="color: #808080;">nationalcprassociation.com</a></div>
            </div> <!-- cd-panel-content -->

        </div> <!-- cd-panel-container -->

    </div> <!-- cd-panel -->
    
    <?php
}
add_action( 'wp_enqueue_scripts', 'register_plus_twitter_slider_likebox_sidebar_styles' );
 function register_plus_twitter_slider_likebox_sidebar_styles() {
    wp_register_style( 'register_plus_twitter_slider_likebox_sidebar_styles', plugins_url( 'assets/css/style.css' , __FILE__ ) );
    wp_enqueue_style( 'register_plus_twitter_slider_likebox_sidebar_styles' );
    wp_enqueue_script('jquery');
 }
add_action( 'wp_enqueue_scripts', 'wp_twitter_scripts_with_jquery' );
function wp_twitter_scripts_with_jquery()
{ wp_register_script( 'custom-script-tw', plugins_url( 'assets/js/main.js', __FILE__ ), array( 'jquery' ) );
    wp_enqueue_script( 'custom-script-tw' );
}
<?php
/* **********************************************************
    Namespace:  domain_hashlink
    Author:     Phillihp Harmon
    Contact:    phil.harmon@princetoninformation.com
    Date:       2012.04.08
    
    Description:
        Domain Hashlink Widget for WordPress
************************************************************* */
class DHL_Widget extends WP_Widget {
    function DHL_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'dhl', 'description' => 'DHL Widget' );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'dhl-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'dhl-widget', 'DHL Widget', $widget_ops, $control_ops );
	}
	
	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$name = $instance['name'];
		$sex = $instance['sex'];
		$show_sex = isset( $instance['show_sex'] ) ? $instance['show_sex'] : false;

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
        
        $dhl_field = $instance['searchField'];
        $dhl_button = $instance['searchButton'];
        
        if(DHLSettings::getVal('dhl_username'))
        switch($instance['search']) {
            case 'google':
                $dhl_field = "dhl_s";
                $dhl_button = "dhl_searchsubmit";
                include "code/dhl_google.php";
                break;
            case 'wordpress':
                $dhl_field = "dhl_s";
                $dhl_button = "dhl_searchsubmit";
                include "code/dhl_wordpress.php";
                break;
            default:
                $dhl_field = "inpSearch";
                $dhl_button = "btnSearch";
                include "code/dhl_code.php";
                break;
        }
        
		echo $after_widget;
	}
	
	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['name'] = strip_tags( $new_instance['name'] );
		
		$instance['search']       = strip_tags( $new_instance['search'] );
		$instance['searchField']  = strip_tags( $new_instance['searchField'] );
		$instance['searchButton'] = strip_tags( $new_instance['searchButton'] );
		$instance['show_custom']  = strip_tags( $new_instance['show_custom'] );
		
		/* No need to strip tags for sex and show_sex. */
		$instance['sex'] = $new_instance['sex'];
		$instance['show_sex'] = $new_instance['show_sex'];

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('DHL Search', ''), 'search'=>  __('Search', ''), 'name' => __('John Doe', ''), 'searchField'=>__('s'), 'searchButton'=>__('searchsubmit'), 'sex' => 'male', 'show_sex' => true );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
        
        <?php echo DHLSettings::getVal('dhl_username') == "" ? "<p><em>".DHLOutput::__("Inactive")."</em></p>" : ""; ?>
        
        <!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:90%;" />
		</p>
        
        <p>
			<label for="<?php echo $this->get_field_id( 'search' ); ?>"><?php _e("Fallback Search:"); ?></label>
			<select id="<?php echo $this->get_field_id( 'search' ); ?>" name="<?php echo $this->get_field_name( 'search' ); ?>" class="widefat" style="width:90%;">
				<option <?php if ( 'wordpress' == $instance['search'] ) echo 'selected="selected"'; ?> value="wordpress">WordPress</option>
				<!--<option <?php if ( 'google' == $instance['search'] ) echo 'selected="selected"'; ?> value="google">Google</option>-->
				<option <?php if ( 'none' == $instance['search'] ) echo 'selected="selected"'; ?> value="none">None</option>
			</select>
		</p>
	<?php
	}
}
?>

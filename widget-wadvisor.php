<?php
/*
 * Plugin Name: Wadvisor Plugin
 * Plugin URI: https://wadvisor.com
 * Description: Wadvisor plugin for Wordpress.
 * Author: JF Lefebvre
 * Version: 1.0.1.2
 * Author URI: https://wadvisor.com/jeff
 * Text Domain: wp-wadvisor
 * Domain Path: /languages
*/

// Block direct requests
if ( !defined('ABSPATH') )
    die('-1');

add_action( 'widgets_init', function(){
     register_widget( 'Wadvisor_Page_Widget' );
});


/**
 * Loads the Widget's text domain for localization and translation.
 */
// load plugin text domain
add_action( 'plugins_loaded', function() {
    load_plugin_textdomain( 'wp-wadvisor', false, basename( dirname( __FILE__ ) )  . '/languages/' );
});



/**
 * Adds Wadvisor_Page_Widget widget.
 */
class Wadvisor_Page_Widget extends WP_Widget {

    const HOST = 'wadvisor.com';

    /**
     * Register widget with WordPress.
     */
    function __construct() {

        parent::__construct(
            'Wadvisor_Page_Widget', // Base ID
            __('Wadvisor page widget', 'wp-wadvisor'), // Widget name will appear in UI
            array( 'description' => __('Generates a Wadvisor Page feed in your widget area.', 'wp-wadvisor'), ) // Args
        );

        function wadvisor_js() {
            echo '<script type="text/javascript" src="https://'.Wadvisor_Page_Widget::HOST.'/sdk.js"></script>';
        }

        // Add hook for admin <head></head>
        // add_action('admin_head', 'wadvisor_js');
        // Add hook for front-end <head></head>
        add_action('wp_head', 'wadvisor_js');
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {

        if( isset( $instance['title'] ) && !empty( $instance['title'] ) ) {
            $title = apply_filters( 'widget_title', $instance['title'] );
        } else {
            $title = NULL;
        }
        if(isset($instance['id']) && !empty($instance['id'])){
            $id = $instance['id'];
        } else {
            $id = NULL;
        }
        if(isset($instance['default_lang']) && !empty($instance['default_lang'])){
            $default_lang = $instance['default_lang'];
        } else {
            $default_lang = NULL;
        }
        if(isset($instance['show_covers']) && !empty($instance['show_covers'])){
            $show_covers = $instance['show_covers'];
        } else {
            $show_covers = NULL;
        }
        if(isset($instance['show_followers']) && !empty($instance['show_followers'])){
            $show_followers = $instance['show_followers'];
        } else {
            $show_followers = NULL;
        }
        if(isset($instance['show_questions']) && !empty($instance['show_questions'])){
            $show_questions = $instance['show_questions'];
        } else {
            $show_questions = NULL;
        }
        if(isset($instance['questions_limit']) && !empty($instance['questions_limit'])){
            $questions_limit = $instance['questions_limit'];
        } else {
            $questions_limit = NULL;
        }
        if(isset($instance['questions_max_height']) && !empty($instance['questions_max_height'])){
            $questions_max_height = $instance['questions_max_height'];
        } else {
            $questions_max_height = NULL;
        }

        echo $args['before_widget'];

        if ( !empty($title) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        echo '<div class="wadvisor-page"';
        if( isset( $id ) && !empty( $id ) ){
            echo 'data-id="' . $id . '"';
        }
        if( isset( $default_lang ) && !empty( $default_lang ) ){
            echo 'data-default-lang="' . $default_lang . '"';
        }
        if( isset( $show_covers ) && !empty( $show_covers ) ){
            echo 'data-show-covers="' . $show_covers . '"';
        }
        if( isset( $show_followers ) && !empty( $show_followers ) ){
            echo 'data-show-followers="' . $show_followers . '"';
        }
        if( isset( $show_questions ) && !empty( $show_questions ) ){
            echo 'data-show-questions="' . $show_questions . '"';
        }
        if( isset( $questions_limit ) && !empty( $questions_limit ) ){
            echo 'data-questions-limit="' . $questions_limit . '"';
        }
        if( isset( $questions_max_height ) && !empty( $questions_max_height ) ){
            echo 'data-questions-max-height="' . $questions_max_height . '"';
        }
        echo '></div>';

        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        } else {
            $title = __('Wadvisor Widget', 'wp-wadvisor');
        }
        if ( isset( $instance[ 'id' ] ) ) {
            $id = $instance[ 'id' ];
        } else {
            $id = '';
        }
        if ( isset( $instance[ 'default_lang' ] ) ) {
            $default_lang = $instance[ 'default_lang' ];
        } else {
            $default_lang = '';
        }
        if ( isset( $instance[ 'show_covers' ] ) ) {
            $show_covers = $instance[ 'show_covers' ];
        } else {
            $show_covers = 'true';
        }
        if ( isset( $instance[ 'show_followers' ] ) ) {
            $show_followers = $instance[ 'show_followers' ];
        } else {
            $show_followers = 'true';
        }
        if ( isset( $instance[ 'show_questions' ] ) ) {
            $show_questions = $instance[ 'show_questions' ];
        } else {
            $show_questions = 'true';
        }
        if ( isset( $instance[ 'questions_limit' ] ) ) {
            $questions_limit = $instance[ 'questions_limit' ];
        } else {
            $questions_limit = '';
        }
        if ( isset( $instance[ 'questions_max_height' ] ) ) {
            $questions_max_height = $instance[ 'questions_max_height' ];
        } else {
            $questions_max_height = '';
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wp-wadvisor'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'id' ); ?>"><?php _e('Page id*:', 'wp-wadvisor'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'id' ); ?>" name="<?php echo $this->get_field_name( 'id' ); ?>" type="text" value="<?php echo esc_attr( $id ); ?>" required="required">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'default_lang' ); ?>"><?php _e('Default language:', 'wp-wadvisor'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'default_lang' ); ?>" name="<?php echo $this->get_field_name( 'default_lang' ); ?>">
                <option value=""><?php _e('Auto', 'wp-wadvisor'); ?></option>
                <option value="fr-fr" <?php echo ($default_lang=='fr-fr')?'selected':''; ?>><?php _e('French (France)', 'wp-wadvisor'); ?></option>
                <option value="en-us" <?php echo ($default_lang=='en-us')?'selected':''; ?>><?php _e('English (US)', 'wp-wadvisor'); ?></option>
                <option value="en-gb" <?php echo ($default_lang=='en-gb')?'selected':''; ?>><?php _e('English (GB)', 'wp-wadvisor'); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'show_covers' ); ?>"><?php _e('Show covers:', 'wp-wadvisor'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'show_covers' ); ?>" name="<?php echo $this->get_field_name( 'show_covers' ); ?>" type="checkbox" value="true" <?php echo ($show_covers=='true')?'checked':''; ?>>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'show_followers' ); ?>"><?php _e('Show followers:', 'wp-wadvisor'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'show_followers' ); ?>" name="<?php echo $this->get_field_name( 'show_followers' ); ?>" type="checkbox" value="true" <?php echo ($show_followers=='true')?'checked':''; ?>>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'show_questions' ); ?>"><?php _e('Show questions:', 'wp-wadvisor'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'show_questions' ); ?>" name="<?php echo $this->get_field_name( 'show_questions' ); ?>" type="checkbox" value="true" <?php echo ($show_questions=='true')?'checked':''; ?>>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'questions_limit' ); ?>"><?php _e('Questions limit:', 'wp-wadvisor'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'questions_limit' ); ?>" name="<?php echo $this->get_field_name( 'questions_limit' ); ?>" type="text" value="<?php echo esc_attr( $questions_limit ); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'questions_max_height' ); ?>"><?php _e('Questions max height:', 'wp-wadvisor'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'questions_max_height' ); ?>" name="<?php echo $this->get_field_name( 'questions_max_height' ); ?>" type="text" value="<?php echo esc_attr( $questions_max_height ); ?>">
        </p>

        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['id'] = ( ! empty( $new_instance['id'] ) ) ? strip_tags( $new_instance['id'] ) : '';
        $instance['default_lang'] = ( ! empty( $new_instance['default_lang'] ) ) ? strip_tags( $new_instance['default_lang'] ) : '';
        $instance['show_covers'] = ( ! empty( $new_instance['show_covers'] ) ) ? strip_tags( $new_instance['show_covers'] ) : 'false';
        $instance['show_followers'] = ( ! empty( $new_instance['show_followers'] ) ) ? strip_tags( $new_instance['show_followers'] ) : 'false';
        $instance['show_questions'] = ( ! empty( $new_instance['show_questions'] ) ) ? strip_tags( $new_instance['show_questions'] ) : 'false';
        $instance['questions_limit'] = ( ! empty( $new_instance['questions_limit'] ) ) ? strip_tags( $new_instance['questions_limit'] ) : '';
        $instance['questions_max_height'] = ( ! empty( $new_instance['questions_max_height'] ) ) ? strip_tags( $new_instance['questions_max_height'] ) : '';
        return $instance;
    }

} // class Wadvisor_Page_Widget
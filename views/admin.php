<div class="ehw-container">
	<p>
		<label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e('Profile URL:', 'everyday-hero-widget'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" value="<?php echo $instance['url']; ?>" />
		<span class="ehw-description"><?php _e( 'The full url to your Everyday Hero profile (e.g https://give.everydayhero.com/au/TristanFightingFA)', 'everyday-hero-widget' ); ?></span>
	</p>
	<p>
    	<input id="<?php echo $this->get_field_id( 'logo' ); ?>" name="<?php echo $this->get_field_name( 'logo' ); ?>" type="checkbox" value="1" <?php checked( '1', $instance['logo'] ); ?> />
        <label for="<?php echo $this->get_field_id( 'logo' ); ?>"><?php _e('Show Everyday Hero logo?', 'everyday-hero-widget'); ?></label>
        <span class="ehw-description"><?php _e( 'Support Everyday Hero by displaying the logo in the widget.', 'everyday-hero-widget' ); ?></span>
	</p>   
</div>
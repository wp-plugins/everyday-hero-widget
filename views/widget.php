<?php 
   
?>
<div class="ehw-container">
    
    <?php if ( is_array( $data ) && !empty( $data ) ) : ?>
    
    <div class="ehw-avatar">
        <img class="ehw-avatar-img" src="<?php echo esc_url( $data['image'] ); ?>" alt="<?php echo esc_attr( $data['name'] ); ?>" />
    </div>
    
    <div class="ehw-content">
        <div class="ehw-name"><h6><?php echo esc_attr( $data['name'] ); ?></h6></div>
        
        <div class="ehw-stats-container">
            <div class="ehw-target"><span><?php echo __('My goal is', 'everyday-hero-widget'); ?></span> <span class="ehw-goal"><?php echo esc_attr( $data['currency'] ) . number_format( esc_attr( $data['target'] ), 0, "." , "," ); ?></span></div>
            
            <div class="ehw-progress-bar">
                <div class="ehw-progress-complete" style="width: <?php echo round( ( esc_attr( $data['current'] ) / esc_attr( $data['target'] ) ) * 100, 1); ?>%;">
                </div>
            </div>
            
            <ul class="ehw-stats">
                <li>
                    <span class="ehw-stats-value"><?php echo esc_attr( $data['donations'] ); ?></span>
                    <span class="ehw-stats-label"><?php echo __('Donations', 'everyday-hero-widget'); ?></span>
                </li>
                <li>
                    <span class="ehw-stats-value"><?php echo esc_attr( $data['currency'] ) . number_format( esc_attr( $data['current'] ), 2, "." , "," ); ?></span>
                    <span class="ehw-stats-label"><?php echo __('Donated', 'everyday-hero-widget'); ?></span>
                </li>
                <li>
                <?php if( $data['remaining'] <= 0 ) : ?>
                    <span class="ehw-stats-value ehw-stats-success"><?php echo __('Goal', 'everyday-hero-widget'); ?></span>
                    <span class="ehw-stats-label ehw-stats-success"><?php echo __('Reached!', 'everyday-hero-widget'); ?></span>
                <?php else: ?>
                    <span class="ehw-stats-value"><?php echo esc_attr( $data['currency'] ) . number_format( esc_attr( $data['remaining'] ), 2, "." , "," ); ?></span>
                    <span class="ehw-stats-label"><?php echo __('Still needed', 'everyday-hero-widget'); ?></span>
                <?php endif; ?>
                </li>
            </ul>
        </div>
        
        <div class="ehw-footer">
            <div class="ehw-donate">
                <a class="ehw-donate-btn" href="<?php echo esc_url( $data['profile'] ); ?>" target="_blank"><?php echo __('Give Now', 'everyday-hero-widget'); ?></a>
            </div>
            <?php if( esc_attr($instance['logo']) == 1 ) : ?>
            <div class="ehw-brand">
                <a class="ehw-brand-link" href="https://www.everydayhero.com" target="_blank">everydayhero</a>
            </div>
            <?php endif; ?>
        </div>
            
    </div>
    
    <?php else : ?>
    
        <div class="ehw-content">
            <p class="ehw-error">An error has occurred. Please check your Everyday Hero URL is complete and correct, and try again.</p>
        </div>
        
    <?php endif; ?>
</div>
<?php
use \ExclusiveAddons\Elementor\Helper;
global $post;
$cat_position_over_image = 'default';
if ( 'yes' !== $settings['exad_post_carousel_category_default_position'] ) :
    $cat_position_over_image = $settings['exad_post_carousel_category_position_over_image'];
endif;

if( 'yes' === $settings['exad_post_carousel_show_read_more_btn_new_tab'] ){
    $target = '_blank';
} else{
    $target = '_self';
}
?>

<article class="exad-post-grid-three">
    <div class="exad-post-grid-container image-position-<?php echo esc_attr( $settings['exad_post_carousel_image_align'] ); ?>">
        <?php do_action( 'exad_post_carousel_each_item_wrapper_before' ); ?>
        <?php if( 'yes' === $settings['exad_post_carousel_show_image'] && has_post_thumbnail() ) : ?>
            <figure class="exad-post-grid-thumbnail">
                <a href="<?php echo esc_url( get_permalink() ); ?>">
                    <?php the_post_thumbnail( $settings['post_carousel_image_size_size'] ); ?>
                </a>
                <?php 
                if ( 'yes' === $settings['exad_post_carousel_show_category'] && 'yes' !== $settings['exad_post_carousel_category_default_position'] ) :
                    if ('-top-right' === $settings['exad_post_carousel_category_position_over_image'] ): ?>
                        <?php if( 'post' === $settings['exad_post_carousel_type'] ) : ;?>
                            <ul class="exad-post-grid-category postion-top-right">
                                <?php Helper::exad_get_categories_for_post(); ?>
                            </ul>
                        <?php else : ?>
                            <ul class="exad-post-grid-category postion-top-right">
                                <?php Helper::exad_get_terms_custom_post(); ?>
                            </ul>
                        <?php 
                        endif;
                    endif;
                    
                endif; 
              
                ?>

            </figure>
        <?php endif; ?>

        <div class="exad-post-grid-body">
            <?php if( 'yes' === $settings['exad_post_carousel_show_category'] && ( 'yes' === $settings['exad_post_carousel_category_default_position'] || '-bottom-left' === $cat_position_over_image ) ) : ?>
                    <?php if( 'post' === $settings['exad_post_carousel_type'] ) : ;?>
                        <ul class="exad-post-grid-category cat-pos<?php echo esc_attr( $cat_position_over_image ); ?>">
                            <?php Helper::exad_get_categories_for_post(); ?>
                        </ul>

                    <?php else : ?>
                        <ul class="exad-post-grid-category cat-pos<?php echo esc_attr( $cat_position_over_image ); ?>">
                            <?php Helper::exad_get_terms_custom_post(); ?>
                        </ul>
            <?php    
                    endif;
            endif;

            if( 'yes' === $settings['exad_post_carousel_show_user_avatar'] || 'yes' === $settings['exad_post_carousel_show_user_name'] || 'yes' === $settings['exad_post_carousel_show_date'] ) : ?>
                <ul class="exad-post-data show-avatar-<?php echo esc_attr( $settings['exad_post_carousel_show_user_avatar'] ); ?>">
                    <?php do_action( 'exad_post_carousel_meta_before' ); ?>
                    <?php if ( 'yes' === $settings['exad_post_carousel_show_user_avatar'] || 'yes' === $settings['exad_post_carousel_show_user_name'] ) : ?>
                        <li class="exad-author-avatar">
                        <?php
                            if ( 'yes' === $settings['exad_post_carousel_show_user_avatar'] ) :
                                echo get_avatar( get_the_author_meta('email'), '40' );
                            endif;

                            if ( 'yes' === $settings['exad_post_carousel_show_user_name'] ) : ?>
                                <span class="exad-post-grid-author">
                                <?php echo ('yes' === $settings['exad_post_carousel_show_user_name_tag']) ? esc_html($settings['exad_post_carousel_user_name_tag']) : '' ; ?>
                                    <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="exad-post-grid-author-name"><?php echo get_the_author(); ?></a>
                                </span>
                            <?php endif; ?>
                        </li>
                    <?php
                    endif;

                    if('yes' === $settings['exad_post_carousel_show_date']) : ?>
                        <li class="exad-post-date">
                            <span>
                                <?php echo ('yes' === $settings['exad_post_carousel_show_date_tag']) ? esc_html($settings['exad_post_carousel_date_tag']) : '' ; ?>
                                <a href="<?php echo esc_url( get_permalink() ); ?>" class="exad-post-grid-author-date"><?php echo get_the_date(apply_filters( 'exad_post_carousel_date_format', 'jS M Y' ) ); ?></a>
                            </span>                           
                        </li>
                    <?php    
                    endif;      
                    do_action( 'exad_post_carousel_meta_after' ); ?>    
                </ul>
            <?php    
            endif;

            if ( 'yes' === $settings['exad_post_carousel_show_title'] ):
                if ( 'yes' === $settings['exad_post_carousel_title_full'] ) : ?>
                    <<?php echo $settings['exad_post_carousel_title_tag']; ?>>
                        <a href="<?php echo esc_url( get_permalink() ); ?>" class="exad-post-grid-title"><?php echo get_the_title(); ?></a>
                    </<?php echo $settings['exad_post_carousel_title_tag']; ?>>
                <?php else : ?>
                    <<?php echo $settings['exad_post_carousel_title_tag']; ?>>
                        <a href="<?php echo esc_url( get_permalink() ); ?>" class="exad-post-grid-title"><?php echo wp_trim_words( get_the_title(), $settings['exad_post_carousel_title_length'], '...' ); ?></a>
                    </<?php echo $settings['exad_post_carousel_title_tag']; ?>>
                <?php    
                endif;
            endif;

            if( 'yes' === $settings['exad_post_carousel_show_read_time'] || 'yes' === $settings['exad_post_carousel_show_comment'] ) : ?>
                <ul class="exad-post-grid-time-comment">
                    <?php if( 'yes' === $settings['exad_post_carousel_show_read_time'] ) : ?>
                        <li class="exad-post-grid-read-time"><?php echo Helper::exad_reading_time( get_the_content() ); ?></li>
                    <?php 
                    endif;

                    if( 'yes' === $settings['exad_post_carousel_show_comment'] ) : ?>
                    <li>
                        <a class="exad-post-grid-comment" href="<?php echo get_comments_link(); ?>"><?php echo get_comments_number().get_comments_number_text( ' comment', ' comment', ' comments' ); ?></a>
                    </li>
                    <?php endif; ?>
                </ul>
            <?php
            endif;
            
            do_action( 'exad_post_carousel_excerpt_wrapper_before' );
            if('yes' === $settings['exad_post_carousel_show_excerpt']): ?>
                <p class="exad-post-grid-description"><?php echo Helper::exad_get_post_excerpt( get_the_ID(), wp_kses_post( $settings['exad_carousel_excerpt_length'] ) ); ?></p>
            <?php
            endif;

            do_action( 'exad_post_carousel_excerpt_wrapper_after' );

            if ( !empty($settings['exad_post_carousel_read_more_btn_text']) && $settings['exad_post_carousel_show_read_more_btn'] === 'yes' ) : ?>
                <div class="exad-post-footer"><a href="<?php echo esc_url( get_the_permalink() ); ?>" class="read-more" target=<?php echo $target; ?>><?php echo esc_html( $settings['exad_post_carousel_read_more_btn_text'] ); ?></a></div>
            <?php 
            endif; 
            ?>
        </div>
        <?php do_action( 'exad_post_carousel_each_item_wrapper_after' ); ?>
    </div>
</article>
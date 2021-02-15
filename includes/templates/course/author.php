<?php
global $post;
extract($args);
$disable_course_author = get_tutor_option('disable_course_author');
$profile_url = tutils()->profile_url($post->post_author);

if (!$disable_course_author) : ?>
<div class="tutor-single-course-meta tutor-meta-top">
    <ul>
        <li class="tutor-single-course-author-meta">
            <?php if( 'on' === $profile_picture ) : ?>
            <div class="tutor-single-course-avatar">
                <a href="<?php echo $profile_url; ?>"> <?php echo tutils()->get_tutor_avatar($post->post_author); ?></a>
            </div>
            <?php endif; ?>
            <?php if( 'on' === $display_name) : ?>
            <div class="tutor-single-course-author-name">
                <span><?php _e('by', 'tutor'); ?></span>
                <a href="<?php echo $profile_url; ?>"><?php echo get_the_author_meta('display_name', $post->post_author); ?></a>
            </div>
            <?php endif; ?>
        </li>
    </ul>
</div>
<?php endif; ?>
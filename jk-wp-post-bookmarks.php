<?php defined('ABSPATH') || exit;

class jk_wp_post_bookmarks
{

    public static function the_bookmark_button($id, $user_id)
    {

        $is_user_logged_in = is_user_logged_in();

        $classes = array();

        if ($is_user_logged_in):

            $active = false;

            $bookmarks = get_option('bookmarks_user_' . $user_id);

            if (empty($bookmarks)):

                $bookmarks = array();

            endif;

            if (in_array($id, $bookmarks)):

                $active = true;

            endif;

            if ($active):

                array_push($classes, 'bookmark-active');

            endif;

        else:

            array_push($classes, 'login-modal-trigger');

            array_push($classes, 'not-authorize');

        endif;

        ?>

        <!-- Bookmark button -->
        <div class="bookmark-button <?php echo esc_attr(implode(' ', $classes)); ?>"
             data-post-id="<?php echo esc_attr($id); ?>">

            <!-- Bookmark icon -->
            <i class="far fa-bookmark"></i>

        </div>

        <?php
    }

}

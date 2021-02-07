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

    public function ajax_handler()
    {

        $post_id = $_POST['post_id'];

        $user_id = $_POST['user_id'];

        $active = $_POST['active'];

        $bookmarks = get_option('bookmarks_user_' . $user_id);

        if (empty($bookmarks)):

            $bookmarks = array();

        endif;

        if (!in_array($post_id, $bookmarks) && empty($active)):

            array_push($bookmarks, $post_id);

            update_option('bookmarks_user_' . $user_id, $bookmarks, false);

        endif;

        if ($active === 'active'):

            if (($key = array_search($post_id, $bookmarks)) !== false) :

                unset($bookmarks[$key]);

            endif;

            update_option('bookmarks_user_' . $user_id, $bookmarks, false);

        endif;

        die();

    }

    public function init(){

        add_action('wp_ajax_nopriv_jk_bookmarks', [$this, 'ajax_handler']);

        add_action('wp_ajax_jk_bookmarks', [$this, 'ajax_handler']);

    }

}

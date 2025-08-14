<?php
get_header();
?>

<style>
    .error-container {
        text-align: center;
        padding: 100px 20px;
    }

    .error-container h1 {
        font-size: 48px;
        color: #333;
    }

    .error-container p {
        font-size: 18px;
        color: #666;
        margin-bottom: 20px;
    }

    .back-home-button {
        display: inline-block;
        background-color: #0073aa; /* WordPress Blue */
        color: #fff;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .back-home-button:hover {
        background-color: #005177;
    }
</style>

<div class="error-container">
    <h1><?php _e('404 - Page Not Found', 'your-theme-textdomain'); ?></h1>
    <p><?php _e('Oops! The page you are looking for does not exist.', 'your-theme-textdomain'); ?></p>

    <a href="<?php echo esc_url(home_url('/')); ?>" class="back-home-button">
        <?php _e('Back to Home', 'your-theme-textdomain'); ?>
    </a>

    <div style="margin-top: 30px;">
        <?php get_search_form(); ?>
    </div>
</div>

<?php
get_footer();

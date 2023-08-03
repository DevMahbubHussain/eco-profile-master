<?php

namespace EcoProfile\Master\Admin\Metabox;

/**
 * Metabox API Wrapper class
 */
class Metabox
{
    /**
     * Constructor
     */
    public function __construct()
    {
        add_action('admin_init', array($this, 'fx_smb_settings_setup'));
        /* Add Meta Box */
        add_action('add_meta_boxes', array($this, 'fx_smb_submit_add_meta_box'));

        /* Reset Settings */
        add_action('fx_smb_settings_page_init', array($this, 'fx_smb_reset_settings'));

        /* Add Meta Box */
        add_action('add_meta_boxes', array($this, 'fx_smb_basic_add_meta_box'));
    }

    /**
     * Create Settings Page
     * @since 0.1.0
     * @link http://codex.wordpress.org/Function_Reference/register_setting
     * @link http://codex.wordpress.org/Function_Reference/add_menu_page
     * @uses fx_smb_setings_page_id()
     */
    public function fx_smb_settings_setup()
    {

        /* Register our setting. */
        register_setting(
            'fx_smb',                         /* Option Group */
            'fx_smb_basic',                   /* Option Name */
            'fx_smb_basic_sanitize'           /* Sanitize Callback */
        );

        /* Vars */
        $page_hook_id = $this->fx_smb_setings_page_id();

        /* Do stuff in settings page, such as adding scripts, etc. */
        /* Load the JavaScript needed for the settings screen. */
        add_action('admin_enqueue_scripts', array($this, 'fx_smb_enqueue_scripts'));
        add_action("admin_footer-{$page_hook_id}", array($this, 'fx_smb_footer_scripts'));

        /* Set number of column available. */
        add_filter('screen_layout_columns', array($this, 'fx_smb_screen_layout_column'), 10, 2);
    }

    /**
     * Utility: Page Hook
     * The Settings Page Hook, it's the same with global $hook_suffix.
     * @since 0.1.0
     */
    public function fx_smb_setings_page_id()
    {
        return 'toplevel_page_fx_smb';
    }

    /**
     * Load Script Needed For Meta Box
     * @since 0.1.0
     */
    public function fx_smb_enqueue_scripts($hook_suffix)
    {
        $page_hook_id = $this->fx_smb_setings_page_id();
        if ($hook_suffix == $page_hook_id) {
            wp_enqueue_script('common');
            wp_enqueue_script('wp-lists');
            wp_enqueue_script('postbox');
        }
    }

    /**
     * Footer Script Needed for Meta Box:
     * - Meta Box Toggle.
     * - Spinner for Saving Option.
     * - Reset Settings Confirmation
     * @since 0.1.0
     */
    public function fx_smb_footer_scripts()
    {
        $page_hook_id = $this->fx_smb_setings_page_id();
?>
        <script type="text/javascript">
            //<![CDATA[
            jQuery(document).ready(function($) {
                // toggle
                $('.if-js-closed').removeClass('if-js-closed').addClass('closed');
                postboxes.add_postbox_toggles('<?php echo $page_hook_id; ?>');
                // display spinner
                $('#fx_smb-form').submit(function() {
                    $('#publishing-action .spinner').css('display', 'inline');
                });
                // confirm before reset
                $('#delete-action .submitdelete').on('click', function() {
                    return confirm('Are you sure want to do this?');
                });
            });
            //]]>
        </script>
    <?php
    }

    /**
     * Number of Column available in Settings Page.
     * we can only set to 1 or 2 column.
     * @since 0.1.0
     */
    public function fx_smb_screen_layout_column($columns, $screen)
    {
        $page_hook_id = $this->fx_smb_setings_page_id();
        if ($screen == $page_hook_id) {
            $columns[$page_hook_id] = 2;
        }
        return $columns;
    }


    public function email_customizer_plugin_page()
    {

        /* global vars */
        global $hook_suffix;

        /* utility hook */
        do_action('fx_smb_settings_page_init');

        /* enable add_meta_boxes function in this page. */
        do_action('add_meta_boxes', $hook_suffix);
    ?>

        <div class="wrap">

            <h2>Settings Meta Box <a class="add-new-h2" target="_blank" href="http://shellcreeper.com/wp-settings-meta-box/">Read Tutorial</a></h2>

            <?php settings_errors(); ?>

            <div class="fx-settings-meta-box-wrap">

                <form id="fx_smb-form" method="post" action="options.php">

                    <?php settings_fields('fx_smb'); // options group  
                    ?>
                    <?php wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false); ?>
                    <?php wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false); ?>

                    <div id="poststuff">

                        <div id="post-body" class="metabox-holder columns-<?php echo 1 == get_current_screen()->get_columns() ? '1' : '2'; ?>">

                            <div id="postbox-container-1" class="postbox-container">

                                <?php do_meta_boxes($hook_suffix, 'side', null); ?>
                                <!-- #side-sortables -->

                            </div><!-- #postbox-container-1 -->

                            <div id="postbox-container-2" class="postbox-container">

                                <?php do_meta_boxes($hook_suffix, 'normal', null); ?>
                                <!-- #normal-sortables -->

                                <?php do_meta_boxes($hook_suffix, 'advanced', null); ?>
                                <!-- #advanced-sortables -->

                            </div><!-- #postbox-container-2 -->

                        </div><!-- #post-body -->

                        <br class="clear">

                    </div><!-- #poststuff -->

                </form>

            </div><!-- .fx-settings-meta-box-wrap -->

        </div><!-- .wrap -->
    <?php
    }

    public function fx_smb_submit_add_meta_box()
    {
        $page_hook_id = $this->fx_smb_setings_page_id();

        add_meta_box(
            'submitdiv',               /* Meta Box ID */
            'Save Options',            /* Title */
            array($this, 'fx_smb_submit_meta_box'),  /* Function Callback */
            $page_hook_id,                /* Screen: Our Settings Page */
            'side',                    /* Context */
            'high'                     /* Priority */
        );
    }
    /**
     * Submit Meta Box Callback
     * @since 0.1.0
     */
    public function fx_smb_submit_meta_box()
    {

        /* Reset URL */
        $reset_url = add_query_arg(
            array(
                'page' => 'fx_smb',
                'action' => 'reset_settings',
                '_wpnonce' => wp_create_nonce('fx_smb-reset', __FILE__),
            ),
            admin_url('admin.php')
        );

    ?>
        <div id="submitpost" class="submitbox">

            <div id="major-publishing-actions">

                <div id="delete-action">
                    <a href="<?php echo esc_url($reset_url); ?>" class="submitdelete deletion">Reset Settings</a>
                </div><!-- #delete-action -->

                <div id="publishing-action">
                    <span class="spinner"></span>
                    <?php submit_button(esc_attr('Save'), 'primary', 'submit', false); ?>
                </div>

                <div class="clear"></div>

            </div><!-- #major-publishing-actions -->

        </div><!-- #submitpost -->

    <?php
    }

    /**
     * Delete Options
     * @since 0.1.0
     */
    public function fx_smb_reset_settings()
    {

        /* Check Action */
        $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
        if ('reset_settings' == $action) {

            /* Check User Capability */
            if (current_user_can('manage_options')) {

                /* nonce */
                $nonce = isset($_REQUEST['_wpnonce']) ? $_REQUEST['_wpnonce'] : '';

                /* valid */
                if (wp_verify_nonce($nonce, 'fx_smb-reset')) {

                    /**
                     * Get all registered Option Names in current Option Group
                     * ( thanks to @justintadlock )
                     * @since 0.1.1
                     * @link http://themehybrid.com/board/topics/how-to-get-all-option-name-in-option-group
                     */
                    global $new_whitelist_options;
                    $option_names = $new_whitelist_options['fx_smb'];

                    /* Delete All Registered Option Names in the Group */
                    foreach ($option_names as $option_name) {
                        delete_option($option_name);
                    }

                    /* Utility hook. */
                    do_action('fx_smb_reset');

                    /* Add Update Notice */
                    add_settings_error("fx_smb", "", "Settings reset to defaults.", 'updated');
                }
                /* not valid */ else {
                    /* Add Error Notice */
                    add_settings_error("fx_smb", "", "Failed to reset settings. Please try again.", 'error');
                }
            }
            /* User Do Not Have Capability */ else {
                /* Add Error Notice */
                add_settings_error("fx_smb", "", "Failed to reset settings. You do not capability to do this action.", 'error');
            }
        }
    }

    public function fx_smb_basic_add_meta_box()
    {

        $page_hook_id = $this->fx_smb_setings_page_id();

        add_meta_box(
            'basic',                  /* Meta Box ID */
            'Meta Box',               /* Title */
            array($this, 'fx_smb_basic_meta_box'),  /* Function Callback */
            $page_hook_id,               /* Screen: Our Settings Page */
            'normal',                 /* Context */
            'default'                 /* Priority */
        );
    }

    /**
     * Submit Meta Box Callback
     * @since 0.1.0
     */
    public function fx_smb_basic_meta_box()
    {
    ?>
        <p>
            <label for="basic-text">Basic Text Input</label>
            <input id="basic-text" class="widefat" type="text" name="fx_smb_basic" value="<?php echo sanitize_text_field(get_option('fx_smb_basic', '')); ?>">
        </p>
        <p class="howto">To display this option use PHP code <code>get_option( 'fx_smb_basic' );</code>.</p>
<?php
    }

    /**
     * Sanitize Basic Settings
     * This function is defined in register_setting().
     * @since 0.1.0
     */
    public function fx_smb_basic_sanitize($settings)
    {
        $settings = sanitize_text_field($settings);
        return $settings;
    }
}

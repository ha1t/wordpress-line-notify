<?php
class LineNotifyAdmin
{
    const OPTIONS_KEY = 'wp_line_notify_options';

    public function __construct() {
        add_action('admin_menu', [$this, 'addMenu']);
    }

    public function addMenu() {
        add_options_page(
            'WP LINE Notify',
            'WP LINE Notify',
            'manage_options',
            __FILE__,
            [$this, 'optionsPage']
        );
    }

    private function updateOptions()
    {
        $options = [
            'line_notify_token'  => esc_attr($_POST['line_notify_token']),
        ];
        update_option(self::OPTIONS_KEY, $options);
    }

    public function optionsPage()
    {
        if (isset($_POST['update_option'])) {
            check_admin_referer(self::OPTIONS_KEY);
            $this->updateOptions();
            $message = _e('Options saved.');
            $saved_message = <<<EOD
<div id="message" class="updated fade">
<p><strong>{$message}</strong></p>
</div>
EOD;
            echo $saved_message;
        }

        $options = get_option(self::OPTIONS_KEY);
?>
<div class="wrap">
<h2>WP Rakuten Tag 設定画面</h2>
<form name="form" method="post" action="">
<?php wp_nonce_field(self::OPTIONS_KEY); ?>

<table class="form-table"><tbody>
<tr>
<th><label for="line_notify_token"><?php _e('LINE Notify の トークン', 'line_notify_token'); ?></label></th>
<td><input type="text" name="line_notify_token" id="line_notify_token" value="<?php echo esc_attr($options['line_notify_token']); ?>" style="width: 300px;" /></td>
</tr>
        </tbody></table>

        <input type="hidden" name="action" value="update" />
        <p class="submit">
        <input type="submit" name="update_option" class="button-primary" value="<?php _e('Save Changes'); ?>" />
        </p>
        </form>
        </div>
<?php
    }

}

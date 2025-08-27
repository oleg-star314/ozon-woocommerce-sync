<?php
$last_sync = get_option('ozon_last_sync');
$processed = get_option('ozon_last_processed', 0);
?>
<div class="wrap">
    <h2><?php esc_html_e('Ozon Sync Settings', 'ozon-sync'); ?></h2>
    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="ozon-sync-actions">
        <?php wp_nonce_field('ozon_sync_action'); ?>
        <input type="hidden" name="action" value="ozon_sync_action" />
        <button name="ozon_sync_button" value="check" class="button"><?php esc_html_e('Check Connection', 'ozon-sync'); ?></button>
        <button name="ozon_sync_button" value="full" class="button button-primary"><?php esc_html_e('Run Full Sync', 'ozon-sync'); ?></button>
        <button name="ozon_sync_button" value="delta" class="button"><?php esc_html_e('Run Delta Sync', 'ozon-sync'); ?></button>
    </form>
    <h3><?php esc_html_e('Status', 'ozon-sync'); ?></h3>
    <ul>
        <li><?php esc_html_e('Last sync:', 'ozon-sync'); ?> <?php echo $last_sync ? date_i18n('Y-m-d H:i', $last_sync) : __('Never', 'ozon-sync'); ?></li>
        <li><?php esc_html_e('Processed products:', 'ozon-sync'); ?> <?php echo intval($processed); ?></li>
    </ul>
    <div id="ozon-sync-loading">Loading...</div>
    <div class="ozon-sync-progress"></div>
</div>

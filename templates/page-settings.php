<div class="wrap">
    <h2>Post Meta Sync</h2>
    <?php if ( isset( $_POST['sync'] ) ) : ?>
    <p>Success!</p>
    <?php else : ?>
    <p>This plugin will attempt to automatically synchronize postmeta with your CFS field groups.</p>
    <p>The <code>meta_key</code> and CFS <code>field name</code> must match exactly in order for values to get synchronized.</p>
    <p>Please <strong>BACKUP YOUR DATABASE</strong> before proceeding.</p>
    <form method="post" action="">
        <input type="hidden" name="sync" value="1" />
        <input type="submit" class="button-primary" value="Synchronize" />
    </form>
<?php endif; ?>
</div>

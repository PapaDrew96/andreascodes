<?php
function code_snippet_block_render( $block, $content = '', $is_preview = false ) {
  // Debug log (optional)
  // error_log('✅ code_snippet_block_render triggered');

  // ACF fields
  $code        = get_field( 'code' );
  $language    = get_field( 'language' );
  $description = get_field( 'description' );

  // Preview mode
  if ( isset( $block['data']['__is_preview'] ) && $block['data']['__is_preview'] ) {
    echo '<pre><code>// Example Snippet</code></pre>';
    return;
  }

  if ( ! $code ) return;

  ?>
  <div class="custom-code-snippet-block p-4 rounded bg-dark text-white mb-4">
    <?php if ( $description ) : ?>
      <p class="mb-2 text-muted small fst-italic"><?php echo esc_html( $description ); ?></p>
    <?php endif; ?>

    <pre class="mb-0"><code class="language-<?php echo esc_attr( strtolower( $language ) ); ?>">
<?php echo htmlspecialchars( $code, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8' ); ?>
</code></pre>
  </div>
  <?php
}

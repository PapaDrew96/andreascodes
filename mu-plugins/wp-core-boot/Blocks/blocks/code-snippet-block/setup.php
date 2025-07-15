<?php
return array(
  'name'            => 'code-snippet',
  'title'           => 'Code Snippet',
  'description'     => 'Insert a block of code with optional language and description',
  'category'        => 'custom',
  'icon'            => 'editor-code',
  'keywords'        => array( 'code', 'snippet', 'developer' ),
  'mode'            => 'auto',
  'render_callback' => 'code_snippet_block_render',
  'supports'        => array( 'align' => false ),
  'example'         => array(
    'attributes' => array(
      'mode' => 'preview',
      'data' => array(
        '__is_preview' => true,
      ),
    ),
  ),
  
);

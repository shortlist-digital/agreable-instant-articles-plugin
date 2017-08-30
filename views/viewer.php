<!--suppress Annotator -->
<html>
<head style="margin:0;padding:0;">
    <title>Editor - <?php echo get_the_title() ?></title>
    <style>
        <?php include __DIR__.'/dracula.css';?>
    </style>
</head>
<body style="background:#2B2B2D">
<?php
/**
 * @var $debug array
 */
?>
<?php foreach ( $debug as $index => $item ) : ?>
    <h2 style="color:white"><?php echo $index ?></h2>
    <pre>
        <code>
            <?php if ( is_string( $item ) ): ?>
                <?php echo htmlspecialchars($item); ?>
            <?php else: ?>
                <?php echo htmlspecialchars( var_export( $item, true ) ); ?>
            <?php endif; ?>
        </code>
    </pre>
<?php endforeach; ?>
<!--suppress JSUnresolvedLibraryURL -->
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
<script>
    hljs.configure({useBR: false});
    hljs.initHighlightingOnLoad();
</script>
</body>
</html>
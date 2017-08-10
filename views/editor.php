<html>
<head style="margin:0;padding:0;">
    <title>Editor - <?php echo get_the_title() ?></title>
    <style>
        <?php include __DIR__.'/dracula.css';?>
    </style>
</head>
<body style="background:#2B2B2D">
<pre>
<code>
	<?php echo htmlspecialchars( $html ); ?>
</code>
</pre>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
<script>
    hljs.configure({useBR: false});
    hljs.initHighlightingOnLoad();
</script>
</body>
</html>
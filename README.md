Agreable Instant Articles Plugin
===============

## Instant Articles Plugin for Croissant powered sites

### Environment variables

There are 2 environment variables needed to be set for this plugin work correctly
 - `FACEBOOK_IA_DOMAIN`: `www.stylist.co.uk` or `www.shortlist.com` (and new websites in the future)
 - `SEGMENT_WRITE_KEY`: used for analytics purpose

### Generators

Contains generators for the following widgets

```
app/Generators
    ├── Divider.php
    ├── Embed.php
    ├── Footer.php
    ├── Gallery.php
    ├── GeneratorInterface.php
    ├── Heading.php
    ├── Html.php
    ├── Image.php
    ├── Listicle.php
    ├── Paragraph.php
    ├── PullQuote.php
    ├── StandFirst.php
    ├── SuperHero.php
    ├── Telemetry_acquisition.php
    └── views
        ├── embed.twig
        ├── footer.twig
        ├── gallery.twig
        ├── heading.twig
        ├── html.twig
        ├── image.twig
        ├── paragraph-social.twig
        ├── paragraph-template.twig
        ├── paragraph.twig
        ├── pull-quote.twig
        ├── standfirst.twig
        └── super-hero.twig
```

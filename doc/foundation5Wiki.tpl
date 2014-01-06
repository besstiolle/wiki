{process_pagedata}{content assign='content'}<!doctype html>
<html class='no-js' lang='en'>
  <head>

    {if isset($canonical)}<link rel="canonical" href="{$canonical}" />{elseif isset($content_obj)}<link rel="canonical" href="{$content_obj->GetURL()}" />{/if}

    <meta charset='utf-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
    <title>{sitename}  {title}</title>


    {metadata}
    {cms_stylesheet}
    {cms_selflink dir=start rellink=1}
    {cms_selflink dir=prev rellink=1}
    {cms_selflink dir=next rellink=1}

    <link rel='stylesheet' href='{root_url}/uploads/foundation/css/foundation.css' />
    
    <link rel='stylesheet' type='text/css' href='{root_url}/modules/Wiki/scripts/fancybox/jquery.fancybox.css?v=2.1.5' media='screen' />
    <script src='{root_url}/uploads/foundation/js/modernizr.js'></script>
    <script src='{root_url}/uploads/foundation/js/jquery.js'></script>

  </head>
  <body>
    
    <div class='row'>
      <div class='large-12 columns'>
        <h1>{if isset($title)}{$title|capitalize}{else}{title}{/if}</h1>
      </div>
    </div>
    
    <div class='row'>
      <div class='large-12 columns'>
      	<div class='panel'>{$content}
      	</div>
      </div>
    </div>

    <script src='{root_url}/uploads/foundation/js/foundation.min.js'></script>


    <!-- Add mousewheel plugin (this is optional) -->
    <script type='text/javascript' src='{root_url}/modules/Wiki/scripts/jquery/jquery.mousewheel-3.0.6.pack.js'></script>

    <!-- Add fancyBox main JS and CSS files -->
    <script type='text/javascript' src='{root_url}/modules/Wiki/scripts/fancybox/jquery.fancybox.js?v=2.1.5'></script>

    <!-- Add wiki Javascript code -->
    <!-- <script type='text/javascript' src='{root_url}/modules/Wiki/scripts/wiki.js'></script> -->

    <script>
      $(document).foundation();
    </script>

  </body>
</html>

{process_pagedata}{content assign='content'}!doctype html
html class=no-js lang=en
  head
    meta charset=utf-8 
    meta name=viewport content=width=device-width, initial-scale=1.0 
    title{sitename}  {title}title


    {metadata}
    {cms_stylesheet}
    {cms_selflink dir=start rellink=1}
    {cms_selflink dir=prev rellink=1}
    {cms_selflink dir=next rellink=1}

    link rel=stylesheet href={root_url}uploadsfoundationcssfoundation.css 
    
    link rel=stylesheet type=textcss href={root_url}modulesWikiscriptsfancyboxjquery.fancybox.cssv=2.1.5 media=screen 
    script src={root_url}uploadsfoundationjsmodernizr.jsscript
    script src={root_url}uploadsfoundationjsjquery.jsscript

  head
  body
    
    div class=row
      div class=large-12 columns
        h1{if isset($title)}{$titlecapitalize}{else}{title}{if}h1
      div
    div
    
    div class=row
      div class=large-12 columns
      	div class=panel{$content}
      	div
      div
    div

    script src={root_url}uploadsfoundationjsfoundation.min.jsscript


    !-- Add mousewheel plugin (this is optional) --
    script type=textjavascript src={root_url}modulesWikiscriptsjqueryjquery.mousewheel-3.0.6.pack.jsscript

    !-- Add fancyBox main JS and CSS files --
    script type=textjavascript src={root_url}modulesWikiscriptsfancyboxjquery.fancybox.jsv=2.1.5script

    !-- Add wiki Javascript code --
    script type=textjavascript src={root_url}modulesWikiscriptswiki.jsscript

    script
      $(document).foundation();
    script

  body
html

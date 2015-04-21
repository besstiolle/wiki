
<div class="off-canvas-wrap" data-offcanvas>
<div class="inner-wrap">

<nav class="tab-bar">

	<section class="middle tab-bar-section"> 
		
		<div class="right">

			<span data-tooltip aria-haspopup="true" class="has-tip" title="Go back home">
				<a href='{$root_wiki_url}'><i class="fi-home ico-bar ico-secondary"></i></a></span>
			<span data-tooltip aria-haspopup="true" class="has-tip" title="See the sitemap of the wiki.">
				<a href='{$root_wiki_url}/sitemap'><i class="fi-map ico-bar ico-secondary"></i></a></span>
			
		</div>

	</section>
</nav>



<section class="main-section">

<div class='panel no-margin'>

	{function name=sitemap}
		{if !empty($data)}
			<ul>
		{/if}

		{foreach $data as $key => $value}
			<li><a href='{$value.url}' class='{$value.css}'>{$value.label}</a>
			
			{if !empty($value.children)}	
				{sitemap data=$value.children}
			{/if}

			</li>
		{/foreach}

		{if !empty($data)}
			</ul>
		{/if}
	{/function}
	
	{sitemap data=$sitemap}

</div>

 </section> <a class="exit-off-canvas"></a> </div> </div>
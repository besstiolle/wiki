## Wiki

A small and powerfull wiki implementation for CmsMadeSimple

### features : 

 * multi lang by default
 * pretty-url
 * 1 sitemap by lang and by wiki
 * full markdown
 * preview
 * manage access (read / write / delete)
 * FEU compatible

### How install it ?

#### Download and install the module and its dependancies
  
You can find it on my [project's page](http://dev.cmsmadesimple.org/project/files/1256#package-1302)

The module need also [ORM](http://dev.cmsmadesimple.org/project/files/1250#package-1234) (version 0.3.3) and [Markdown Parser](http://dev.cmsmadesimple.org/project/files/1331#package-1297) (version 1.0.0) to work and need you to activate the pretty-url.


The installation of the module Wiki will create 2 templates, 4 css file and a new design. The templates and the CSS will need some stuff to work.

#### Download the foundation's package

You can find it on my [project's page](http://dev.cmsmadesimple.org/project/files/1256#package-1303)

You can unzip it in your directory /uploads/. The goal is to have /uploads/foundation/... Every JS and pictures will be there.

#### Create a new page or update a existing page into CmsMadeSimple

We need to have a page with one of the new templates, For example you can create the page "wiki". Remember the alias of the page

#### Define the settings of your new wiki

Copy / Past the alias in the options of the Wiki and ... voila ! you can test your website : www .yourwebsite.com/wiki

### How customize the wiki

You can define a lot of stuff. 

You can manage the language of the wiki, you can also manage only one lang and making the choice to remove the information of the lang into the URL generated.
You can change the access rights (read / write / delete). By default the wiki is readonly for security reasons.
You can change default behavior and making the choice of having multiple and different wikis on your website. In this case, every URL that will finish by WIKI will create a new wiki. Very powerfull like i said ;)

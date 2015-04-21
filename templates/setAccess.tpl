{* Simple Example *}

{Wiki action="setAccess" is_readable=TRUE is_writable=FALSE is_deletable=FALSE} 

{* Example with FEU *}
{*
{if $ccuser->loggedin()}
  {Wiki action="setAccess" is_readable=TRUE is_writable=TRUE is_deletable=TRUE author_name=ccUser::property('pseudo') author_id=$ccuser->loggedin() }
{else}
  {Wiki action="setAccess" is_readable=FALSE}
{/if}
*}
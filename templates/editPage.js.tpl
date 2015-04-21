<script type="text/javascript">
	//<![CDATA[

	  var timeoutID;
	  var label;
	  var cnt = 1;
	  var fieldPre = '.cancelPre';
	  var fieldPost = '.cancelPost';

	  var url = "{$preview|unescape:'htmlall'}&showtemplate=false";
	  var url_cancel = "{$cancel|replace:'&amp;':'&'}";
	
	  
	  $(document).ready(function () {
		  $("input.preview").click(function () { 
<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
				query = "{$actionid}vtitle=" + escape($("#{$actionid}vtitle").val()) + "&" 
					+ "{$actionid}vtext=" + escape($("#{$actionid}vtext").val()) + "&" 
					+ "{$actionid}palias=" + escape($("#{$actionid}palias").val()) + "&" 
					+ "{$actionid}vlang=" + $("#{$actionid}vlang").val();
		
=======
				query = "{$wiki_action_id}vtitle=" + encodeURI($("#{$wiki_action_id}vtitle").val()) + "&" 
					+ "{$wiki_action_id}vtext=" + encodeURI($("#{$wiki_action_id}vtext").val());

				/*	console.debug(url);
					console.debug(query); */
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e
				$.post( url, query).done(function( data ) {
					$("#preview_result").html(data);
					
					$("a.wikilinks").attr("target","_blank");
					
					$.fancybox.open( {
						href : '#preview_result', title : 'Preview', autoSize : false
					});
				});
			});
			
			$(fieldPost).click(function () { 
				location.href = url_cancel;
			});
			
			$(fieldPost).hide();	
			//All but fieldPre
			$(document).bind('click', function (e) {
				window.clearTimeout(timeoutID);
				$(fieldPre).show();
				$(fieldPost).hide();
				$(fieldPost).attr('disabled','disabled');
				if(label==null){
					label = $(fieldPost).val();
				}
				$(fieldPost).val(label);
				cnt=1;
			});

			$(fieldPre).bind('click', function(e) {
				e.stopPropagation();
				$(fieldPre).hide();
				$(fieldPost).show().attr('disabled','disabled');
				count(fieldPost);
				
			});
		});
		
		$("input.save").click(function () { 
<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
			$( "#{$actionid}moduleform_1" ).submit();
=======
			$( "#{$wiki_action_id}moduleform_1" ).submit();
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e
		});
		
		function count(fieldId) {
		  if(label==null){
			label = $(fieldId).val();
		  }
		  if(cnt <= 0){
			  $(fieldId).val(label);
			  $(fieldId).removeAttr('disabled');
		  } else {
			  $(fieldId).val(label + " " + (cnt) + "s");
			  cnt--;
			  timeoutID = window.setTimeout(function() {
			  	count(fieldId);
			  }, 1000);
		  }
		}

	// ]]>
	</script>
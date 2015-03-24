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
				query = "{$actionid}vtitle=" + escape($("#{$actionid}vtitle").val()) + "&" 
					+ "{$actionid}vtext=" + escape($("#{$actionid}vtext").val()) + "&" 
					+ "{$actionid}palias=" + escape($("#{$actionid}palias").val()) + "&" 
					+ "{$actionid}vlang=" + $("#{$actionid}vlang").val();
		
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
			$( "#{$actionid}moduleform_1" ).submit();
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
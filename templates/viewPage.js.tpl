<script type="text/javascript">
	//<![CDATA[

	  var timeoutID;
	  var label;
	  var cnt = 4;
	  var fieldPre = '.deletePre';
	  var fieldPost = '.deletePost';

	  var url = "{$raw|unescape:'htmlall'}&showtemplate=false";
	  var url_edit = "{$edit|replace:'&amp;':'&'}";
	  var url_goLast = "{$goLast|replace:'&amp;':'&'}";
	  var url_defaultLangCanonical = "{$defaultLangCanonical|replace:'&amp;':'&'}";
	  var url_delete = "{$delete|replace:'&amp;':'&'}";
	  
	  $(document).ready(function () {
		  $("input.raw").click(function () { 
				query = "";

				$.post( url, query).done(function( data ) {
					$("#raw_result").html(data);
									
					$.fancybox.open({
						href : '#raw_result', title : 'Raw Code', autoSize : false
					});
				});
			});
			
			$('.edit').click(function () { 
				location.href = url_edit;
			});

			$('.goLast').click(function () { 
				location.href = url_goLast;
			});
			
			$('.goLastDefaultLang').click(function () { 
				location.href = url_defaultLangCanonical;
			});
			

			$(fieldPost).click(function () { 
				location.href = url_delete;
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
				cnt=4;
			});

			$(fieldPre).bind('click', function(e) {
				e.stopPropagation();
				$(fieldPre).hide();
				$(fieldPost).show().attr('disabled','disabled');
				count(fieldPost);
				
			});
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
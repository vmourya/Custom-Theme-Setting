jQuery(document).ready(function(){
		jQuery("#cts-name").focusout(function(){
			n=jQuery("#cts-name").val().toLowerCase().trim();
			k=jQuery("#cts-key");
			id=jQuery("#cts-id").val();
			if(!id){
				if(n){
					k.val(n.replace(/ /g,'-'));
				}else{k.val('');}
			}
		});
		
		jQuery("#cts-section-name").focusout(function(){
			n=jQuery("#cts-section-name").val().toLowerCase().trim();
			k=jQuery("#cts-section-key");
			id=jQuery("#cts-section-id").val();
			if(!id){
				if(n){
					k.val(n.replace(/ /g,'-'));
				}else{k.val('');}
			}	
		});		
		jQuery(".help-popup-container span.help").hover(function(){
			d=jQuery(this).attr("data");
			jQuery(".help-popup-container span#"+d).fadeIn(200);
		});
		jQuery(".help-popup-container span.help-text").mouseout(function () {
			jQuery(".help-popup-container span.help-text").fadeOut(200);
		});
		
	/* preview of Image */	
	function viewImg(input) {
		var imgId=input.id + '-img';
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				jQuery("#" + imgId).attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	jQuery(".cts-image").change(function(){
		viewImg(this);
	});
	

	/* SECTION CONTROL START */
	jQuery('.section-title').click(function(){
		i = jQuery(this).attr('data');
		if(jQuery("#"+i).hasClass('active-panel')){
			jQuery("#"+i).slideUp(500);			
			jQuery("#"+i).removeClass('active-panel');
			jQuery(this).children('img').css('transform','rotate(90deg)');
			
		}else{
			jQuery("#"+i).slideDown(500);
			/* TEXTAREA TO TEXT EDITOR START */
			jQuery("#"+i + " .text-editor").cleditor();
			/* TEXTAREA TO TEXT EDITOR END */
			jQuery("#"+i).addClass('active-panel');
			jQuery(this).children('img').css('transform','rotate(-90deg)');
		}

	});
	/* SECTION CONTROL END */
	
	//jQuery(".section-fields").css("display","none");
	
	jQuery(".save-all-form").click(function(){
 
	});
});
<?php
add_action("admin_init", "photos_init");
add_action('save_post', 'save_photos');
add_action('delete_post', 'delete_photos');

add_filter('admin_head','photo_js');

function photos_init(){
	$template = get_post_meta($_REQUEST['post'], '_wp_page_template', true);
	if ($template == 'home.php')
		add_meta_box("photo_box", "Homepage Banners", "photo_box", "page", "normal", "high");
}

function photo_box() {
	$template = get_post_meta($_REQUEST['post'], '_wp_page_template', true);

	$photos_c = new Photos();
	$photos = $photos_c->getPhotos($_REQUEST['post']);
	if(count($photos>0))
	{
	?>
	   	<ul id="sortablePhoto">
		<?php
		for($i=0; $i<count($photos); $i++)
		{
			$photoID = $photos[$i]["photoID"];
			$imageurl = $photos[$i]["imageurl"];
			$thumburl = $photos[$i]["thumburl"];
			$imagetitle = $photos[$i]["imagetitle"];
			$imagedescription = $photos[$i]["imagedescription"];
			$imagelink = $photos[$i]["imagelink"];
			?>
			<li class="ui-state-default photo-thumb-holder" style="float: left; margin: 0 10px 10px 0; background-color: #CCC; padding: 5px; position: relative;">
				<img src="<?php echo(get_bloginfo("template_directory") . '/images/remove.png');?>" class="removephoto" width="24" height="24" alt="Remove" style="position:absolute; top: 0; right: 0; cursor: pointer" />
                <table style="float:left; width: 200px;">
                    <tr>
                        <td>
                            <img src="<?php echo($imageurl); ?>" class="photo_img" alt="<?php echo($imagetitle); ?>" style="float:left;" width="200" /><br />
                            <input type="button" value="Edit Banner" class="edit_photo button-secondary" style="margin-top: 10px;" />
                        </td>
                    </tr>
                </table>
                <input type="hidden" size="36" name="upload_photoimage[]" class="upload_photoimage" value="<?php echo($imageurl); ?>" />
			</li>
			<?php
		}
		?>
		</ul>
	<?php
	}
	?>
	<input id="upload_photoimage_button" type="button" value="Add Banner" class="button-secondary" style="display:block; cursor:pointer; clear: both;" />
	<br />
    <?php
}

function save_photos($pID) {
	global $wpdb;
	$upload_photoimage = $_POST['upload_photoimage'];
	$upload_phototitle = $_POST['upload_phototitle'];
	$upload_photodescription = $_POST['upload_photodescription'];
	$upload_photolink = $_POST['upload_photolink'];
	
	//save photos
	//delete all photos first then resave photos
	$sql = "DELETE FROM " . BMMI_PHOTO_TBL . " WHERE postID = $pID;";
	$wpdb->query($sql);	
	
	$length = count($upload_photoimage);
	for($i=0; $i < $length; $i++)
	{
		$photo_image = $upload_photoimage[$i];
		$photo_phototitle = $upload_phototitle[$i];
		$photo_photodescription = $upload_photodescription[$i];
		$photo_photolink = $upload_photolink[$i];
		
		$sql = "
		INSERT INTO " . BMMI_PHOTO_TBL . "(imageurl,imagetitle,imagedescription,imagelink,postID) VALUES ('" .  $wpdb->escape(stripcslashes($photo_image)) . "','" . $wpdb->escape(stripcslashes($photo_phototitle)) . "','" . $wpdb->escape(stripcslashes($photo_photodescription)) . "','" . $wpdb->escape(stripcslashes($photo_photolink)) . "'," . $pID . ");";
		$wpdb->query($sql);
	}
}

function delete_photos($post_id) {
	global $wpdb;
	/*
	//WILL ONLY BE PERFORMED WHEN POST IS DELETED IN RECYCLE BIN
	*/
	$sql = "DELETE FROM " . BMMI_PHOTO_TBL . " WHERE postID = $post_id ";
	$wpdb->query($sql);
}

function photo_js()
{
?>
    <script type="text/javascript">
    jQuery(function() {
		jQuery( "#sortablePhoto" ).sortable();
    });

	jQuery(document).ready(function() {	
		/* PHOTOS ------------------------------------ */
		jQuery('#upload_photoimage_button').click(function() {
			tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
			
			window.original_send_to_editor = window.send_to_editor;
			window.send_to_editor = function(html)
			{
				imgurl = jQuery('img',html).attr('src');
				
				var imgitm = '<li class="ui-state-default photo-thumb-holder" style="float: left; margin: 0 10px 10px 0; background-color: #CCC; padding: 5px; position: relative;">';
					imgitm += '<img src="<?php echo(get_bloginfo("template_directory") . '/images/remove.png');?>" class="removephoto" width="24" height="24" alt="Remove" style="position:absolute; top: 0; right: 0; cursor: pointer" />';
					imgitm += '<table style="float:left; width: 200px;">';
						imgitm += '<tr>';
							imgitm += '<td>';
								imgitm += '<img src="' + imgurl + '" class="photo_img" width="200" alt="" style="float:left;" /><br />';
								imgitm += '<input type="button" value="Edit Photo" class="edit_photo button-secondary" style="margin-top: 10px;" />';
							imgitm += '</td>';
						imgitm += '</tr>';
					imgitm += '</table>';
					imgitm += '<input type="hidden" size="36" name="upload_photoimage[]" class="upload_photoimage" value="' + imgurl + '" />';
				//	imgitm += '<div style="float:left; padding-left: 10px;">';
				//		imgitm += 'Title:<br /><input type="text" size="36" name="upload_phototitle[]" value="" style="width: 300px;" /><br />';
				//		imgitm += 'Description:<br /><textarea name="upload_photodescription[]" style="width: 300px; height: 150px;"></textarea><br />';
				//		imgitm += 'Link URL:<br /><input type="text" size="36" name="upload_photolink[]" value="" style="width: 300px;" />';
				//	imgitm += '</div>';
				imgitm += '</li>';
				jQuery('#sortablePhoto').append(imgitm);
				tb_remove();
				
				jQuery('img.removephoto').click(function(){
					jQuery(this).parent().remove();
				});

				jQuery('.edit_photo').click(function() {
					formfield = jQuery(this).closest('li').find('.upload_photoimage');
					imgfield = jQuery(this).closest('li').find('.photo_img');
					tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		
					window.original_send_to_editor = window.send_to_editor;
					window.send_to_editor = function(html)
					{
						imgurl = jQuery('img',html).attr('src');
						formfield.val(imgurl);
						imgfield.attr("src",imgurl);
							
						tb_remove();
					}
				});
			}
		});

		jQuery('img.removephoto').click(function(){
			jQuery(this).parent().remove();
		});

		jQuery('.edit_photo').click(function() {
			formfield = jQuery(this).closest('li').find('.upload_photoimage');
			imgfield = jQuery(this).closest('li').find('.photo_img');
			tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');

			window.original_send_to_editor = window.send_to_editor;
			window.send_to_editor = function(html)
			{
				imgurl = jQuery('img',html).attr('src');
				formfield.val(imgurl);
				imgfield.attr("src",imgurl);
					
				tb_remove();
			}
		});
		/* //PHOTOS ------------------------------------ */
    });
	</script>
<?php
}
?>
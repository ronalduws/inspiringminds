<?php
add_action("admin_init", "admin_init");
add_action('save_post', 'save_details');
add_action('delete_post', 'post_delete');
 
function admin_init(){
	add_meta_box("additional_meta", "Files and Attachments", "additional_meta", "page", "normal", "high");
}

function additional_meta() {
	$current_action = "";

	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
	{
		echo '<input type="hidden" name="post_edit_id" value="' . $_REQUEST['post'] . '" readonly="readonly" />';
	}
	
	//TODO ADDITIONAL FORM HERE
	?>
    <input type="hidden" name="fileuploads" value="true" />
    <table class="widefat post" cellspacing="0" style="width:100%;">
        <tbody>
            <tr>
                <th style="vertical-align:top; padding-top: 10px;">Upload File</th>
                <td style="padding-bottom: 10px;">
                	<?php
					if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
					{
					?>
                        <ul id="tblobjects" class="file_sortable">
                            <?php
							$cfiles = new Files();
                            $file = $cfiles->get_Files_Attached($_REQUEST['post']);
							for($i=0;$i<count($file);$i++)
							{
                                $pfilename = $file[$i]["pfilename"];
                                $purl = $file[$i]["purl"];
                                $plabel = $file[$i]["plabel"];
                                $ptype = $file[$i]["ptype"];
								?> 	 	 	 	
                                <li>
                                	<table>
                                    <tr>
                                    <td style="border-bottom: none; padding: 5px;">
                                        <label>File:</label><br />
                                        <input type="text" name="c_fname[]" class="txt_input_file" id="c_text_<?php echo($fpID); ?>" value="<?php echo($pfilename); ?>" readonly="readonly" />
                                        <input type="button" class="button-secondary editfile" value="Browse" />
                                    </td>
                                    <td style="border-bottom: none; padding: 5px;">
                                        <label>Label:</label><br />
                                        <input type="text" name="c_label[]" value="<?php echo($plabel); ?>" />
                                    </td>
                                    <td style="border-bottom: none; padding: 5px;">
                                        <label>Custom URL [Optional]:</label><br />
                                        <input type="text" name="c_url[]" value="<?php echo($purl); ?>" />
                                    </td>
                                    <td style="border-bottom: none; padding: 5px;">
                                        <label>Attachment Type:</label><br />
                                        <select name="c_type[]">
                                            <option value="0" <?php echo($ptype==0?'selected="selected"':''); ?>>Download</option>
                                            <option value="1" <?php echo($ptype==1?'selected="selected"':''); ?>>Image Link</option>
                                        </select>
                                    </td>
                                    <td style="border-bottom: none;"><img src="<?php bloginfo('template_directory'); ?>/images/trash.png" alt="delete" class="removerow" style="cursor:pointer; margin-top:5px;" title="Click to remove row" /></td>
                                    </tr>
                                    </table>
                                </li>
                                <?php
                                $countmenus++;
							}
                            ?>
                            <script type="text/javascript">passrows(<?php echo($countmenus); ?>)</script>
                        </ul>
                        
					<?php
						if($countmenus <= 0) echo '<span style="color: RED; display:block; padding: 10px 0;" class="fpresentlabel">NO FILE PRESENT</span>';
					}
					else
					{
					?>
                        <ul id="tblobjects" class="file_sortable">
                        </ul>
                    <?php
					}
					?>
                	<input type="button" class="button-secondary" name="addelement" id="addelement" value="Add a file" style="cursor:pointer;" />            
                </td>
            </tr>
		</tbody>
    </table>  
    <?php
}

/* ---------------------------------------------------------------- */
/* FUNCTIONS TO SAVE */
/* ---------------------------------------------------------------- */
function save_details(){
	global $post;
	global $wpdb;

	$currentservertime = current_time('mysql');
	//TODO UPDATE TABLE HERE

	$sql = "DELETE FROM " . BMMI_PAGE_FILES_TBL . " WHERE pID = " . $post->ID;
	$wpdb->query($sql);
	/* Add previous attachements */
	if(isset($_POST['c_fname']))
	{
		   
		$c_fname = $_POST['c_fname'];
		$c_label = $_POST['c_label'];
		$c_url = $_POST['c_url'];
		$c_type = $_POST['c_type'];
		$length = count($c_fname);
		for($i=0; $i < $length; $i++)
		{
			$attachment_url = $c_fname[$i];
			$plabel = $c_label[$i];
			$purl = $c_url[$i];
			$ptype = $c_type[$i];
			$sql = "
				INSERT INTO " . BMMI_PAGE_FILES_TBL . "
				(
					pID, pfilename, plabel, purl, ptype
				) VALUES (
					" .  $post->ID . ",
					'" .  $attachment_url . "',
					'" .  $plabel . "',
					'" .  $purl . "',
					'" .  $ptype . "'
				);";
			$wpdb->query($sql);
		}
	}

	if(isset($_POST['fileuploads']))
	{
		$file_label = $_POST['file_label'];
		$custom_url = $_POST['custom_url'];
		$attachments = $_POST['attachments'];
		$attachmenttype = $_POST['attachmenttype'];

		/* create DIRECTORY if not exist */
		$upload_dir = wp_upload_dir();
		$uploadfolder = $upload_dir['basedir']."/bmmi-uploads/";
		$uploadurl = $upload_dir['baseurl']."/bmmi-uploads/";
		if (!is_dir($uploadfolder)) { mkdir($uploadfolder, 0777); }
	
		$max_file_size_in_bytes = 2147483647; // 2GB in bytes

		$attachment_url = "";
		if(isset($_FILES["attachments"]))
		{
			$tmp_namex = "";
			$ctr = 0;
			foreach ($_FILES["attachments"]["error"] as $key => $error) {
				$attachment_url = "";	
				if ($error == UPLOAD_ERR_OK) {
					$tmp_name = $_FILES["attachments"]["tmp_name"][$key];
					$tmp_namex .= $tmp_name;
					$name = $_FILES["attachments"]["name"][$key];
					$filesize = $_FILES["attachments"]["size"][$key];
					$ext = substr(strrchr($name, "."),1);
					if (!$filesize > $max_file_size_in_bytes) {
						$submit_error = true;
						$error_msg = "Some files was not successfully uploaded because it exceeds the maximum allowed size";
					}
					else
					{
						$file_name_attachment = $name;
						/*						
						$file_name_attachment = md5( rand(0,99999) . date('Ymd') . microtime(true) ) . "." . $ext;
						while ( file_exists($uploadfolder . $file_name_attachment) ) 
						   $file_name_attachment = md5( rand(0,99999) . date('Ymd') . microtime(true) ) . "." . $ext;
						*/
						
						// Validate file extension
						$path_info_attachment = pathinfo($_FILES['attachments']['name'][$key]);
						$file_extension_attachment = $path_info_menu["extension"];
			
						$uploaded_filenameattachment = $uploadfolder.$file_name_attachment;
						$attachment_url = $uploadurl.$file_name_attachment;
						$upload_attachment = move_uploaded_file($tmp_name, $uploaded_filenameattachment);
					}
				}
				$plabel = $file_label[$ctr];
				$purl = $custom_url[$ctr];
				$ptype = $attachmenttype[$ctr];
				$sql = "
					INSERT INTO " . BMMI_PAGE_FILES_TBL . "
					(
						pID, pfilename, plabel, purl, ptype
					) VALUES (
						" .  $post->ID . ",
						'" .  $attachment_url . "',
						'" .  $plabel . "',
						'" .  $purl . "',
						'" .  $ptype . "'
					);";
				$wpdb->query($sql);
				$ctr++;
			}
		}	
	}
	
}

function post_delete($post_id) {
	global $wpdb;
	/*
	//WILL ONLY BE PERFORMED WHEN POST IS DELETED IN RECYCLE BIN
	*/
	$sql = "DELETE FROM " . BMMI_PAGE_FILES_TBL . " WHERE pID = $post_id ";
	$wpdb->query($sql);
}
/* ---------------------------------------------------------------- */
?>
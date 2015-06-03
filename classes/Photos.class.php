<?php
class Photos {
	 	 	 	 	 	 	 	
	public $photoID;
	public $imageurl;
	public $thumburl;
	public $imagetitle;
	public $imagedescription;
	public $imagelink;
	
	function __construct($photoID=0) {
		$output = json_decode(query_Table(BMMI_PHOTO_TBL,"WHERE ID = $photoID ORDER BY ID ASC"));
		if(count_POST(BMMI_PHOTO_TBL) > 0)
		{
			foreach ($output as $name => $value)
			{
				$this->photoID = $value->ID;
				$this->imageurl = $value->imageurl;
				$this->thumburl = $value->thumburl;
				$this->imagetitle = $value->imagetitle;
				$this->imagedescription = $value->imagedescription;
				$this->imagelink = $value->imagelink;
			}
		}
	}
	
	function getPhotos($postID=0)
	{
		global $wpdb;
		$output = json_decode(query_Table(BMMI_PHOTO_TBL,"WHERE postID = $postID ORDER BY ID ASC"));
		$arrayphotos=array();
		if(count_POST(BMMI_PHOTO_TBL) > 0)
		{
			foreach ($output as $name => $value)
			{
				$arr_p = array("photoID"=>$value->ID,"imageurl"=>$value->imageurl,"thumburl"=>$value->thumburl,"imagetitle"=>$value->imagetitle,"imagedescription"=>$value->imagedescription,"imagelink"=>$value->imagelink);
				array_push($arrayphotos,$arr_p);
			}
		}
		return $arrayphotos;
	}
}
?>
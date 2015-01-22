<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * 
 * Todasquare Promotional Material Controller Class
 *
 *  Manage Promotional Material Details( for making the poupa with a common view so that can be controlled from one place only )
 *
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Gurutva Singh
 *  @link		http://toadsquare.com/
 *
 **/
 
class promo_material extends MX_Controller {
	
	private $userId = null;

	/**
	 * Constructor
	 **/
	 
	 function __construct() {
		//Load required Model, Library, language and Helper files	
		 $load = array(
			'model'		=> 'promo_material/model_promo_material'					
		 );
		parent::__construct($load); 	
				$this->head->add_css($this->config->item('frontend_css').'anythingslider.css');
	 }
		
	function popupimage($promoMaterialArr = array('entityId'=>'','mediaTableName'=>'','defaultImage'=>'','showImageOfNum'=>1,'whereClause'=>'','keyId'=>''))
	{
		
		$promoMaterialArr =$this->input->post('val1');
		//print_r($promoMaterialArr);
		//$whereClause = array($keyId=>$promoMaterialArr['projectId']);
		$imageSliderInfo = array();
		$defaultImage = $promoMaterialArr['defaultImage'];
		$imageSliderInfo = $this->model_promo_material->fetchImageDetail($promoMaterialArr['whereClause'],$promoMaterialArr['mediaTableName']);
		//echo $this->db->last_query();
		$detailSliderInfo = array();
		
		foreach($imageSliderInfo as $PIkey=>$PI){
					/*if(($PIkey > 0)&& ($PIkey%3==0)){
						echo "</li><li>";
					}
					elseif(($PIkey%3)==0){
						echo "<li>";
					}*/
					
					$OrgLPIImage=rtrim($PI['filePath'], '/').'/'.$PI['fileName'];					
					$LPIImage = addThumbFolder($OrgLPIImage,$suffix='_s',$thumbFolder ='thumb',$defaultImage);
					
					if(!empty($OrgLPIImage)){
						$LPIImageFlag=true;
						$PIMediumImage = addThumbFolder($OrgLPIImage,$suffix='_b',$thumbFolder ='thumb');
						//echo base_url($PIMediumImage);
					if(file_exists($PIMediumImage)){
						$PIImage = getImage($LPIImage,$defaultImage);
						$PIMediumImage = getImage($PIMediumImage,$defaultImage);
						$defaultClassShowImage ="max_w157_h108 bdr_bebebe ";
					}else{
						$PIImage = getImage('',$this->config->item('defaultNoMediaImg'));
						$PIMediumImage = getImage('',$this->config->item('defaultNoMediaImg'));
						$defaultClassShowImage ="max_w84_h84 p10 bdr_bebebe";
					}
					
					$mediaId = $PI['mediaId'];
					$mediaTitle = $PI['mediaTitle'];
					$mediaDescription = $PI['mediaDescription'];
					$mediaDescription = ($mediaDescription=='')?' ':nl2br($mediaDescription);

					$detailSliderInfo[] = array(
						'id'=>$mediaId,
						'image'=>$PIMediumImage,
						'title'=>htmlentities($mediaTitle),
						'description'=>htmlentities($mediaDescription)
					);
				}
			}
			
			$data['imageSliderInfo']=$detailSliderInfo;
			$data['showImageOfNum']=$promoMaterialArr['showImageOfNum'];
			$data['keyId']=$promoMaterialArr['keyId'];	
			$this->load->view('popup_images',$data);	
	}
	
}


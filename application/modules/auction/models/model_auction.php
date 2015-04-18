<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Todasquare auction Model Class
 *
 *
 *  @package	Toadsqure
 *  @subpackage	Module
 *  @category	Model
 *  @author		Tosif Qureshi
 *  @link		http://toadsquare.com/
 */
class model_auction extends CI_Model {
	
	private $tableAuction        = 'Auction';
	private $tableAuctionBids    = 'AuctionBids';
	private $tableAuctionWinners = 'AuctionWinners';
	
	/**
	 * Constructor
	 *
	 * Loads the calendar language file and sets the default time reference
	 */
	 
	public function __construct() {		
		parent::__construct();			// Call parent constructer
	}	
	
	/*
	 * Function used to store auctions data
	 */
	public function auctionInformationInsert($data,$auctionId=0) {
		if($auctionId>0) {
			$this->db->where('auctionId',$auctionId);
			$this->db->update($this->tableAuction,$data);
			$idAuction =  $auctionId;
		} else {
			$data['date'] = date("Y-m-d H:i:s");
			$elementId =$this->db->insert($this->tableAuction , $data);
			$idAuction =  $this->db->insert_id();
		}
		return $idAuction;
	}
	
	/*
	 * Function to save users bid
	 */
	public function addUserBid($data) {
		$this->db->insert($this->tableAuctionBids,$data); 	
		$bidId = $this->db->insert_id();
		return $bidId; 
	}
	
	/*
	 * Function to get users bid record
	 */
	public function getBidList($limit=0,$offset=0,$auctionId) {
		$this->db->select('*');
		if($offset!=0 || $limit!=0)
		{
			$this->db->limit($limit, $offset);
		}
		$this->db->order_by('price desc');
		$this->db->where('auctionId', $auctionId);
		$query = $this->db->get($this->tableAuctionBids);
		$result=$query->result_array();
		return $result;
	}	
	
	/*
	 * Function to save auctions winner bid
	 */
	public function saveAuctionWinners($data) {
		$this->db->insert($this->tableAuctionWinners,$data); 	
		$winnerId = $this->db->insert_id();
		return $winnerId; 
	}
	
	/*
	 * Function to update auction winners status
	 */
	public function updateWinnerStatus($data=0,$winnerId=0) {
		$this->db->where('winnerId',$winnerId);
		$this->db->update($this->tableAuctionWinners,$data);
		$recordSet = getFieldValueFrmTable('*',$this->tableAuctionWinners,'winnerId',$winnerId);
		$idWinner =  $recordSet[0]->winnerId;
		return $idWinner;
	}
	
	/*
	 * Function to update auction bid record
	 */
	public function updateAuctionBid($data,$bidId=0) {
		$this->db->where('bidId',$bidId);
		$this->db->update($this->tableAuctionBids,$data);
	}
	
	/*
	 *  This function is used to get auctions bid record
	 */
	public function getAuctionsBidRecord($bidId) {
		$this->db->select($this->tableAuctionBids.'.*');
		$this->db->select('au.entityId,au.elementId,au.projectId,au.minBidPrice,au.tdsUid');	
		//$this->db->select('ou.contact_name,ou.contact_name,ou.username');
		$this->db->from($this->tableAuctionBids);	
		$this->db->join($this->tableAuction.' as au', 'au.auctionId = '.$this->tableAuctionBids.'.auctionId','left');
		//$this->db->join($this->tableOxUsers.' as ou', 'ou.user_id = '.$this->tableOxManageUsers.'.oxUserId','left');
		$this->db->where($this->tableAuctionBids.'.bidId',$bidId);
		$query = $this->db->get();		
		return $query->row_array();	
	}
	
	/*
	 *  This function is used to get max auction bid
	 */
	public function getMaxBid($auctionId) {
		$this->db->select($this->tableAuctionBids.'.*');
		$this->db->select('au.entityId,au.elementId,au.projectId,au.minBidPrice,au.tdsUid');	
		$this->db->from($this->tableAuctionBids);	
		$this->db->join($this->tableAuction.' as au', 'au.auctionId = '.$this->tableAuctionBids.'.auctionId','left');
		$this->db->where($this->tableAuctionBids.'.auctionId',$auctionId);
		$this->db->where($this->tableAuctionBids.'.isWinnerExpire','f');
		$this->db->order_by('price','desc');
		$this->db->limit(1);
		$query = $this->db->get();		
		return $query->row_array();	
	}
	
	/*
	 *  This function is used to get auction winner records
	 */
	public function getWinnerData($bidId=0,$userId=0) {
		$this->db->select('expDate,invitationStatus');
		$this->db->from($this->tableAuctionWinners);	
		$this->db->where('bidId',$bidId);
		$this->db->where('userId',$userId);
		$this->db->limit(1);
		$query = $this->db->get();		
		return $query->row_array();	
	}
	
	/*
	 *  This function is used to get auction record after end date
	 */
	public function getFinalAuctionData() {
		$currentDate = date('Y-m-d H:i:s');
		$this->db->select('*');
		$this->db->from($this->tableAuction);
		$this->db->where('endDate <', $currentDate);
		$query = $this->db->get();		
		return $query->result_array();	
	}
}

/* End of file model_auction.php */
/* Location: ./application/module/auction/model/model_auction.php */

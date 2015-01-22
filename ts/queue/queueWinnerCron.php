<?php 


/**
 * @Author : Tosif Qureshi
 * @Email  : tosifqureshi@cdnsol.com
 * @Timestamp : Nov-12 06:51PM 
 * @Copyright : www.cdnsol.com 
**/

date_default_timezone_set('Europe/Luxembourg');
// -- Check if file YAML file exists --
define("BASEPATH",dirname(__FILE__));
// -- File Extension --
define("EXT",".php");
ini_set('display_errors','1');
// -- Check if file Common file exists --
if(file_exists(dirname(__FILE__).'/inc/common'.EXT))
{
	include(dirname(__FILE__).'/inc/common'.EXT);
	log_message("ALL","All files include successfully");
}

if(isset($_POST["key"]) && $_POST["key"]==config::getInst()->getKeyValue("encryption_key"))
{
	log_message("ALL","winnerMailSent will run for --> EXTERNAL (".$_SERVER["REQUESTED_URI"].")");
	
} else {
	
	/// -- Log Message to Log file for Type of call --
	log_message("ALL","winnerMailSent will run for --> INTERNAL ()");
	//$db_job = winnerMailSent();
	$db_job = sendAuctionInvitation(); //commmented by lokendra for tempary  
	
    //insertAuctionPurchase(40,525);
    
	exit();
	
}// -- FII :: $_POST["key"] --
	
/*
 * This function is used to send competition winning mail  
 */
function winnerMailSent() {
	$db = db_connect();
	
	$currentDate = date('Y-m-d');
	if($db){
		
		//Get details of ended competition for round 1
		$competitionRound1Data = pg_query($db, 'SELECT * from "TDS_Competition" where "votingEndDate" < \''.$currentDate.'\'');
		while ($round1Row = pg_fetch_assoc($competitionRound1Data)) {
			//Get competitions prize count
			$compPrizeRes = pg_query($db, 'SELECT * from "TDS_CompetitionPrizes" where "competitionId" = \''.$round1Row['competitionId'].'\'');
			$priceCount   = pg_numrows($compPrizeRes);
			
			//Get record of competition entries for round 1 
			$entryRoundRes1 = pg_query($db, 'SELECT ce.*,ua."email" from "TDS_CompetitionEntry" as ce, "TDS_UserAuth" as ua  where "competitionId" < \''.$round1Row['competitionId'].'\' AND "isPublished" = \'t\' AND "isExpired" = \'f\' AND "isWinnerMailSent" = \'f\' AND "entryRoundType" = 1 AND ua."tdsUid"=ce."userId" AND "voteCount" > 0  ORDER BY "voteCount" DESC LIMIT '.$priceCount.'');
			manageCompetitionEntryData($entryRoundRes1,1);
		}
		
		//Get details of ended competition for round 2
		$competitionRound2Data = pg_query($db, 'SELECT * from "TDS_Competition" where "votingEndDateRound2" < \''.$currentDate.'\'');
		while ($round2Row = pg_fetch_assoc($competitionRound2Data)) {
			//Get competitions prize count
			$compPrizeRes = pg_query($db, 'SELECT * from "TDS_CompetitionPrizes" where "competitionId" = \''.$round2Row['competitionId'].'\'');
			$priceCount   = pg_numrows($compPrizeRes);
			
			//Get record of competition entries for round 2
			$entryRoundRes2 = pg_query($db, 'SELECT ce.*,ua."email" from "TDS_CompetitionEntry" as ce, "TDS_UserAuth" as ua  where "competitionId" < \''.$round2Row['competitionId'].'\' AND "isPublished" = \'t\' AND "isExpired" = \'f\' AND "isWinnerMailSent" = \'f\' AND "entryRoundType" = 2 AND ua."tdsUid"=ce."userId" AND "voteCount" > 0  ORDER BY "voteCount" DESC LIMIT '.$priceCount.'');
			manageCompetitionEntryData($entryRoundRes2,1);
		}
	}
	
	//Call function to manage auctions winner entry
	/*if(function_exists('sendAuctionInvitation')){
		sendAuctionInvitation();
	}*/
}

/*
 * This function is used to manage winning mail
 */
function manageCompetitionEntryData($entryRes,$i) {
	$db = db_connect();
	
	while ($entryRow = pg_fetch_assoc($entryRes)) {	
		if(isset($entryRow['voteCount']) && $entryRow['voteCount']>0) {  
			
			//Get competition email template record
			$resTemplate = pg_query($db, 'SELECT * from "TDS_EmailTemplates" WHERE "purpose" = \'competitionwinningmail\' AND "active" =1 LIMIT 1');
			$template = pg_fetch_assoc($resTemplate);
			
			$compResTemplate = pg_query($db, 'SELECT * from "TDS_Competition" WHERE "competitionId" = \''.$entryRow['competitionId'].'\'');
			$compData = pg_fetch_assoc($compResTemplate);
			
			//Set template parametres
			/* while we don't remove restriction (username, password) in .htacess file  from live site*/
			$imageBaseUrl = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/images/email_images/';
			$craveUs      = 'http://www.toadsquare.com/en/showcase/index/4';
			$facebookUrl  = 'http://www.facebook.com/pages/Toadsquare/121921117888970';
			$linkedinUrl  = 'http://www.linkedin.com/company/toadsquare?trk=hb_tab_compy_id_3001132';
			$twitterUrl   = 'https://twitter.com/Toadsquare';
			$googleUrl    = 'https://plus.google.com/113568803978838695517/posts';
			
			if(is_array($template) && count($template) > 0) {
				$competitionTemplate = $template['templates'];
				$subject = $template['subject'];
				
				$searchArray = array("{competition_title}","{prize_number}","{image_base_url}","{crave_us}","{subject}","{facebook_url}","{linkedin_url}","{twitter_url}","{gPlus_url}");
				$replaceArray = array($entryRow['title'],$i,$imageBaseUrl,$craveUs,$subject,$facebookUrl,$linkedinUrl,$twitterUrl,$googleUrl);
				$message = str_replace($searchArray, $replaceArray, $competitionTemplate);			
			} else {
				$message = '';
				$subject = '';
			}
			if((!empty($message)) && (!empty($subject))) {
				//Send Email to winner
				$isSend = sendEmailTemplate($entryRow['email'],'',$message,$subject);	
				
				//If email sent successfully then update mail status 
				if(isset($isSend) && !empty($isSend)) {
					echo $entryRow['competitionEntryId'].',';
					$updateMailRes = pg_query($db, 'UPDATE "TDS_CompetitionEntry" SET "isWinnerMailSent" = \'t\' WHERE "competitionEntryId" = '.$entryRow['competitionEntryId']);
				}
			}
			$i++;
		}
	}
 }
 
/*
* This function is used to send invitation to auction winner
*/	
function sendAuctionInvitation() {
	$db = db_connect();
	
	$currentDate = date('Y-m-d');
	if($db){
		//Get details of ended auction data
		$auctionData = pg_query($db, 'SELECT * from "TDS_Auction" where "endDate" < \''.$currentDate.'\' and "isAuctionClosed" = \'f\' and "isAuctionPurchased" = \'f\' ');
		
		while ($row = pg_fetch_assoc($auctionData)) {
			
			$resTemplate = pg_query($db, 'SELECT * from "TDS_AuctionBids" WHERE "auctionId" = \''.$row['auctionId'].'\' AND "isWinnerExpire" = \'f\'');
			$countBidResult = pg_numrows($resTemplate); //Get count of not expire users bid
			if($countBidResult<=5) {
				$isTable = true;
				//Set project where clause and fields name
				switch($row['entityId']) {
					case 49:
					$projectSql = 'SELECT "productTitle" from "TDS_Product" WHERE "productId" = \''.$row['projectId'].'\'';
					$field = 'productTitle';
					break;
					default:
					$isTable = false;
				}
				if($isTable == true) {
					//Get project record
					$projectRes   = pg_query($db, $projectSql);
					$projectData  = pg_fetch_assoc($projectRes);
					$projectTitle = $projectData[$field];
				} else {
					$projectTitle = '';
				}
				
				//Get max bid of auction
				$getMaxBidRecord = pg_query($db, 'SELECT ab.*,au."entityId",au."elementId",au."projectId",au."minBidPrice",au."tdsUid",ua."email" from "TDS_AuctionBids" as ab, "TDS_Auction" as au, "TDS_UserAuth" as ua where ab."auctionId" = \''.$row['auctionId'].'\' AND ab."userId"=ua."tdsUid" AND "isWinnerExpire" = \'f\' AND au."auctionId" = ab."auctionId" ORDER BY "price" DESC LIMIT 1');
				$maxRow = pg_fetch_assoc($getMaxBidRecord);
				
				if(isset($maxRow['bidId']) && !empty($maxRow['bidId']) && isset($maxRow['userId']) && !empty($maxRow['userId'])) {
					//get auction winners record if exist
					$existWinnersSql = pg_query($db, 'SELECT "expDate","invitationStatus" from "TDS_AuctionWinners"  where "bidId" = \''.$maxRow['bidId'].'\' AND "userId" = \''.$maxRow['userId'].'\' LIMIT 1');
					$existWinnerRes = pg_fetch_assoc($existWinnersSql);
					if(is_array($existWinnerRes) && !empty($existWinnerRes)) {
						//set current date
						$currentDate = date('Y-m-d H:i:s');
                        //1:sendInvitation, 2:Purchase, 3:Reject
						if($currentDate>$existWinnerRes['expDate'] && $existWinnerRes['invitationStatus']==1) {
							
							//update auction expire status
							$data['modifiedDate']   = $currentDate;
							$data['isWinnerExpire'] = 't';
							$updatewinnerRes = pg_query($db, 'UPDATE "TDS_AuctionBids" SET "modifiedDate" = \''.$currentDate.'\',"isWinnerExpire" = \'t\' WHERE "bidId" = '.$maxRow['bidId']);
							
							//Get max bid of auction
							$getMaxBidRecord = pg_query($db, 'SELECT ab.*,au."entityId",au."elementId",au."projectId",au."minBidPrice",au."tdsUid",ua."email" from "TDS_AuctionBids" as ab, "TDS_Auction" as au, "TDS_UserAuth" as ua  where ab."auctionId" = \''.$row['auctionId'].'\' AND ab."userId"=ua."tdsUid" AND "isWinnerExpire" = \'f\' AND au."auctionId" = ab."auctionId" ORDER BY "price" DESC LIMIT 1');
							$maxRow = pg_fetch_assoc($getMaxBidRecord);
						}
					}
					
					//insert record and send mail to winner
					setAuctionWinners($maxRow['bidId'],$maxRow['userId'],$maxRow['email'],$projectTitle);
                    
                    //insert user wishlist
                    insertAuctionPurchase($maxRow['bidId'],$maxRow['userId']);
				}	
			} else {
				//update auction status as close
				$updateAuctionRes = pg_query($db, 'UPDATE "TDS_Auction" SET "isAuctionClosed" = \'t\' WHERE "auctionId" = '.$row['auctionId']);
			}
		}
	}
}
 
/*
 * This function is used to set auctions winner
 */
function setAuctionWinners($bidId=0,$userId=0,$email='',$projectTitle='') { 
	$db = db_connect();
	
	if(isset($bidId) && !empty($bidId) && isset($userId) && !empty($userId) && !empty($email)) {
		//Get existing auction winner record
		$winnerSql = pg_query($db, 'SELECT "winnerId" from "TDS_AuctionWinners" where "bidId" = \''.$bidId.'\' AND "userId" = \''.$userId.'\'');
		$winnerRes = pg_fetch_assoc($winnerSql);
		$flag = 0; //set default flag value
		if(empty($winnerRes)) {
			$key      = md5(rand().microtime());
			$sendDate = date('Y-m-d H:i:s');
			$expDate  = date('Y-m-d H:i:s', strtotime($sendDate. ' + 7 days'));
		
			//Set template parametres
			/* while we don't remove restriction (username, password) in .htacess file  from live site*/
			$imageBaseUrl = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/images/email_images/';
			$craveUs      = 'http://www.toadsquare.com/en/showcase/index/4';
			$facebookUrl  = 'http://www.facebook.com/pages/Toadsquare/121921117888970';
			$linkedinUrl  = 'http://www.linkedin.com/company/toadsquare?trk=hb_tab_compy_id_3001132';
			$twitterUrl   = 'https://twitter.com/Toadsquare';
			$googleUrl    = 'https://plus.google.com/113568803978838695517/posts';
			
			//Set server base path
			$SERVERNAME = exec("hostname -f");
			$SERVERADDR = exec("hostname -i");
			if($SERVERADDR=='94.242.251.14'){ 
				// Staging K119.server.lu, 94.242.251.14
				$site_url = $site_base_url = 'http://staging.toadsquare.com/';
			}
			elseif($SERVERADDR == '94.242.254.30'){
				//Live L221.server.lu 94.242.254.30
				$site_url = $site_base_url = 'http://www.toadsquare.com/';
			}
			else{
				//Developement
				$site_url = $site_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/';
				//$site_url = $site_base_url = 'http://cdnsolutionsgroup.com/toadsquare_p2/';	
			}
			
			//$invitationAcceptUrl = $site_url.'auction/acceptInvitation/'.$userId.'/'.$key; //set winners activation url
			
            $invitationAcceptUrl   = $site_url.'cart/mypurchases';
            
			//Get auctions email template record
			$resTemplate = pg_query($db, 'SELECT * from "TDS_EmailTemplates" WHERE "purpose" = \'auctionwinmail\' AND "active" =1 LIMIT 1');
			$template = pg_fetch_assoc($resTemplate);
			if(is_array($template) && count($template) > 0) {
				$auctionTemplate = $template['templates'];
				$subject = $template['subject'];
				
				$searchArray = array("{project_title}","{end_date}","{invitation_accept_url}","{image_base_url}","{crave_us}","{facebook_url}","{linkedin_url}","{twitter_url}","{gPlus_url}");
				$replaceArray = array($projectTitle,$expDate,$invitationAcceptUrl,$imageBaseUrl,$craveUs,$facebookUrl,$linkedinUrl,$twitterUrl,$googleUrl);
				$message = str_replace($searchArray, $replaceArray, $auctionTemplate);			
			} else {
				$message='';
				$subject='';
			}
			
			if((!empty($message)) && (!empty($subject))){
				//Send Email to winner
				
				$isSend = sendEmailTemplate($email,'',$message,$subject);	
				//echo $isSend.'|';
				//If email sent successfully then insert winner record 
				if(isset($isSend) && !empty($isSend)) {
					//Insert winners record
					$SQL = 'INSERT INTO "TDS_AuctionWinners" ("bidId","userId","key","sendDate","expDate") VALUES ('.$bidId.','.$userId.',\''.$key.'\',\''.$sendDate.'\',\''.$expDate.'\')';
					$query = pg_query($db, $SQL);
					if($query) {
						$insert_query = 'SELECT lastval();';
						$insert_row = pg_fetch_row(pg_query($insert_query));
						//echo $bidWinnerId = $insert_row[0];
					}
				}
			}
		}
	}
}


/*
 * @description: This method is use insert record in winner whillist
 * @auther: lokendra meena
 * @return: void
 */ 


function insertAuctionPurchase($bidId=0,$userId=0){
    
    $db = db_connect();
    
    if(isset($bidId) && !empty($bidId) && isset($userId) && !empty($userId)) {
       
        //Get existing auction winner record
        $queryFire = pg_query($db, 'SELECT 
            "TDS_AuctionWinners"."winnerId","TDS_Auction"."entityId","TDS_Auction"."elementId","TDS_AuctionBids"."price","TDS_Auction"."projectId","TDS_Auction"."tdsUid"
            from "TDS_AuctionWinners"
            LEFT JOIN "TDS_AuctionBids" ON  "TDS_AuctionBids"."bidId" = "TDS_AuctionWinners"."bidId"
            LEFT JOIN "TDS_Auction" ON  "TDS_Auction"."auctionId" = "TDS_AuctionBids"."auctionId"
            where "TDS_AuctionWinners"."bidId" = '.$bidId.' AND "TDS_AuctionWinners"."userId" = '.$userId);
        $projectDetails = pg_fetch_assoc($queryFire);
        
        // if array is not empty
        if(!empty($projectDetails)){
            $entityId  = $projectDetails['entityId'];
            $elementId = $projectDetails['elementId'];
            $projectId = $projectDetails['projectId'];
            $ownerId   = $projectDetails['tdsUid'];
            $price     = $projectDetails['price'];
            $winnerId  = $projectDetails['winnerId'];
            $sectionId = "";
            $projTitle = "None";
            //-------get section id-----------//
            //for media section
            if($entityId=="54"){
                
                //get project table record
                $projectQueryFire = pg_query($db, 'SELECT "projectType", "projName"  from "TDS_Project"
                where   "projId" = '.$projectId);
                $projectDetails = pg_fetch_assoc($projectQueryFire);
                
                if(!empty($projectDetails)){
                    $projectType = (!empty($projectDetails['projectType']))?$projectDetails['projectType']:"";
                    $projTitle  = (!empty($projectDetails['projName']))?$projectDetails['projName']:"None";
                    switch($projectType){
                        
                        case "filmNvideo":
                            $sectionId =   '1';
                        break;
                        
                        case "musicNaudio":
                            $sectionId =   '2';
                        break;
                        
                        case "photographyNart":
                            $sectionId =   '4';
                        break;
                        
                        case "writingNpublishing":
                            $sectionId =   '3';
                        break;
                        
                        case "educationMaterial":
                            $sectionId =   '10';
                        break;
                        
                        default:
                         $sectionId =   '';
                    }
                }
            }elseif($entityId=="49"){
                //condition for product
                
                //get project table record
                $productQueryFire = pg_query($db, 'SELECT "catId","productTitle"  from "TDS_Product"
                where   "productId" = '.$projectId);
                $productDetails = pg_fetch_assoc($productQueryFire);
                
                //if record exit
                if(empty($productDetails)){
                    $catId      = (!empty($productDetails['catId']))?$productDetails['catId']:"";
                    $projTitle  = (!empty($productDetails['productTitle']))?$productDetails['productTitle']:"";
                    
                     $sectionId =   '12';
                    if(!empty($catId)){
                        $sectionId  = $sectionId.":".$catId;
                    }
                }
            }
            
            
            //-----get seller info details-----//
            $sellerInfoQueryFire = pg_query($db, 'SELECT "TDS_UserSellerSettings"."seller_address1",
            "TDS_UserSellerSettings"."seller_city", "TDS_UserSellerSettings"."seller_state", "TDS_UserSellerSettings"."seller_zip", 
            "TDS_UserSellerSettings"."seller_phone", "TDS_UserSellerSettings"."territoryCountryId", "TDS_UserSellerSettings"."territory", 
            "TDS_UserSellerSettings"."identificationNumber", "TDS_UserProfile"."firstName", "TDS_UserProfile"."lastName",
            "TDS_UserAuth"."email" FROM "TDS_UserSellerSettings" 
            LEFT JOIN "TDS_UserProfile" ON "TDS_UserProfile"."tdsUid" = "TDS_UserSellerSettings"."tdsUid" 
            LEFT JOIN "TDS_UserAuth" ON "TDS_UserProfile"."tdsUid" = "TDS_UserAuth"."tdsUid" 
            WHERE "TDS_UserSellerSettings"."tdsUid" = '.$ownerId);
            $sellerInfoDetails = pg_fetch_assoc($sellerInfoQueryFire);
            
            $sellerJson ='';
            if($sellerInfoDetails){
                $UserShippingJson = array(	 
                    'firstName'          =>  $sellerInfoDetails['firstName'],
                    'lastName'           =>  $sellerInfoDetails['lastName'],
                    'email'              =>  $sellerInfoDetails['email'],
                    'seller_address1'    =>  $sellerInfoDetails['seller_address1'],
                    'seller_city'        =>  $sellerInfoDetails['seller_city'],
                    'seller_state'       =>  $sellerInfoDetails['seller_state'],
                    'seller_zip'         =>  $sellerInfoDetails['seller_zip'],
                    'seller_phone'       =>  $sellerInfoDetails['seller_phone'],
                    'territoryCountryId' =>  $sellerInfoDetails['territoryCountryId'],
                    'sellerEuIdnumber'   =>  $sellerInfoDetails['identificationNumber']					
                );
                $sellerJson = json_encode($UserShippingJson);   
            }
            
            
            //-----get seller currency details-----//
            $sellerQueryFire = pg_query($db, 'SELECT "TDS_UserSellerSettings"."seller_currency"   from "TDS_UserSellerSettings"
                where   "TDS_UserSellerSettings"."tdsUid" = '.$ownerId);
            $sellerDetails = pg_fetch_assoc($sellerQueryFire);
            $currency= (!empty($sellerDetails['seller_currency']))?$sellerDetails['seller_currency']:0;
            
             //-----get wislist details-----//
            $wislistQueryFire = pg_query($db, 'SELECT "TDS_Wishlist"."itemId"   from "TDS_Wishlist"
                where  "entityId" = '.$entityId.' AND "elementId" = '.$elementId.' AND "tdsUid" = '.$userId);
            $wislistDetails = pg_fetch_assoc($wislistQueryFire);
            
            $purchaseType = '1'; // set for physical material
            
            //add winner user record to wishlist
            if(empty($wislistDetails)){
                // insert wishlist data
                $SQL = 'INSERT INTO "TDS_Wishlist" ("entityId","elementId","tdsUid","currency","purchaseType","sectionId","projId","ownerId","isAuction","auctionPrice") 
                VALUES ('.$entityId.','.$elementId.','.$userId.','.$currency.','.$purchaseType.','.$sectionId.','.$projectId.','.$ownerId.',\'t\','.$price.')';
                $query = pg_query($db, $SQL);
            
            
            
                //-----get customer details-----//
                $customerQueryFire  = pg_query($db, 'SELECT "firstName", "lastName" from "TDS_UserProfile"  where  "tdsUid" = '.$userId);
                $customerDetails    = pg_fetch_assoc($customerQueryFire);
                $custName   =   $customerDetails['firstName'].' '.$customerDetails['lastName']; 
                
                //add record in sales order table
                $InsertSQL = 'INSERT INTO "TDS_SalesOrder" ("ordStatus","itemCount","customerUid","custName","ordCurrency") 
                VALUES (1,1,'.$userId.',\''.$custName.'\',\''.$currency.'\')';
                $query = pg_query($db, $InsertSQL);
                
                $insert_query = 'SELECT lastval();';
                $insert_row = pg_fetch_row(pg_query($insert_query));
                $ordId = $insert_row[0];
                
                //add record in sales item table
                $InsertSQL = 'INSERT INTO "TDS_SalesOrderItem" ("ordId","entityId","elementId","sectionId","itemQty","itemName","itemValue","sellerId","sellerInfo","purchaseType","projId","isProductAuction") 
                VALUES ('.$ordId.','.$entityId.','.$elementId.','.$sectionId.',1,\''.$projTitle.'\','.$price.','.$ownerId.',\''.$sellerJson.'\',6,'.$projectId.',\'t\')';
                $query = pg_query($db, $InsertSQL);
                
                //send auction buy request
                $updateMailRes = pg_query($db, 'UPDATE "TDS_AuctionWinners" SET "invitationStatus" = \'1\' WHERE "winnerId" = '.$winnerId);
            }
        }
        
    }
}

/*
 * This function is used to send emails
 */
function sendEmailTemplate($email,$personName,$body,$subject) {
	
	include_once(dirname(dirname(__FILE__)).'/configurationCheck/mail/phpmailer/class.phpmailer'.EXT);
	
	$SERVERNAME=exec("hostname -f");
	$SERVERADDR=exec("hostname -i");
	
	if($SERVERADDR=='94.242.251.14'){ 
		
		$Host="mail.toadsquare.com";
		$Username="noreply@toadsquare.com";
		$Password="und3rc0v3r";
	}
	elseif($SERVERADDR == '94.242.254.30'){
		$Host="mail.toadsquare.com";
		$Username="noreply@toadsquare.com";
		$Password="und3rc0v3r";
	}
	else{
        /*
		$Host="mail.cdnsol.com";
		$Username="admin@cdnsol.com";
		$Password='[NXCzT[3q?8*kd3S4=d$Q6dh';*/
        
        $Host="184.107.217.244";
		$Username="admin@cdnsolutionsgroup.com";
		$Password='llB8eTk=oKtG';
        
	}
	
	
	$mail = new PHPMailer();
	$mail->IsSMTP(); 
	$mail->IsHTML(true);         // send via SMTP
	$mail->Host     = $Host;
	$mail->SMTPAuth = true;     // turn on SMTP authentication
	$mail->Username = $Username;  // SMTP username
	$mail->Password = $Password; // SMTP password

	$mail->From     = "noreply@toadsquare.com";
	$mail->FromName = "Toadsquare";
	$mail->AddReplyTo($mail->From, $mail->FromName);
	$mail->AddAddress($email,$personName);
	$mail->WordWrap = 50;                              // set word wrap
	$mail->Subject  =  $subject;
	$mail->Body     =  $body;
	$mail->AltBody  =  "mesage body not found";
	return $mail->Send();
}
?>

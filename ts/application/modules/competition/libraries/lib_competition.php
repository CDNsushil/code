<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Todasqre Lib_upcomingproject Class
 *
 * manage Lib_upcomingproject details.
 *
 * @package		Toadsqure
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Mayank Kanungo
 * @link		http://www.cdnsol.com/
 */

Class lib_competition{
	/***
	create properties
	***/
	
	var $keys = array
	(	
		'competitionId'=>0,
		'userId'=>0,
		'title'=>'',
		'tagwords'=>'',
		'onelineDescription'=>'',
		'description'=>'',
		'spacifications'=>'',
		'dueDate'=>'',
		'submissionStartDate'=>'',
		'submissionEndDate'=>'',
		'votingStartDate'=>'',
		'votingEndDate'=>'',
		'coverImage'=>'',
		'industryId'=>'',
		'languageId'=>0,
		'criteriaLang1Id'=>0,
		'criteriaLang2Id'=>'',
		'countryId'=>'',
		'votesCountries'=>'',
		'prizeQuantity'=>'',
		'mediaType'=>2,
		'ageRequiresFrom'=>0,
		'ageRequiresTo'=>0,
		'rules'=>'',
		'teritoryType'=>0,
		'createdDate'=>'',
		'modifyDate'=>'',
		'isPublished'=>'',
		'isExpired'=>'',
		'isBlocked'=>'',
		'isArchive'=>'',
		'userContainerId'=>0,
		'competitionGroupId'=>0,
		'competitionCountries'=>'',
		'sampleFileId'=>'',
		'isExternal'=>'f',
		'filePath'=>'',
		'submissionStartDateRound2'=>'',
		'submissionEndDateRound2'=>'',
		'votingStartDateRound2'=>'',
		'votingEndDateRound2'=>'',
		'Round2MaxEntries'=>'',
		'competitionRoundType'=>'1',
		'isMultilingual'=>'f',
		'ageRestriction'=>'f'
	 );

	 /**
	 * Constructor
	 */
	function __construct(){
		$this->CI =& get_instance();
	}
	
	function getValues(){
		$object = new stdClass();
		foreach ($this->keys as $key => $value)
		{
			$object->$key = $value;
		}
		return $object;
	}
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
define("IMG","");
class contact extends MX_Controller {

	function __construct()
	{ 
	   //My own constructor code
	   $load = array(
			'library' 	=> 'form_validation + upload + session + OpenInviter/openinviter',
			'language' 	=> 'Contact',
			'helper' 	=> 'form + file + archive'
		);		
		
		parent::__construct($load); 
	}

	public function index()
	{
			$this->ImportContact();
	}
	
	public function ImportContact()
	{
		$inviter = $this->openinviter;
		$inviter->getPlugins();
		
		if($this->input->post())
		{
			$ers=array(); $oks=array(); $import_ok=false; $done=false; $data=array();
			//required validations
			$step = $this->input->post('step');
			if($step == 'get_contacts')
			{
				$this->form_validation->set_rules('email_box', "Email(Gmail)", 'trim|valid_email|required');
				$this->form_validation->set_rules('password_box', "Password(Gmail)", 'trim|required');
				
				if ($this->form_validation->run() == FALSE)
				{
					$this->template->load('template','createprofile5');
				}
				else
				{
					if($step=='get_contacts')
					{
						$provider_box = ''; $email=''; $password='';
						// Gather posted data: email, password and service provider
						if($this->input->post('email_box')!="" && $this->input->post('password_box')!="")
						{
							$email = $this->input->post('email_box');
							$password = $this->input->post('password_box');
							$provider_box = "gmail";
						}
						else if($this->input->post('email_box1')!="" && $this->input->post('password_box1')!="")
						{
							$email = $this->input->post('email_box1');
							$password = $this->input->post('password_box1');
							$provider_box = "yahoo";
						}
						else if($this->input->post('email_box2')!="" && $this->input->post('password_box2')!="")
						{
							$email = $this->input->post('email_box2');
							$password = $this->input->post('password_box2');
							$provider_box = "hotmail";
						}

						if($email!="" && $password!="" && $provider_box!="")
						{
							$inviter->startPlugin($provider_box);
							$internal=$inviter->getInternalError();
							if ($internal)
								$ers['inviter']=$internal;
							elseif (!$inviter->login($email,$password))
							{
								$internal=$inviter->getInternalError();
								$ers['login']=($internal?$internal:"Login failed. Please check the email and password you have provided and try again later !");
							}
							elseif (false===$contacts=$inviter->getMyContacts())
								$ers['contacts']="Unable to get contacts !";
							else
							{
								$data['contacts'] = $contacts;
								$import_ok=true;
								$step='send_invites';
								$data['oi_session_id'] = $inviter->plugin->getSessionID();
								$data['provider_box'] = $provider_box;

								//$_POST['oi_session_id'] = $inviter->plugin->getSessionID();
								//$_POST['message_box']='';
								
								// load contacts here
								if ($inviter->showContacts())
								{
									$this->template->load('template','createprofile6',$data);			
								}
							}
							$this->template->load('template','createprofile5',$ers);
						}
					}
				}
			}
			elseif ($step == 'send_invites')
			{
				// gather posted data 
				$provider_box = $this->input->post('provider_box');
				$email_box = $this->input->post('email_box');
				$oi_session_id = $this->input->post('oi_session_id');
				
				// keep data to return array
				$data['provider_box'] = $provider_box;
				$data['email_box'] = $provider_box;
				$data['oi_session_id'] = $provider_box;

				
				if (empty($provider_box))
				{
					$data['error_provider']='Provider missing !';
					$ers['error_provider']='Provider missing !';
				}
				else
				{
					$inviter->startPlugin($provider_box);
					$contacts=$inviter->getMyContacts();
					$data['contacts'] = $contacts;
					
					$internal=$inviter->getInternalError();
					if($internal)
					{
						$data['error_internal'] = $internal;
						$ers['error_internal'] = $internal;
					}		
					else
					{
						if(empty($email_box))
						{
							$data['error_inviter'] = 'Inviter information missing !';
							$ers['error_inviter'] = 'Inviter information missing !';
						}
						
						if(empty($oi_session_id))
						{
							$data['error_session_id'] = 'No active session !';
							$ers['error_session_id'] = 'No active session !';
						}
						
						$selected_contacts=array();$contacts=array();
						
						// Get email subject and body message here
						
						$email_subject = $email_box." is inviting you to Chatching";
						$email_message = "Click on below link to join chatching"."<br /><br />";
						$email_message.= "<a href='".BASEURL."' target='_blank'>Join Chatching</a>";
						
						$message=array('subject'=>$email_subject,'body'=>$email_message);

						if($inviter->showContacts())
						{
							foreach ($this->input->post() as $key=>$val)
								if (strpos($key,'check_')!==false)
									$selected_contacts[$this->input->post('email_'.$val)]=$this->input->post('name_'.$val);
								elseif (strpos($key,'email_')!==false)
								{
									$temp=explode('_',$key);$counter=$temp[1];
									if (is_numeric($temp[1])) $contacts[$val]=$this->input->post('name_'.$temp[1]);
								}
							if (count($selected_contacts)==0)
							{
								$data['error_contacts']="You haven't selected any contacts to invite !";
								$ers['error_contacts']="You haven't selected any contacts to invite !";
							}	
						}
					}
				}
				
				if (isset($ers) && count($ers)==0)
				{
					$sendMessage=$inviter->sendMessage($_POST['oi_session_id'],$message,$selected_contacts);
					$inviter->logout();
					if($sendMessage===-1)
					{
						$message_footer="\r\n\r\nThis invite was sent using OpenInviter technology.";
						$message_subject=$message['subject'];
						$message_body=$message['body'].$message_footer; 
						$headers="From: $email_box";
						foreach ($selected_contacts as $email=>$name)
							mail($email,$message_subject,$message_body,$headers);
						$data['mails']="Invitation emails have been sent successfully";
					}
					elseif ($sendMessage===false)
					{
						$internal=$inviter->getInternalError();
						$data['internal']=($internal?$internal:"There were errors while sending your invites.<br>Please try again later!");
						$ers['internal']=($internal?$internal:"There were errors while sending your invites.<br>Please try again later!");
					}
					else $data['success']="Invites sent successfully!";

					if(isset($ers) && count($ers)==0)
					{
						$this->template->load('template','createprofile7',$data);
					}	
					else
					{
						// load success view
						$this->template->load('template','createprofile6',$data);
					}
				}
				else
				{
					// load error view  
					$this->template->load('template','createprofile6',$data);
				}
			}
		}
		else
		{
			$this->template->load('template','createprofile5');
		}
	}	
} //end of create_profile controller class

/* End of file create_profile.php */
/* Location: ./application/controllers/create_profile.php */
<?php
$lang['auth_label_username'] = 'Username';
$lang['auth_label_email'] = 'Email Address';
$lang['auth_label_password'] = 'Password';
$lang['auth_label_new_password'] = 'New Password ';
$lang['auth_label_confirmPassword'] = 'Confirm Password';
$lang['auth_label_firstName'] = 'First Name';
$lang['auth_label_lastName'] = 'Last Name';
$lang['auth_label_country'] = 'Country';
$lang['auth_label_city'] = 'City';
$lang['auth_label_town_city'] = 'Town or City';
$lang['auth_label_phone'] = 'Phone number';
$lang['auth_label_profession'] = 'Profession';
$lang['auth_label_company'] = 'Company';
$lang['auth_label_address'] = 'Address';
$lang['auth_label_display_language'] = 'Site Display Language';
$lang['auth_label_first_language'] = 'First Language';
$lang['auth_label_second_language'] = 'Second Language';
$lang['auth_label_first_country'] = 'First Country';
$lang['auth_label_second_country'] = 'Second Country';
$lang['auth_label_second_email'] = 'Secondary Email Address';
// Errors
$lang['login'] = 'Login';
$lang['email'] = 'Email Address';
$lang['rememberme'] = 'Remember me';
$lang['notregistered'] = 'Not registered?';
$lang['alreadyMember'] = 'Already a member?';
$lang['ItIsFree'] = 'It’s free!';
$lang['join'] = 'Join';
$lang['forgotten_password'] = 'Forgotten your Password?';
$lang['emailPasswordInvalidMsg'] = 'Please double-check your email address and password.';
$lang['auth_incorrect_password'] = 'Please double-check your password.';
$lang['auth_incorrect_login'] = 'Please double-check your email address.';
$lang['auth_incorrect_email_or_username'] = 'Please double-check your email address.';
$lang['auth_email_in_use'] = 'This email address has already been registered. Please use another email address to join.';
$lang['auth_username_in_use'] = 'Username already exists. Please choose another username.';
$lang['auth_current_email'] = 'This is your current email';
$lang['auth_incorrect_captcha'] = 'Your confirmation code does not match the one in the image.';
$lang['auth_captcha_expired'] = 'Your confirmation code has expired. Please try again.';

// Notifications
$lang['auth_message_logged_out'] = 'You have been successfully logged out.';
$lang['auth_message_login'] = 'You have been successfully logged in.';
$lang['auth_message_registration_disabled'] = 'Registration is disabled.';
$lang['auth_message_registration_step1'] = 'You have filled 1st step of registration.';
$lang['auth_message_registration_completed_1'] = 'Thank you for becoming a member of Toadsquare! <br> We will send you a Welcome email, please click on the link in it in the next 7 days so we can verify your email address and activate your account.<br/>If you do not receive your Welcome email, check your junk mail folders and if it isn\'t there email us at info@toadsquare.com. Please email us from the account your joined with.';
$lang['auth_message_registration_completed_1_first'] = 'Thank you for becoming a member of Toadsquare!';
$lang['auth_message_registration_completed_1_second'] = 'We will send you a Welcome email, please click on the link in it in the next 7 days so we can verify your email address and activate your account.';
$lang['auth_message_registration_completed_1_third'] = 'If you do not receive your Welcome email, check your junk mail folders and if it isn\'t there email us at info@toadsquare.com. Please email us from the account your joined with.';

$lang['auth_message_registration_completed_2'] = 'You have successfully registered.';
$lang['auth_message_activation_email_sent'] = 'A new activation email has been sent to %s. Follow the instructions in the email to activate your account.';
$lang['auth_message_activation_completed'] = 'Thank you for verifying your email.';
$lang['auth_message_activation_failed'] = 'The activation code you entered is incorrect or expired.';
$lang['auth_message_password_changed'] = 'Your password has been successfully changed.';
$lang['auth_message_new_password_sent'] = 'We have sent you an email. Please click on the link in it to create your new password.';
$lang['auth_message_new_password_activated'] = 'You have successfully reset your password';
$lang['auth_message_new_password_failed'] = 'Your activation key is incorrect or expired. Please check your email again and follow the instructions.';
$lang['auth_message_new_email_sent'] = 'A confirmation email has been sent to %s. Follow the instructions in the email to complete this change of email address.';
$lang['auth_message_new_email_activated'] = 'You have successfully changed your email';
$lang['auth_message_new_email_failed'] = 'Your activation key is incorrect or expired. Please check your email again and follow the instructions.';
$lang['auth_message_banned'] = 'Your account has been banned. please contact to admin';
$lang['auth_message_activateAccount'] = 'Please activate your account first.';
$lang['auth_message_unregistered'] = 'Your account has been deleted...';

// Email subjects
$lang['auth_subject_welcome'] = 'Welcome to %s';
$lang['auth_subject_welcome_with_fb'] = 'Welcome to %s';
$lang['auth_subject_activate'] = 'Welcome to %s';
//$lang['auth_subject_forgot_password'] = 'Forgot your password on %s?';
$lang['auth_subject_forgot_password'] = 'Forgotten your Password?';
$lang['auth_subject_reset_password'] = 'Your new password on %s';
$lang['auth_subject_change_email'] = 'Your new email address on %s';

// Validation
$lang['auth_label_usernameValidation'] = 'Username should be alpha numeric and characters length should be b/w 4 to 20.';
/* $lang['auth_label_passwordValidation'] = 'Password should be alpha numeric and characters length should be b/w 8 to 20.';
$lang['auth_label_confirmPasswordValidation'] = 'Confirm Password should be same as  password!';
$lang['auth_label_firstnameValidation'] = 'First name should be alpha numeric and characters length should be b/w 2 to 50.';
$lang['auth_label_lastnameValidation'] = 'Last name should be alpha numeric and characters length should be b/w 2 to 50.'; */

$lang['auth_label_passwordValidation'] = 'Password should be between 8 to 20 characters.';
$lang['auth_label_confirmPasswordValidation'] = 'Passwords do not match';
$lang['auth_label_EmailValidation'] = 'Email address should be valid; e.g., test@example.com.'; 
$lang['auth_label_firstnameValidation'] = 'Name should be between 2 to 25 characters.';
$lang['auth_label_lastnameValidation'] = 'Name should be between 2 to 25 characters.';
$lang['auth_label_companyValidation'] = 'Company name should be alpha numeric and characters length should be b/w 2 to 50.';
$lang['auth_label_professionValidation'] = 'Profession should be alpha numeric and characters length should be b/w 2 to 50.';
$lang['auth_label_phoneNumberValidation'] = 'Phone number should be numeric and characters length should be 10 digit.';
$lang['auth_label_addressValidation'] = 'Address length should be b/w 10 to 100.';
$lang['auth_label_countryValidation'] = 'Select country';
$lang['auth_label_cityValidation'] = 'City should be alpha numeric and characters length should be b/w 2 to 50.';

$lang['auth_label_signinToadsquare'] = 'You must be logged in to email';
$lang['auth_label_signuoToadsquare'] = 'Signup in Toadsquare';
$lang['auth_label_signupStep1st'] = 'Signup step 1';
$lang['auth_label_signupStep2nd'] = 'Signup step 2';
$lang['auth_label_forgotPassword'] = 'Forgotten your password?';

$lang['auth_label_getAnotherCAPTCHA'] = 'Get another CAPTCHA';
$lang['auth_label_getAnAudioCAPTCHA'] = 'Get an audio CAPTCHA';
$lang['auth_label_getAnImageCAPTCHA'] = 'Get an image CAPTCHA';
$lang['auth_label_enterTheWordsAbove'] = 'Enter the code exactly as it appears';
$lang['auth_label_enterTheNumbersYouHear'] = 'Enter the numbers you hear';
$lang['auth_label_enterTheCodeExactlyAsItAppears'] = 'Enter the code exactly as it appears:';
$lang['auth_label_signin'] = 'Signin';
$lang['auth_label_signup'] = 'Signup';
$lang['auth_label_signupStep1'] = 'Go to 2nd Step';
$lang['auth_label_getPassword'] = 'Get new password';
$lang['auth_label_changePassword'] = 'Change Password';
$lang['auth_label_signuphere'] = "Create a New Account";
$lang['auth_label_forgetYourPassword'] = "Forgotten your Password?";
$lang['auth_label_SingupWithanotherEmailAddress'] = "Signup with another email address";
$lang['auth_label_emailAlreadyUsed'] = "E-mail Address Already in Use";
$lang['auth_label_emailAlreadyUsedMsg'] = "You indicated you are a new customer, but an account already exists with the e-mail ";
$lang['auth_label_areYouReturningCustomer'] = "Are you a returning customer?";
$lang['auth_label_areYouNewCustomer'] = "Are you a new customer?";
/*
$lang['auth_label_setupProfile'] = "Would you like to setup your profile?";
$lang['auth_label_keepBrowsing'] = "Would you like to keep browsing?";
$lang['auth_label_moreAboutToadsquare'] = "Would you like to find out more about Toadsquare?";
*/

$lang['auth_label_setupProfile'] = "Setup your showcase?";
$lang['auth_label_keepBrowsing'] = "Keep browsing?";
$lang['auth_label_moreAboutToadsquare'] = "Read our Tips to find out more about Toadsquare?";
$lang['auth_label_wouldYouLike'] = "Would you like to:";

$lang['auth_label_emailAddAssoc'] = "This email address is already <br/> associated with an account";
$lang['auth_label_youForgetPass'] = "Did you forget your password ?";
$lang['auth_label_joinwthAnother'] = "Do you wish join with another email address ?";
$lang['auth_label_Or'] = "OR";
$lang['continue'] = "Continue";
$lang['req_field_msg'] = "These fields need to remain filled in to keep your membership active.";
$lang['suitableForGeneralAudiences'] = "Suitable for General Audiences";
$lang['suitableForChildren'] = "Suitable for Children";
$lang['suitableForYoungAdults'] = "Suitable for Young Adults";
$lang['someContentCouldBeOfensive'] = "Some Content Could be Offensive";
$lang['searchPreferences'] = "Search Preferences";
$lang['searchPreferencesMsg'] = "We will weight our search towards your selections.";
$lang['ratingSelection'] = "Rating Selection";
$lang['ratingSelectionTooltip'] = "Some content could be offensive: &lt;br /&gt; For example, content with a lot of swearing, with any nudity or
	content that could be culturally offensive.";
$lang['ratingSelectionMsg'] = "Toadsquare has an optional self-rating system that members can use when they upload their material.
	If you prefer not to see material from any of the following categories, select them and we will do our 
	best to modify your search results accordingly. ";


/*********Reset password*******/

$lang['Change_Your_Password'] = "Change Your Password ";
$lang['dataNotFoundFromFb'] = "We have unable to find your data from facebook. Please try again.";

$lang['message_after_registration_completed_1_first'] = 'Thank you for joining Toadsquare!';
$lang['message_after_registration_completed_1_second'] = 'Click on the link in our Welcome email in the next 7 days, to verify your email address and activate your account';
$lang['message_after_registration_completed_1_third'] = 'If you do not receive your Welcome email, double-check your junk mail folders. If there is still a problem, email info@toadsquare.com so we can investigate.We need to know the email address you joined with.';

/* End of file tank_auth_lang.php */
/* Location: ./application/language/english/tank_auth_lang.php */

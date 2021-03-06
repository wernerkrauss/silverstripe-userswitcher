<?php
/**
 * Provides a UserSwitcherForm on Controller 
 *
 * @author Shea Dawson <shea@silverstripe.com.au>
 * @license BSD http://silverstripe.org/bsd-license/
 */
class UserSwitcherControllerExtension extends Extension{

	public static $allowed_actions = array(
		'UserSwitcherForm',
		'UserSwitcherFormHTML'
	);

	public function onAfterInit(){
		if($this->providUserSwitcher()){
			Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery.js');	
			Requirements::javascript(THIRDPARTY_DIR . '/jquery-entwine/dist/jquery.entwine-dist.js');	
			Requirements::javascript(FRAMEWORK_DIR  . '/javascript/jquery-ondemand/jquery.ondemand.js');	
			Requirements::javascript(USERSWITCHER 	. '/javascript/userswitcher.js');				
		}		
	}

	public function UserSwitcherFormHTML(){
		$isCMS = substr($this->owner->getRequest()->getURL(), 0, 5) == 'admin' || (int)$this->owner->getRequest()->getVar('userswitchercms') == 1;

		if ($isCMS){
			Requirements::css(USERSWITCHER . '/css/userswitcher-admin.css');	
		}else{
			Requirements::css(USERSWITCHER . '/css/userswitcher-front.css');	
		}

		return singleton('UserSwitcherController')->UserSwitcherForm()->forTemplate();
	}

	public function providUserSwitcher(){
		return !Director::isLive() && (Permission::check('ADMIN') || Session::get('UserSwitched'));
	}

}
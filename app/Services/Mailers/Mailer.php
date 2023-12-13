<?php

namespace App\Services\Mailers;

use Gomee\Mailer\Email;
use Illuminate\Support\Facades\Config;

class Mailer extends Email{
    /**
	 * khoi tao
	 */
	public function __construct(){
		if(!$this->config){
			if($setting = get_mailer_setting()){
				$config = [
	
					'driver' => $setting->mail_driver(env('MAIL_DRIVER', 'smtp')),
					'host' => $setting->mail_host(env('MAIL_HOST', 'smtp.mailgun.org')),
				
					'port' => $setting->mail_port(env('MAIL_PORT', 587)),
					'from' => [
						'address' => $setting->mail_from_address(env('MAIL_FROM_ADDRESS', 'hello@example.com')),
						'name' => $setting->mail_from_name(env('MAIL_FROM_NAME', 'Example')),
					],
					'encryption' => $setting->mail_encryption(env('MAIL_ENCRYPTION', 'tls')),
					'username' => $setting->mail_username(env('MAIL_USERNAME')),
					'password' => $setting->mail_password(env('MAIL_PASSWORD')),
					'sendmail' => '/usr/sbin/sendmail -bs',
					'markdown' => [
						'theme' => 'default',
						'paths' => [
							resource_path('views/vendor/mail'),
						],
					],
				];
			}else{
				$config = [
	
					'driver' => env('MAIL_DRIVER', 'smtp'),
					'host' => env('MAIL_HOST', 'smtp.mailgun.org'),
				
					'port' => env('MAIL_PORT', 587),
					'from' => [
						'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
						'name' => env('MAIL_FROM_NAME', 'Example'),
					],
					'encryption' => env('MAIL_ENCRYPTION', 'tls'),
					'username' => env('MAIL_USERNAME'),
					'password' => env('MAIL_PASSWORD'),
					'sendmail' => '/usr/sbin/sendmail -bs',
					'markdown' => [
						'theme' => 'default',
						'paths' => [
							resource_path('views/vendor/mail'),
						],
					],
				];
			}
			
			$this->config = $config;
			Config::set('mail', $config);
			
		}
	}
}
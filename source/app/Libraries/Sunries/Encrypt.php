<?php

namespace App\Libraries\Sunries;


class Encrypt
{

	public static function aes256Encrypt($sText, $sPassword, $sIv)
	{
		$sPassword = md5($sPassword);
		$sIv       = substr(md5($sIv), 0, 16);
		$sEncrypt  = @bin2hex(openssl_encrypt($sText, 'aes-256-cbc', $sPassword, OPENSSL_RAW_DATA, $sIv));

		return $sEncrypt;
	}

	public static function aes256Decrypt($sText, $sPassword, $sIv)
	{
		$sPassword = md5($sPassword);
		$sIv       = substr(md5($sIv), 0, 16);
		$sDecrypt  = @openssl_decrypt(hex2bin($sText), 'aes-256-cbc', $sPassword, OPENSSL_RAW_DATA, $sIv);

		return $sDecrypt;
	}
}
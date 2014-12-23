<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Utility\Crypto;

/**
 * Mcrypt implementation of crypto features for Cake\Utility\Security
 */
class Mcrypt {

/**
 * Encrypts/Decrypts a text using the given key using rijndael method.
 *
 * @param string $text Encrypted string to decrypt, normal string to encrypt
 * @param string $key Key to use as the encryption key for encrypted data.
 * @param string $operation Operation to perform, encrypt or decrypt
 * @throws \LogicException When there are errors.
 */
	public static function rijndael($text, $key, $operation) {
		$algorithm = MCRYPT_RIJNDAEL_256;
		$mode = MCRYPT_MODE_CBC;
		$ivSize = mcrypt_get_iv_size($algorithm, $mode);

		$cryptKey = substr($key, 0, 32);

		if ($operation === 'encrypt') {
			$iv = mcrypt_create_iv($ivSize, MCRYPT_DEV_URANDOM);
			return $iv . '$$' . mcrypt_encrypt($algorithm, $cryptKey, $text, $mode, $iv);
		}
		$iv = substr($text, 0, $ivSize);
		$text = substr($text, $ivSize + 2);
		return rtrim(mcrypt_decrypt($algorithm, $cryptKey, $text, $mode, $iv), "\0");
	}

/**
 * Encrypt a value using AES-256.
 *
 * *Caveat* You cannot properly encrypt/decrypt data with trailing null bytes.
 * Any trailing null bytes will be removed on decryption due to how PHP pads messages
 * with nulls prior to encryption.
 *
 * @param string $plain The value to encrypt.
 * @param string $key The 256 bit/32 byte key to use as a cipher key.
 * @return string Encrypted data.
 * @throws \InvalidArgumentException On invalid data or key.
 */
	public static function encrypt($plain, $key, $hmacSalt = null) {
		$algorithm = MCRYPT_RIJNDAEL_128;
		$mode = MCRYPT_MODE_CBC;

		$ivSize = mcrypt_get_iv_size($algorithm, $mode);
		$iv = mcrypt_create_iv($ivSize, MCRYPT_DEV_URANDOM);
		$ciphertext = $iv . mcrypt_encrypt($algorithm, $key, $plain, $mode, $iv);
		$hmac = hash_hmac('sha256', $ciphertext, $key);
		return $hmac . $ciphertext;
	}

/**
 * Decrypt a value using AES-256.
 *
 * @param string $cipher The ciphertext to decrypt.
 * @param string $key The 256 bit/32 byte key to use as a cipher key.
 * @return string Decrypted data. Any trailing null bytes will be removed.
 * @throws InvalidArgumentException On invalid data or key.
 */
	public static function decrypt($cipher, $key) {
		// Split out hmac for comparison
		$macSize = 64;
		$hmac = substr($cipher, 0, $macSize);
		$cipher = substr($cipher, $macSize);

		$compareHmac = hash_hmac('sha256', $cipher, $key);
		// TODO time constant comparison?
		if ($hmac !== $compareHmac) {
			return false;
		}

		$algorithm = MCRYPT_RIJNDAEL_128;
		$mode = MCRYPT_MODE_CBC;
		$ivSize = mcrypt_get_iv_size($algorithm, $mode);

		$iv = substr($cipher, 0, $ivSize);
		$cipher = substr($cipher, $ivSize);
		$plain = mcrypt_decrypt($algorithm, $key, $cipher, $mode, $iv);
		return rtrim($plain, "\0");
	}
}

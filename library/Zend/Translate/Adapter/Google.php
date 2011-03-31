<?php
/**
 * This is experimental translate adapter using Google Translate services
 * Tries to translate from language specified in $options['source'] to language given in $locale
 * and caches the result
 *
 * @category   Zend
 * @package    Zend_Translate
 * @author     Michal "Techi" Vrchota <michal.vrchota@gmail.com>
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License v 3.0
 */

/** Zend_Locale */
require_once 'Zend/Locale.php';

/** Zend_Translate_Adapter */
require_once 'Zend/Translate/Adapter.php';


class Zend_Translate_Adapter_Google extends Zend_Translate_Adapter
{
	/**
     * Generates the adapter
     *
     * @param  array               $data     Translation data
     * @param  string|Zend_Locale  $locale   OPTIONAL Locale/Language to set, identical with locale identifier,
     *                                       see Zend_Locale for more information
     * @param  array               $options  OPTIONAL Options to set
     */
	public function __construct($data, $locale = null, array $options = array())
	{
		parent::__construct($data, $locale, $options);
	}
	
	/**
	 * Translate message
	 *
	 * @param string $messageId
	 * @param Zend_Locale|string $locale
	 * @return string
	 */

	public function translate($messageId, $locale = null)
	{
		if ($locale === null) {
			$locale = $this->_options['locale'];
		}
		if (!Zend_Locale::isLocale($locale, true)) {
			if (!Zend_Locale::isLocale($locale, false)) {
				// language does not exist, return original string
				return $messageId;
			}
			$locale = new Zend_Locale($locale);
		}

		$source = $this->_options['source'];

		if ($source == $locale)
		{
			return $messageId;
		}


		$frontendOptions = array(
		'lifetime' => 9999999999, // infinity?
		'automatic_serialization' => true
		);

		$backendOptions = array(
		'cache_dir' => './tmp/' // Directory where to put the cache files
		);

		// getting a Zend_Cache_Core object
		$cache = Zend_Cache::factory('Core',
		'File',
		$frontendOptions,
		$backendOptions);

		$langpair = $source.'|'.$locale;

		$cacheId = 'translation_'.str_replace('|','_',$langpair).'_'.MD5($messageId);

		if(!$result = $cache->load($cacheId)) {



			$client = new Zend_Http_Client('http://ajax.googleapis.com/ajax/services/language/translate', array(
			'maxredirects' => 0,
			'timeout'      => 30));

			$client->setParameterGet(array(
			'v' => '1.0',
			'q' => $messageId,
			'langpair' => $langpair
			));

			$response = $client->request();



			$data = $response->getBody();

			$server_result = json_decode($data);

			$status = $server_result->responseStatus; // should be 200
			$details = $server_result->responseDetails;

			$result = $server_result->responseData->translatedText;


			$cache->save($result, $cacheId, array('translation'));

		}

		return $result;

	}

	/**
     * Load translation data
     *
     * @param  string|array  $data
     * @param  string        $locale  Locale/Language to add data for, identical with locale identifier,
     *                                see Zend_Locale for more information
     * @param  array         $options OPTIONAL Options to use
     */
	protected function _loadTranslationData($data, $locale, array $options = array())
	{
		$options = $options + $this->_options;
		if (($options['clear'] == true) ||  !isset($this->_translate[$locale])) {
			$this->_translate[$locale] = array();
		}


		$this->_translate[$locale] = $data + $this->_translate[$locale] + array($locale);
	}

	/**
     * returns the adapters name
     *
     * @return string
     */
	public function toString()
	{
		return "Google";
	}
}



<?php
/**
*
* @package phpBB Extension - Acme Demo
* @copyright (c) 2013 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rwg\stopwords\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

// function dumpy($anything)
// {	
// 	global $phpbb_root_path;
// 	$log_file = $phpbb_root_path . 'store/my_ext.log';
// 	$entry = date('Y-m-d H:i:s ') . print_r($anything, true) . PHP_EOL;
// 	file_put_contents($log_file, $entry, FILE_APPEND | LOCK_EX);
// }

/**
* Event listener
*/
class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.search_native_index_before' => 'remove_stop_words',
		);
	}
	protected $stopwords;

	/**
	* Constructor
	*
	*/
	public function __construct()
	{
		$this->stopwords = array("also", "new", "try", "need", "good", "can", "cheers", "will", "thanks", "using", "get", "just", "use", "see", "one", "like", "now", "a", "about", "above", "after", "again", "against", "all", "am", "an", "and", "any", "are", "aren't", "as", "at", "be", "because", "been", "before", "being", "below", "between", "both", "but", "by", "can't", "cannot", "could", "couldn't", "did", "didn't", "do", "does", "doesn't", "doing", "don't", "down", "during", "each", "few", "for", "from", "further", "had", "hadn't", "has", "hasn't", "have", "haven't", "having", "he", "he'd", "he'll", "he's", "her", "here", "here's", "hers", "herself", "him", "himself", "his", "how", "how's", "i", "i'd", "i'll", "i'm", "i've", "if", "in", "into", "is", "isn't", "it", "it's", "its", "itself", "let's", "me", "more", "most", "mustn't", "my", "myself", "no", "nor", "not", "of", "off", "on", "once", "only", "or", "other", "ought", "our", "ours 	ourselves", "out", "over", "own", "same", "shan't", "she", "she'd", "she'll", "she's", "should", "shouldn't", "so", "some", "such", "than", "that", "that's", "the", "their", "theirs", "them", "themselves", "then", "there", "there's", "these", "they", "they'd", "they'll", "they're", "they've", "this", "those", "through", "to", "too", "under", "until", "up", "very", "was", "wasn't", "we", "we'd", "we'll", "we're", "we've", "were", "weren't", "what", "what's", "when", "when's", "where", "where's", "which", "while", "who", "who's", "whom", "why", "why's", "with", "won't", "would", "wouldn't", "you", "you'd", "you'll", "you're", "you've", "your", "yours", "yourself", "yourselves");
	}


	public function remove_stop_words($event)
	{

		$words = $event["words"];

		$newwords = array();

		foreach ($words as $action => $keys)
		{
			$newwords[$action] = array();

			foreach ($keys as $key => $wordlist)
			{
				if (count($wordlist))
				{
					$diff = array_diff($wordlist, $this->stopwords);
					$newwords[$action][$key] = $diff;
				}
				else
				{
					$newwords[$action][$key] = $wordlist;
				}
			}
		}
		$event["words"] = $newwords;
	}
}

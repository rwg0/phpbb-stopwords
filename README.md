# phpbb-stopwords
A simple PHPBB 3.3(+) extension that applies stopwords to the default search indexing

PHPBB native search indexes all words of 3 or more characters, unless it decides they occur 'too frequently' (determined by the 'Common word threshold' setting in the Search Settings in the ACP). In a fairly focused set of forums, useful search terms can end up in the 'too frequently' category and not be searchable. However, turning up the word threshold means the index starts to cover all sorts of words like 'the', 'and', 'try', etc.

The solution to this is to implement a stopword list - a list of common words that carry little or no meaning for search that are ignored by the indexing. That's what this extension does by hooking the core.search_native_index_before event and removing any stopwords from the list of words being indexed.

The stopword list is hard-coded in main_listener.php. You can edit it if you want, or if you are feeling really keen you could add some way to customize it in the PHPBB ACP. 

# Installation

Copy the rwg folder and everything in it to the ext folder of your PHPBB3 install, then enable the extension in the ACP. Once installed, test post to ensure that it is not causing any issues with posting.

You should probably then rebuild your search index. You can increase the common word threshold setting before doing so, since you can afford to index more common words now that stop words are excluded. You may need to do this a few times trying different values for the 'Common word threshold' setting, looking at what words are excluded and how big the index becomes. Good ways to check this are to 

* Look at the search_wordlist table, ordered descending by word_count - this will show the most common words being indexed and whether they are considered 'common' or not

* Look at the size of the search_wordmatch table - you may have limits on your database size that mean you do not want to make this table too big.

Both of these tables are cleared and then regenerated when you delete and then re-create the search index.


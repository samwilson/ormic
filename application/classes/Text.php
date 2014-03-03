<?php

class Text extends Kohana_Text {

	/**
	 * Apply the titlecase filter to a string: removing underscores, uppercasing
	 * initial letters, and performing a few common (and not-so-common) word
	 * replacements such as initialisms and punctuation.
	 *
	 * @param string|array $value    The underscored and lowercase string to be
	 *                               titlecased, or an array of such strings.
	 * @param 'html'|'latex' $format The desired output format.
	 * @return string                A properly-typeset title.
	 */
	public static function titlecase($value, $format = 'html')
	{
		$replacements = Kohana::$config->load('titlecase');
		if (is_array($value))
		{
			return array_map(array('WebDB_Text', 'titlecase'), $value);
		}
		else
		{
			$out = ucwords(preg_replace('|_|', ' ', $value));
			foreach (Arr::get($replacements, $format, array()) as $search => $replacement)
			{
				$out = preg_replace("|\b$search\b|i", $replacement, $out);
			}
			return trim($out);
		}
	}

}

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
 * @since         0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Utility;

/**
 * Pluralize and singularize English words.
 *
 * Inflector pluralizes and singularizes English nouns.
 * Used by CakePHP's naming conventions throughout the framework.
 *
 * @link http://book.cakephp.org/3.0/en/core-libraries/inflector.html
 */
class Inflector
{

    /**
     * Plural inflector rules
     *
     * @var array
     */
    protected static $_plural = [
        '/(s)tatus$/i' => '\1tatuses',
        '/(quiz)$/i' => '\1zes',
        '/^(ox)$/i' => '\1\2en',
        '/([m|l])ouse$/i' => '\1ice',
        '/(matr|vert|ind)(ix|ex)$/i' => '\1ices',
        '/(x|ch|ss|sh)$/i' => '\1es',
        '/([^aeiouy]|qu)y$/i' => '\1ies',
        '/(hive)$/i' => '\1s',
        '/(?:([^f])fe|([lre])f)$/i' => '\1\2ves',
        '/sis$/i' => 'ses',
        '/([ti])um$/i' => '\1a',
        '/(p)erson$/i' => '\1eople',
        '/(?<!u)(m)an$/i' => '\1en',
        '/(c)hild$/i' => '\1hildren',
        '/(buffal|tomat)o$/i' => '\1\2oes',
        '/(alumn|bacill|cact|foc|fung|nucle|radi|stimul|syllab|termin|vir)us$/i' => '\1i',
        '/us$/i' => 'uses',
        '/(alias)$/i' => '\1es',
        '/(ax|cris|test)is$/i' => '\1es',
        '/s$/' => 's',
        '/^$/' => '',
        '/$/' => 's',
    ];

    /**
     * Singular inflector rules
     *
     * @var array
     */
    protected static $_singular = [
        '/(s)tatuses$/i' => '\1\2tatus',
        '/^(.*)(menu)s$/i' => '\1\2',
        '/(quiz)zes$/i' => '\\1',
        '/(matr)ices$/i' => '\1ix',
        '/(vert|ind)ices$/i' => '\1ex',
        '/^(ox)en/i' => '\1',
        '/(alias)(es)*$/i' => '\1',
        '/(alumn|bacill|cact|foc|fung|nucle|radi|stimul|syllab|termin|viri?)i$/i' => '\1us',
        '/([ftw]ax)es/i' => '\1',
        '/(cris|ax|test)es$/i' => '\1is',
        '/(shoe)s$/i' => '\1',
        '/(o)es$/i' => '\1',
        '/ouses$/' => 'ouse',
        '/([^a])uses$/' => '\1us',
        '/([m|l])ice$/i' => '\1ouse',
        '/(x|ch|ss|sh)es$/i' => '\1',
        '/(m)ovies$/i' => '\1\2ovie',
        '/(s)eries$/i' => '\1\2eries',
        '/([^aeiouy]|qu)ies$/i' => '\1y',
        '/(tive)s$/i' => '\1',
        '/(hive)s$/i' => '\1',
        '/(drive)s$/i' => '\1',
        '/([le])ves$/i' => '\1f',
        '/([^rfoa])ves$/i' => '\1fe',
        '/(^analy)ses$/i' => '\1sis',
        '/(analy|diagno|^ba|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$/i' => '\1\2sis',
        '/([ti])a$/i' => '\1um',
        '/(p)eople$/i' => '\1\2erson',
        '/(m)en$/i' => '\1an',
        '/(c)hildren$/i' => '\1\2hild',
        '/(n)ews$/i' => '\1\2ews',
        '/eaus$/' => 'eau',
        '/^(.*us)$/' => '\\1',
        '/s$/i' => ''
    ];

    /**
     * Irregular rules
     *
     * @var array
     */
    protected static $_irregular = [
        'atlas' => 'atlases',
        'beef' => 'beefs',
        'brief' => 'briefs',
        'brother' => 'brothers',
        'cafe' => 'cafes',
        'child' => 'children',
        'cookie' => 'cookies',
        'corpus' => 'corpuses',
        'cow' => 'cows',
        'criterion' => 'criteria',
        'ganglion' => 'ganglions',
        'genie' => 'genies',
        'genus' => 'genera',
        'graffito' => 'graffiti',
        'hoof' => 'hoofs',
        'loaf' => 'loaves',
        'man' => 'men',
        'money' => 'monies',
        'mongoose' => 'mongooses',
        'move' => 'moves',
        'mythos' => 'mythoi',
        'niche' => 'niches',
        'numen' => 'numina',
        'occiput' => 'occiputs',
        'octopus' => 'octopuses',
        'opus' => 'opuses',
        'ox' => 'oxen',
        'penis' => 'penises',
        'person' => 'people',
        'sex' => 'sexes',
        'soliloquy' => 'soliloquies',
        'testis' => 'testes',
        'trilby' => 'trilbys',
        'turf' => 'turfs',
        'potato' => 'potatoes',
        'hero' => 'heroes',
        'tooth' => 'teeth',
        'goose' => 'geese',
        'foot' => 'feet',
        'foe' => 'foes'
    ];

    /**
     * Words that should not be inflected
     *
     * @var array
     */
    protected static $_uninflected = [
        '.*[nrlm]ese', '.*data', '.*deer', '.*fish', '.*measles', '.*ois',
        '.*pox', '.*sheep', 'people', 'feedback', 'stadia', '.*?media',
        'chassis', 'clippers', 'debris', 'diabetes', 'equipment', 'gallows',
        'graffiti', 'headquarters', 'information', 'innings', 'news', 'nexus',
        'proceedings', 'research', 'sea[- ]bass', 'series', 'species', 'weather'
    ];

    /**
     * Default map of accented and special characters to ASCII characters
     *
     * @var array
     */
    protected static $_transliteration = [
        'ä' => 'ae',
        'æ' => 'ae',
        'ǽ' => 'ae',
        'ö' => 'oe',
        'œ' => 'oe',
        'ü' => 'ue',
        'Ä' => 'Ae',
        'Ü' => 'Ue',
        'Ö' => 'Oe',
        'À' => 'A',
        'Á' => 'A',
        'Â' => 'A',
        'Ã' => 'A',
        'Å' => 'A',
        'Ǻ' => 'A',
        'Ā' => 'A',
        'Å' => 'A',
        'Ă' => 'A',
        'Ą' => 'A',
        'Ǎ' => 'A',
        'Ä' => 'Ae',
        'à' => 'a',
        'á' => 'a',
        'â' => 'a',
        'ã' => 'a',
        'å' => 'a',
        'ǻ' => 'a',
        'ā' => 'a',
        'ă' => 'a',
        'ą' => 'a',
        'ǎ' => 'a',
        'ª' => 'a',
        'Ç' => 'C',
        'Ć' => 'C',
        'Ĉ' => 'C',
        'Ċ' => 'C',
        'Č' => 'C',
        'ç' => 'c',
        'ć' => 'c',
        'ĉ' => 'c',
        'ċ' => 'c',
        'č' => 'c',
        'Ð' => 'D',
        'Ď' => 'D',
        'Đ' => 'D',
        'ð' => 'd',
        'ď' => 'd',
        'đ' => 'd',
        'È' => 'E',
        'É' => 'E',
        'Ê' => 'E',
        'Ë' => 'E',
        'Ē' => 'E',
        'Ĕ' => 'E',
        'Ė' => 'E',
        'Ę' => 'E',
        'Ě' => 'E',
        'Ë' => 'E',
        'è' => 'e',
        'é' => 'e',
        'ê' => 'e',
        'ë' => 'e',
        'ē' => 'e',
        'ĕ' => 'e',
        'ė' => 'e',
        'ę' => 'e',
        'ě' => 'e',
        'Ĝ' => 'G',
        'Ğ' => 'G',
        'Ġ' => 'G',
        'Ģ' => 'G',
        'Ґ' => 'G',
        'ĝ' => 'g',
        'ğ' => 'g',
        'ġ' => 'g',
        'ģ' => 'g',
        'ґ' => 'g',
        'Ĥ' => 'H',
        'Ħ' => 'H',
        'ĥ' => 'h',
        'ħ' => 'h',
        'І' => 'I',
        'Ì' => 'I',
        'Í' => 'I',
        'Î' => 'I',
        'Ї' => 'Yi',
        'Ï' => 'I',
        'Ĩ' => 'I',
        'Ī' => 'I',
        'Ĭ' => 'I',
        'Ǐ' => 'I',
        'Į' => 'I',
        'İ' => 'I',
        'і' => 'i',
        'ì' => 'i',
        'í' => 'i',
        'î' => 'i',
        'ï' => 'i',
        'ї' => 'yi',
        'ĩ' => 'i',
        'ī' => 'i',
        'ĭ' => 'i',
        'ǐ' => 'i',
        'į' => 'i',
        'ı' => 'i',
        'Ĵ' => 'J',
        'ĵ' => 'j',
        'Ķ' => 'K',
        'ķ' => 'k',
        'Ĺ' => 'L',
        'Ļ' => 'L',
        'Ľ' => 'L',
        'Ŀ' => 'L',
        'Ł' => 'L',
        'ĺ' => 'l',
        'ļ' => 'l',
        'ľ' => 'l',
        'ŀ' => 'l',
        'ł' => 'l',
        'Ñ' => 'N',
        'Ń' => 'N',
        'Ņ' => 'N',
        'Ň' => 'N',
        'ñ' => 'n',
        'ń' => 'n',
        'ņ' => 'n',
        'ň' => 'n',
        'ŉ' => 'n',
        'Ò' => 'O',
        'Ó' => 'O',
        'Ô' => 'O',
        'Õ' => 'O',
        'Ō' => 'O',
        'Ŏ' => 'O',
        'Ǒ' => 'O',
        'Ő' => 'O',
        'Ơ' => 'O',
        'Ø' => 'O',
        'Ǿ' => 'O',
        'Ö' => 'Oe',
        'ò' => 'o',
        'ó' => 'o',
        'ô' => 'o',
        'õ' => 'o',
        'ō' => 'o',
        'ŏ' => 'o',
        'ǒ' => 'o',
        'ő' => 'o',
        'ơ' => 'o',
        'ø' => 'o',
        'ǿ' => 'o',
        'º' => 'o',
        'Ŕ' => 'R',
        'Ŗ' => 'R',
        'Ř' => 'R',
        'ŕ' => 'r',
        'ŗ' => 'r',
        'ř' => 'r',
        'Ś' => 'S',
        'Ŝ' => 'S',
        'Ş' => 'S',
        'Ș' => 'S',
        'Š' => 'S',
        'ẞ' => 'SS',
        'ś' => 's',
        'ŝ' => 's',
        'ş' => 's',
        'ș' => 's',
        'š' => 's',
        'ſ' => 's',
        'Ţ' => 'T',
        'Ț' => 'T',
        'Ť' => 'T',
        'Ŧ' => 'T',
        'ţ' => 't',
        'ț' => 't',
        'ť' => 't',
        'ŧ' => 't',
        'Ù' => 'U',
        'Ú' => 'U',
        'Û' => 'U',
        'Ũ' => 'U',
        'Ū' => 'U',
        'Ŭ' => 'U',
        'Ů' => 'U',
        'Ű' => 'U',
        'Ų' => 'U',
        'Ư' => 'U',
        'Ǔ' => 'U',
        'Ǖ' => 'U',
        'Ǘ' => 'U',
        'Ǚ' => 'U',
        'Ǜ' => 'U',
        'Ü' => 'Ue',
        'ù' => 'u',
        'ú' => 'u',
        'û' => 'u',
        'ũ' => 'u',
        'ū' => 'u',
        'ŭ' => 'u',
        'ů' => 'u',
        'ű' => 'u',
        'ų' => 'u',
        'ư' => 'u',
        'ǔ' => 'u',
        'ǖ' => 'u',
        'ǘ' => 'u',
        'ǚ' => 'u',
        'ǜ' => 'u',
        'Ý' => 'Y',
        'Ÿ' => 'Y',
        'Ŷ' => 'Y',
        'ý' => 'y',
        'ÿ' => 'y',
        'ŷ' => 'y',
        'Ŵ' => 'W',
        'ŵ' => 'w',
        'Ź' => 'Z',
        'Ż' => 'Z',
        'Ž' => 'Z',
        'ź' => 'z',
        'ż' => 'z',
        'ž' => 'z',
        'Æ' => 'AE',
        'Ǽ' => 'AE',
        'ß' => 'ss',
        'Ĳ' => 'IJ',
        'ĳ' => 'ij',
        'Œ' => 'OE',
        'ƒ' => 'f',
        'Þ' => 'TH',
        'þ' => 'th',
        'Є' => 'Ye',
        'є' => 'ye',
    ];

    /**
     * Method cache array.
     *
     * @var array
     */
    protected static $_cache = [];

    /**
     * The initial state of Inflector so reset() works.
     *
     * @var array
     */
    protected static $_initialState = [];

    /**
     * Cache inflected values, and return if already available
     *
     * @param string $type Inflection type
     * @param string $key Original value
     * @param string|bool $value Inflected value
     * @return string|bool Inflected value on cache hit or false on cache miss.
     */
    protected static function _cache($type, $key, $value = false)
    {
        $key = '_' . $key;
        $type = '_' . $type;
        if ($value !== false) {
            static::$_cache[$type][$key] = $value;
            return $value;
        }
        if (!isset(static::$_cache[$type][$key])) {
            return false;
        }
        return static::$_cache[$type][$key];
    }

    /**
     * Clears Inflectors inflected value caches. And resets the inflection
     * rules to the initial values.
     *
     * @return void
     */
    public static function reset()
    {
        if (empty(static::$_initialState)) {
            static::$_initialState = get_class_vars(__CLASS__);
            return;
        }
        foreach (static::$_initialState as $key => $val) {
            if ($key !== '_initialState') {
                static::${$key} = $val;
            }
        }
    }

    /**
     * Adds custom inflection $rules, of either 'plural', 'singular',
     * 'uninflected', 'irregular' or 'transliteration' $type.
     *
     * ### Usage:
     *
     * ```
     * Inflector::rules('plural', ['/^(inflect)or$/i' => '\1ables']);
     * Inflector::rules('irregular' => ['red' => 'redlings']);
     * Inflector::rules('uninflected', ['dontinflectme']);
     * Inflector::rules('transliteration', ['/å/' => 'aa']);
     * ```
     *
     * @param string $type The type of inflection, either 'plural', 'singular',
     *   'uninflected' or 'transliteration'.
     * @param array $rules Array of rules to be added.
     * @param bool $reset If true, will unset default inflections for all
     *        new rules that are being defined in $rules.
     * @return void
     */
    public static function rules($type, $rules, $reset = false)
    {
        $var = '_' . $type;

        if ($reset) {
            static::${$var} = $rules;
        } elseif ($type === 'uninflected') {
            static::$_uninflected = array_merge(
                $rules,
                static::$_uninflected
            );
        } else {
            static::${$var} = $rules + static::${$var};
        }

        static::$_cache = [];
    }

    /**
     * Return $word in plural form.
     *
     * @param string $word Word in singular
     * @return string Word in plural
     * @link http://book.cakephp.org/3.0/en/core-libraries/inflector.html#creating-plural-singular-forms
     */
    public static function pluralize($word)
    {
        if (isset(static::$_cache['pluralize'][$word])) {
            return static::$_cache['pluralize'][$word];
        }

        if (!isset(static::$_cache['irregular']['pluralize'])) {
            static::$_cache['irregular']['pluralize'] = '(?:' . implode('|', array_keys(static::$_irregular)) . ')';
        }

        if (preg_match('/(.*)\\b(' . static::$_cache['irregular']['pluralize'] . ')$/i', $word, $regs)) {
            static::$_cache['pluralize'][$word] = $regs[1] . substr($word, 0, 1) .
                substr(static::$_irregular[strtolower($regs[2])], 1);
            return static::$_cache['pluralize'][$word];
        }

        if (!isset(static::$_cache['uninflected'])) {
            static::$_cache['uninflected'] = '(?:' . implode('|', static::$_uninflected) . ')';
        }

        if (preg_match('/^(' . static::$_cache['uninflected'] . ')$/i', $word, $regs)) {
            static::$_cache['pluralize'][$word] = $word;
            return $word;
        }

        foreach (static::$_plural as $rule => $replacement) {
            if (preg_match($rule, $word)) {
                static::$_cache['pluralize'][$word] = preg_replace($rule, $replacement, $word);
                return static::$_cache['pluralize'][$word];
            }
        }
    }

    /**
     * Return $word in singular form.
     *
     * @param string $word Word in plural
     * @return string Word in singular
     * @link http://book.cakephp.org/3.0/en/core-libraries/inflector.html#creating-plural-singular-forms
     */
    public static function singularize($word)
    {
        if (isset(static::$_cache['singularize'][$word])) {
            return static::$_cache['singularize'][$word];
        }

        if (!isset(static::$_cache['irregular']['singular'])) {
            static::$_cache['irregular']['singular'] = '(?:' . implode('|', static::$_irregular) . ')';
        }

        if (preg_match('/(.*)\\b(' . static::$_cache['irregular']['singular'] . ')$/i', $word, $regs)) {
            static::$_cache['singularize'][$word] = $regs[1] . substr($word, 0, 1) .
                substr(array_search(strtolower($regs[2]), static::$_irregular), 1);
            return static::$_cache['singularize'][$word];
        }

        if (!isset(static::$_cache['uninflected'])) {
            static::$_cache['uninflected'] = '(?:' . implode('|', static::$_uninflected) . ')';
        }

        if (preg_match('/^(' . static::$_cache['uninflected'] . ')$/i', $word, $regs)) {
            static::$_cache['pluralize'][$word] = $word;
            return $word;
        }

        foreach (static::$_singular as $rule => $replacement) {
            if (preg_match($rule, $word)) {
                static::$_cache['singularize'][$word] = preg_replace($rule, $replacement, $word);
                return static::$_cache['singularize'][$word];
            }
        }
        static::$_cache['singularize'][$word] = $word;
        return $word;
    }

    /**
     * Returns the given lower_case_and_underscored_word as a CamelCased word.
     *
     * @param string $string Word to camelize
     * @return string Camelized word. LikeThis.
     * @link http://book.cakephp.org/3.0/en/core-libraries/inflector.html#creating-camelcase-and-under-scored-forms
     */
    public static function camelize($string)
    {
        if (!($result = static::_cache(__FUNCTION__, $string))) {
            $result = str_replace(' ', '', static::humanize($string));
            static::_cache(__FUNCTION__, $string, $result);
        }
        return $result;
    }

    /**
     * Returns the given camelCasedWord as an underscored_word.
     *
     * @param string $camelCasedWord Camel-cased word to be "underscorized"
     * @return string Underscore-syntaxed version of the $camelCasedWord
     * @link http://book.cakephp.org/3.0/en/core-libraries/inflector.html#creating-camelcase-and-under-scored-forms
     */
    public static function underscore($string)
    {
        return static::normalize($string, '_');
    }

    /**
     * Returns the given CamelCasedWordGroup as an dashed-word-group.
     *
     * @param string $string The string to dasherize.
     * @return string Dashed version of the word group
     */
    public static function dasherize($string)
    {
        return static::normalize($string, '-');
    }

    /**
     * Returns the given underscored_word_group as a Human Readable Word Group.
     * (Underscores are replaced by spaces and capitalized following words.)
     *
     * @param string $string String to be made more readable
     * @param string $replacement
     * @return string Human-readable string
     * @link http://book.cakephp.org/3.0/en/core-libraries/inflector.html#creating-human-readable-forms
     */
    public static function humanize($string, $replacement = '_')
    {
        return ucwords(str_replace($replacement, ' ', static::normalize($string, $replacement)));
    }

    /**
     * Returns the given CamelCasedWordGroup as lower cased words, separated by the replacement
     * character
     *
     * @param string $string
     * @param string $replacement
     * @return string normalized stringd
     */
    public static function normalize($string, $replacement = '_')
    {
        $cacheKey = __FUNCTION__ . $replacement;

        $result = static::_cache($cacheKey, $string);

        if ($result === false) {
            $result = strtolower(preg_replace('/(?<=\\w)([A-Z])/', $replacement .'\\1', $string));
            static::_cache($cacheKey, $string, $result);
        }

        return $result;
    }

    /**
     * Returns corresponding table name for given model $className. ("people" for the model class "Person").
     *
     * @param string $className Name of class to get database table name for
     * @return string Name of the database table for given class
     * @link http://book.cakephp.org/3.0/en/core-libraries/inflector.html#creating-table-and-class-name-forms
     */
    public static function tableize($className)
    {
        if (!($result = static::_cache(__FUNCTION__, $className))) {
            $result = static::pluralize(static::underscore($className));
            static::_cache(__FUNCTION__, $className, $result);
        }
        return $result;
    }

    /**
     * Returns Cake model class name ("Person" for the database table "people".) for given database table.
     *
     * @param string $tableName Name of database table to get class name for
     * @return string Class name
     * @link http://book.cakephp.org/3.0/en/core-libraries/inflector.html#creating-table-and-class-name-forms
     */
    public static function classify($tableName)
    {
        if (!($result = static::_cache(__FUNCTION__, $tableName))) {
            $result = static::camelize(static::singularize($tableName));
            static::_cache(__FUNCTION__, $tableName, $result);
        }
        return $result;
    }

    /**
     * Returns camelBacked version of an underscored string.
     *
     * @param string $string String to convert.
     * @return string in variable form
     * @link http://book.cakephp.org/3.0/en/core-libraries/inflector.html#creating-variable-names
     */
    public static function variable($string)
    {
        if (!($result = static::_cache(__FUNCTION__, $string))) {
            $camelized = static::camelize(static::underscore($string));
            $replace = strtolower(substr($camelized, 0, 1));
            $result = preg_replace('/\\w/', $replace, $camelized, 1);
            static::_cache(__FUNCTION__, $string, $result);
        }
        return $result;
    }

    /**
     * Returns a string with all spaces converted to dashes (by default), accented
     * characters converted to non-accented characters, and non word characters removed.
     *
     * @param string $string the string you want to slug
     * @param string $replacement will replace keys in map
     * @return string
     * @link http://book.cakephp.org/3.0/en/core-libraries/inflector.html#creating-url-safe-strings
     */
    public static function slug($string, $replacement = '-')
    {
        $quotedReplacement = preg_quote($replacement, '/');

        $map = [
            '/[^\s\p{Zs}\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}]/mu' => ' ',
            '/[\s\p{Zs}]+/mu' => $replacement,
            sprintf('/^[%s]+|[%s]+$/', $quotedReplacement, $quotedReplacement) => '',
        ];

        $string = str_replace(
            array_keys(static::$_transliteration),
            array_values(static::$_transliteration),
            $string
        );
        return preg_replace(array_keys($map), array_values($map), $string);
    }
}

// Store the initial state
Inflector::reset();

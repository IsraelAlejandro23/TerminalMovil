<?php namespace App\Http\Controllers;

//(isset($passGen) && is_a($passGen, "RandomStrController")) or $passGen = new RandomStrController;

class RandomStrController{

	/*----------------------------------------------------------------------------------------
	  randomString Script- © 2008 Jean Korte (www.jeankorte.ca)

	  randString( int $length [, string $type[, string $exclude [, bool $repeat]]])

	  Returns a random string of length $length or false on failure.

	  $type     mixed     - default
	                      - alphanumeric, both upper and lower case
	            mixed-uc  - alphanumeric, upper case
	            mixed-lc  - alphanumeric, lower case
	            alpha     - alpha, both upper and lower case
	            alpha-uc  - alpha, upper case
	            alpha-lc  - alpha, lower case
	            numeric   - numeric
	  $exclude  alphanumeric string of characters to exclude. Defaults to null.
	  $repeat   Set to false to prevent repetition of characters in string.  Default is true.

	  Designed for captcha - could also be used for passwords.
	  For mixed captcha, suggested exclusions are 0Oo1l2Z5S.
	  For aural captcha, consider also excluding fFxXsS.
	----------------------------------------------------------------------------------------*/
	function randString($length,$type=false,$exclude=false,$repeat=true)
	{
		$string['lower'] = 'abcdefghijklmnopqrstuvwxyz';
	  	$string['upper'] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	  	$string['digits'] = '0123456789';
	  	$type=strtolower($type);

	  	if($exclude)
	  	{
	    	$exclude = str_split($exclude);
	    	foreach($string as $key=>$value)
	    	{
	      		$string[$key] = str_ireplace($exclude,'',$value);
	    	}
	  	}

	  	switch ($type)
	  	{
	    	case 'numeric':
	      		$chars = $string['digits'];
	      		break;
	    	case 'alpha':
	      		$chars = $string['lower'].$string['upper'];
	      		break;
	    	case 'alpha-uc':
	      		$chars = $string['upper'];
	      		break;
	    	case 'alpha-lc':
	      		$chars = $string['lower'];
	      		break;
	    	case 'mixed-uc':
	      		$chars = $string['upper'].$string['digits'];
	      		break;
	    	case 'mixed-lc':
	      		$chars = $string['lower'].$string['digits'];
	      		break;
	    	case 'mixed':
	    	default:
	      		$chars=$string['lower'].$string['upper'].$string['digits'];
	      		break;
	  	}

		$char_length = strlen($chars);
		if((!$repeat) AND ($length > $char_length ))
	  	{
	    	//$err_msg = "ALLOWING REPEATS - only $char_length chars available ";
	    	$repeat=true;
	    	//trigger_error($err_msg,E_USER_NOTICE);
	  	}

	  	$rand_string = "";
	  	for ($i = 0; ($i < $length); $i++)
	  	{
			$char = substr($chars,mt_rand(0, strlen($chars) - 1), 1);
	    	$rand_string .= $char;
	    	if(!$repeat)$chars=str_ireplace($char,'',$chars);
	  	}
	  	return $rand_string;
	}



    /**
     * The characters list
     *
     * @var array
     */
    protected $characters = array(
            "uppercase" => array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"),
            "lowercase" => array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"),
            "number" => array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0"),
            "special" => array("!", "@", "#", "$", "%", "^", "&", "*", "(", ")"),
            "extra" => array("[", "]", "{", "}", "-", "_", "+", "=", "<", ">", "?", "/", "`", "~", "|", ",", ".", ";", ":"),
        );

    /**
     * The List of all characters which used to generrate password
     *
     * @var array
     */
    protected $chars;

    /**
     * The length of password
     *
     * @var int
     */
    var $length = 12;

    /**
     * Whether characters will included
     *
     * @var boolean
     */
    var $config = array(
            "uppercase" => true,
            "lowercase" => true,
            "number" => true,
            "special" => true,
            "extra" => false,
        );

    /**
     * {Missing Description}
     *
     * @return object
     */
    function RandomStrController($config =array(), $length = 12){
        $this->configure($config);

        return $this;
    }

    /**
     * Initialize the setting
     *
     * @return array
     */
    function configure($config =array(), $length = 12){
        $this->chars = array();

        (!is_int($length)) or $this->length = $length;

        if(!empty($config)){
            foreach ($this->config as $key => $value) {
                $this->config[$key] = false;
            }

            foreach ($config as $key => $value) {
                (!array_key_exists($key, $this->config)) or $this->config[$key] = $value;
            }
        }

        foreach ($this->config as $key => $value) {
            if($value == true){
                (!array_key_exists($key, $this->characters)) or $this->chars = array_merge($this->chars, $this->characters[$key]);
            }
        }

        (empty($this->chars)) or $this->chars = array_unique($this->chars);

        return $this->chars;
    }

    /**
     * Generates a random password from the defined set of characters.
     *
     * @return boolean | string
     */
    function generate(){
        if(empty($this->chars)){
            return false;
        }

        $hash = "";
        for ($i = 0; $i < $this->length; $i++) {
            $hash .= $this->chars[$this->random(0, count($this->chars) - 1)];
        }

        return $hash;
    }

    /**
     * Reset all configuration
     *
     * @return object
     */
    function flush(){
        $config = array(
            "uppercase" => true,
            "lowercase" => true,
            "number" => true,
            "special" => true,
            "extra" => false,
        );

        $this->configure($config, 12);

        return $this;
    }

    /**
     * Generates a random number
     *
     * @return int
     */
    function random($min = 0, $max = 0) {
        $max_random = 4294967295;

        $random = uniqid(microtime() . mt_rand(), true);
        $random = md5($random);
        $random = sha1($random);

        $value = substr($random, 0, 8);

        $value = abs(hexdec($value));

        ($max == 0) or $value = $min + ($max - $min + 1) * $value / ($max_random + 1);

        return abs(intval($value));
    }
}
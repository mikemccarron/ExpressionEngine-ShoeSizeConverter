<?php if( !defined('BASEPATH') ) exit('No direct script access allowed');

/**
* Shoe Size Converter plugin for ExpressionEngine 2.x
*/

$plugin_info = array(
	'pi_name'			=> 'Shoe Size Converter',
	'pi_version'		=> '0.1&#914;',
	'pi_author'			=> 'Mike McCarron | One Trick Pony',
	'pi_description'	=> 'Convert US shoe size to another country shoe size.',
	'pi_usage'			=> Shoe_Size_Converter::usage()
);

class Shoe_Size_Converter
{
	public $return_data = '';

	public $usaSize;
	public $internationalSize;
	public $gender;
	public $country;
	public $maxSize = 16;

	public $sizes = array(
		"usa" => array(
			"men"   => array(5, 5.5, 6, 6.5, 7, 7.5, 8, 8.5, 9, 9.5, 10, 10.5, 11, 11.5, 12, 12.5, 13, 13.5, 14, 14.5, 15, 15.5, 16),
			"women" => array(5, 5.5, 6, 6.5, 7, 7.5, 8, 8.5, 9, 9.5, 10, 10.5, 11, 11.5, 12, 12.5, 13, 13.5, 14, 14.5, 15, 15.5, 16),
			"kids"  => array(5, 5.5, 6, 6.5, 7, 7.5, 8, 8.5, 9, 9.5, 10, 10.5, 11, 11.5, 12, 12.5, 13, 13.5, 14, 14.5, 15, 15.5, 16)
		),
		"uk" => array(
			"men"   => array(4.5, 5, 5.5, 6, 6.5, 7, 7.5, 8, 8.5, 9, 9.5, 10,   10.5, null, null, null, null, null, null, null, null, null, null, null, null, null, null),
			"women" => array(2.5, 3, 3.5, 4, 4.5, 5, 5.5, 6, 6.5, 7, 7.5, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null),
			"kids"  => array(4.5, 5, 5.5, 6, 6.5, 7, 7.5, 8, 8.5, 9, 9.5, 10,   10.5, null, null, null, null, null, null, null, null, null, null, null, null, null, null)
		),
		"china" => array(
			"men"   => array(38,   39, 39.5, 40,41, null, 42, 43, 43.5, 44, 44.5, 45, 46, null, 47, 48.5, null, null, null, null, null, null, null, null, null, null, null, null, null),
			"women" => array(35.5, 36, 37,   37.5,  38,   39, 39.5, 40, 41, null, 42, null, null, null, null, null, null, null, null, null, null, null, null, null),
			"kids"  => array(38,   39, 39.5, 40,41, null, 42, 43, 43.5, 44, 44.5, 45, 46, null, 47, 48.5, null, null, null, null, null, null, null, null, null, null, null, null, null)
		),
		"australia" => array(
			"men"   => array(4.5, 5,   5.5, 6,6.5,  7, 7.5, 8, 8.5, 9, 9.5, 10, 10.5, 11, 11.5, 12, null, null, null, null, null, null, null, null, null, null, null, null, null),
			"women" => array(5,   5.5, 6,   7, 7.5, 8, 8.5, 9, 10, 11, 12, null, null, null, null, null, null, null, null, null, null, null, null, null),
			"kids"  => array(4.5, 5,   5.5, 6, 6.5, 7, 7.5, 8, 8.5, 9, 9.5, 10, 10.5, 11, 11.5, 12, null, null, null, null, null, null, null, null, null, null, null, null, null)
		),
		"europe" => array(
			"men"   => array(37.5, 38,   38.5,  39,   40, 40.5, 41, 42, 42.5, 43, 44, 44.5, 45, 45.5, 46, 47.5, null, null, null, null, null, null, null, null, null, null, null, null, null),
			"women" => array(35,   35.5, 36,37, 37.5, 38, 38.5, 39, 40, 41,   42, null, null, null, null, null, null, null, null, null, null, null, null, null),
			"kids"  => array(37.5, 38,   38.5,  39,   40, 40.5, 41, 42, 42.5, 43, 44, 44.5, 45, 45.5, 46, 47.5, null, null, null, null, null, null, null, null, null, null, null, null, null)
		),
		"mexico" => array(
			"men"   => array(null, null, 25,   null, 26,   null, 27, null, 28, null, 29, null, 30, null, 31, 32, null, null, null, null, null, null, null, null, null, null, null, null, null),
			"women" => array(null, null, null, null, null, 4.5,  5,  5.5,  6,  6.5,  7, null, null, null, null, null, null, null, null, null, null, null, null, null),
			"kids"  => array(null, null, 25,   null, 26,   null, 27, null, 28, null, 29, null, 30, null, 31, 32, null, null, null, null, null, null, null, null, null, null, null, null, null)
		),
		"japan" => array(
			"men"   => array(null, null, 24, 24.5, 25, 25.5, null, 26,   26.5, 27,   27.5, 28, 29, 29.5, 30, 31, null, null, null, null, null, null, null, null, null, null, null, null, null),
			"women" => array(21,   21.5, 22, 22.5, 23, 23.5, 24,   24.5, 25,   25.5, 26, null, null, null, null, null, null, null, null, null, null, null, null, null),
			"kids"  => array(null, null, 24, 24.5, 25, 25.5, null, 26,   26.5, 27,   27.5, 28, 29, 29.5, 30, 31, null, null, null, null, null, null, null, null, null, null, null, null, null)
		)
	);


	public function __construct()
	{
		$this->EE =& get_instance();

		$this->usaSize =  $this->EE->TMPL->tagdata;
		$this->gender = $this->EE->TMPL->fetch_param('gender');

		switch($this->gender){
			case 'Men':
			case 'men':
			case 'Male':
			case 'male':
			$this->gender = "men";
			break;

			case 'Women':
			case 'women':
			case 'Female':
			case 'female':
			$this->gender = "women";
			break;

			case 'Kids':
			case 'kids':
			case 'Child':
			case 'child':
			$this->gender = "kids";
			break;

			default:
			$this->gender = "men";
		}

		$this->country =  $this->EE->TMPL->fetch_param('country');

		if($this->usaSize>=5 && $this->usaSize<=$this->maxSize){
			$this->convert_shoe_size();
		}
		else{
			$this->return_data = 'The shoe size provided is outside the available range.';
		}
	}

	private function convert_shoe_size(){
		$aa = $this->sizes["usa"]["$this->gender"];
		$index = array_search($this->usaSize, $aa);
		$this->return_data = (is_numeric($this->sizes["$this->country"]["$this->gender"][$index])) ? $this->sizes["$this->country"]["$this->gender"][$index] : 'n/a';
	}


	/*
	* Usage
	*
	* This function describes how the plugin is used.
	*
	* @access public
	* @return string
	*
	*/
	public static function usage(){
		ob_start(); ?>

		Pass the shoe size parameter in US/Canada, gender and the target country. This plugin will return the size equivlent for that country.

		{exp:shoe_size_converter gender='women' country='europe'}8{/exp:shoe_size_converter}

		This will return "38.5";

		==Acceptable Values:==

		Gender – men, women, child
		Countries – usa, uk, china, australia, europe, mexico, japan

		<?php
			$buffer = ob_get_contents();
			ob_end_clean();

		return $buffer;
	}
	//END
}

/* End of file pi.shoesizeconverter.php */
/* Location: ./system/expressionengine/third_party/shoe_size_converter/pi.shoe_size_converter.php */

?>
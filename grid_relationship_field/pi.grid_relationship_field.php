<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2003 - 2011, EllisLab, Inc.
 * @license		http://expressionengine.com/user_guide/license.html
 * @link		http://expressionengine.com
 * @since		Version 2.0
 * @filesource
 */
 
// ------------------------------------------------------------------------

/**
 * Zoo Visitor Grid Row ID Plugin
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Plugin
 * @author		Matt Shearing
 * @link		http://www.adigital.co.uk
 */

$plugin_info = array(
	'pi_name'		=> 'Grid Relationship Field',
	'pi_version'	=> '1.0',
	'pi_author'		=> 'Matt Shearing',
	'pi_author_url'	=> 'http://www.armitageonline.co.uk',
	'pi_description'=> 'Provides data for grid fields that are relationship fieldtypes',
	'pi_usage'		=>  grid_relationship_field::usage()
);

class Grid_relationship_field {
	public $return_data;
    
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$table = "exp_relationships";
		$child = ee()->TMPL->fetch_param('child_id');
		$result = ee()->db->from($table)->where(array('child_id' => $child))->order_by("relationship_id", "asc")->get();
		
		if ($result->num_rows() > 0) {
			foreach ($result->result() as $num => $row) {
				$name = $row->parent_id;
				$channel_search = ee()->db->from('exp_channel_titles')->where(array('entry_id' => $name))->order_by("entry_id", "asc")->get();
				if ($channel_search->num_rows() > 0) {
					foreach ($channel_search->result() as $number => $data) {
						$vars[$num]['parent_count'] = $num;
						$vars[$num]['parent_entry_id'] = $data->entry_id;
						$vars[$num]['parent_title'] = $data->title;
						$vars[$num]['parent_url_title'] = $data->url_title;
					}
				} else {
					$vars[$num]['parent_count'] = "";
					$vars[$num]['parent_entry_id'] = "";
					$vars[$num]['parent_title'] = "";
					$vars[$num]['parent_url_title'] = "";
				}
			}
		} else {
			$vars[0]['parent_count'] = "";
			$vars[0]['parent_entry_id'] = "";
			$vars[0]['parent_title'] = "";
			$vars[0]['parent_url_title'] = "";
		}
	$this->return_data = ee()->TMPL->parse_variables(ee()->TMPL->tagdata, $vars);
	}//end __construct()
	
	// ----------------------------------------------------------------
	
	/**
	 * Plugin Usage
	 */
	public static function usage()
	{
		ob_start();
?>

Core Purpose:

Create the functionality which {parents field="grid_field:relationship_field"} should provide by parsing in our entry_id.

Basic Usage Example:

{exp:channel:entries}
{exp:grid_relationship_field child_id="{entry_id}"}
<p><a href="/{segment_1}/{parent_url_title}">{parent_title}</h3></a></p>
{/exp:grid_relationship_field}
{/exp:channel:entries}

{parent_count} {parent_entry_id} {parent_title} {parent_url_title} are all available tags we can use. This allows us to link through to the child entry from our grid field. If more data is needed just parse the {parent_entry_id} through an embed to load a second channel entries tags and then target any additional fields you wish to display.

<?php
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
}


/* End of file pi.grid_relationship_field.php */
/* Location: /add-ons/system/grid_relationship_field/pi.grid_relationship_field.php */
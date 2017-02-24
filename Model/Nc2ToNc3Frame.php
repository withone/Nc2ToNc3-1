<?php
/**
 * Nc2ToNc3Frame
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Fujiki Hideyuki <TriangleShooter@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('Nc2ToNc3AppModel', 'Nc2ToNc3.Model');

/**
 * Nc2ToNc3Frame
 *
 * @see Nc2ToNc3BaseBehavior
 * @method void writeMigrationLog($message)
 * @method Model getNc2Model($tableName)
 *
 */
class Nc2ToNc3Frame extends Nc2ToNc3AppModel {

/**
 * Custom database table name, or null/false if no table association is desired.
 *
 * @var string
 * @link http://book.cakephp.org/2.0/en/models/model-attributes.html#usetable
 */
	public $useTable = false;

/**
 * List of behaviors to load when the model object is initialized. Settings can be
 * passed to behaviors by using the behavior name as index.
 *
 * @var array
 * @link http://book.cakephp.org/2.0/en/models/behaviors.html#using-behaviors
 */
	public $actsAs = ['Nc2ToNc3.Nc2ToNc3Base'];

/**
 *
 * Id map of nc2 and nc3.
 *
 * @var array
 */
	//private $__idMap = null;

/**
 * Generate Frame data for Nc3 Plugin data .
 *
 *
 * @param string nc2AnnouncementBlockld nc2Announcement block_id.
 * @return array frame data
 */
	public function generateFrame($nc2AnnouncementBlockld)
	{

		$Nc2Block = $this->getNc2Model('blocks');
		$nc2Block = $Nc2Block->findByBlockId($nc2AnnouncementBlockld, null, null, -1);

		$nc2BlockPageId = $nc2Block['Nc2Block']['page_id'];

		$Nc2ToNc3Page = ClassRegistry::init('Nc2ToNc3.Nc2ToNc3Page');
		$PageMap = $Nc2ToNc3Page->getMap($nc2BlockPageId);

		$data['Frame'] = [
  		  'room_id' => $PageMap['Room']['id'],
			'box_id' => $PageMap['Box']['id'],
			'plugin_key' => 'announcements',
		];

		$Frame = ClassRegistry::init('Frames.Frame');
		$Frame->saveFrame($data);

		return $data;
	}


}
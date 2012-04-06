<?php
/**
 * CJuiNestedSortable class file.
 *
 * @author Sebastian Thierer <sebathi@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

Yii::import('zii.widgets.jui.CJuiWidget');

/**
 * CJuiNestedSortable makes selected elements sortable by dragging with the mouse.
 *
 * CJuiNestedSortable encapsulates the {@link http://jqueryui.com/demos/sortable/ JUI Sortable}
 * plugin.
 *
 * To use this widget, you may insert the following code in a view:
 * <pre>
 * $this->widget('zii.widgets.jui.CJuiNestedSortable', array(
 *     'items'=>array(
 *         'id1'=>'Item 1',
 *         'id2'=>'Item 2',
 *         'id3'=>'Item 3',
 *     ),
 *     // additional javascript options for the accordion plugin
 *     'options'=>array(
 *         'delay'=>'300',
 *     ),
 * ));
 * </pre>
 *
 * By configuring the {@link options} property, you may specify the options
 * that need to be passed to the JUI Sortable plugin. Please refer to
 * the {@link http://jqueryui.com/demos/sortable/ JUI Sortable} documentation
 * for possible options (name-value pairs).
 *
 * If you are using javascript code anywhere in the code, please add "js:" at the
 * start of the js code definition and Yii will use this string as js code.
 *
 * @author Sebastian Thierer <sebathi@gmail.com>
 * @version $Id: CJuiNestedSortable.php 3217 2011-05-12 23:59:50Z alexander.makarow $
 * @package zii.widgets.jui
 * @since 1.1
 */
class CJuiNestedSortable extends CJuiWidget
{
	/**
	 * @var array list of sortable items (id=>item content).
	 * Note that the item contents will not be HTML-encoded.
	 */
	public $items=array();
	/**
	 * @var string the name of the container element that contains all items. Defaults to 'ul'.
	 */
	public $tagName='ol';
	/**
	 * @var string the template that is used to generated every sortable item.
	 * The token "{content}" in the template will be replaced with the item content,
	 * while "{id}" be replaced with the item ID.
	 */
	public $itemTemplate='<li id="{id}">{content}</li>';

	/**
	 * @var string the base script URL for all grid view resources (eg javascript, CSS file, images).
	 * Defaults to null, meaning using the integrated grid view resources (which are published as assets).
	 */
	public $baseScriptUrl;

	/**
	 * Run this widget.
	 * This method registers necessary javascript and renders the needed HTML code.
	 */
	public function run()
	{
		$id=$this->getId();
		if (isset($this->htmlOptions['id']))
			$id = $this->htmlOptions['id'];
		else
			$this->htmlOptions['id']=$id;

		$options=empty($this->options) ? '' : CJavaScript::encode($this->options);
		$this->baseScriptUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/nestedsortable';
		$cs=Yii::app()->getClientScript();
		$cs->registerScriptFile($this->baseScriptUrl.'/jquery.ui.nestedsortable.js',CClientScript::POS_END);
		Yii::app()->getClientScript()->registerScript(__CLASS__.'#'.$id,"jQuery('#{$id}').nestedSortable({$options});");

		echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";
		$this->goThroughItemsArray($this->items, 0, 0);
		echo CHtml::closeTag($this->tagName);
	}
	
	private function goThroughItemsArray($items, $depth, $outer_id)
	{
		foreach($items as $id=>$content)
		{
			if(is_array($content))
			{
				if($depth!==0)
				{
					if($outer_id != 0)
						 $outer_id = $id;
					echo strtr('<li id="{id}"><div>{content}</div>',array('{id}'=>$outer_id,'{content}'=>$id))."\n";
					echo CHtml::openTag($this->tagName)."\n";
				}
				$this->goThroughItemsArray($content,$depth+1, $id);
				if($depth!==0)
				{
					echo CHtml::closeTag($this->tagName);
				}
				echo CHtml::closeTag('li');
			}
			else
				echo strtr($this->itemTemplate,array('{id}'=>$id,'{content}'=>$content))."\n";
		}
	}
}



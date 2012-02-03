<?php
/**
 * CDropDownMenu class file.
 *
 * @author Herbert Maschke <thyseus@gmail.com>
 * @link http://www.yiiframework.com/
 */

/**
 * CDropDownMenu is an extension to CMenu that supports Drop-Down Menus using the
 * superfish jquery-plugin.
 *
 * Please be sure to also read the CMenu API Documentation to understand how this 
 * menu works.
 *
 */

Yii::import('zii.widgets.CMenu');

class CDropDownMenu extends CMenu
{
	public $style = 'default'; // can be changed to vertical or navbar
	public $cssFile = 'superfish.css';
	public $position = CClientScript::POS_HEAD;

	public function init()
	{
		parent::init();
		/*$this->htmlOptions['id']=$this->getId();
		$route=$this->getController()->getRoute();
		$this->items=$this->normalizeItems($this->items,$route,$hasActiveChild);*/
	}

	/**
	 * Calls {@link renderMenu} to render the menu.
	 */
	public function run()
	{
		$this->renderDropDownMenu($this->items);
	}

	protected function cssClass() {
		$class = 'sf-menu';
		if($this->style == 'vertical')
			$class .= ' sf-vertical';		
		if($this->style == 'navbar')
			$class .= ' sf-navbar';		
		return $class;
	}

	protected function renderDropDownMenu($items)
	{
		if(isset($this->htmlOptions['class']))
			$this->htmlOptions['class'] .= ' '.$this->cssClass(); 
		else
			$this->htmlOptions['class'] = $this->cssClass();
		$this->renderMenu($items);

		$this->registerClientScript();
		echo '<div style="clear:both;"></div>';
		}

	protected function registerClientScript() {
		$basePath = Yii::getPathOfAlias('ext.CDropDownMenu');
		$baseUrl = Yii::app()->getAssetManager()->publish($basePath);

		$cs = Yii::app()->clientScript;
		$cs->registerCoreScript('jquery');
		$cs->registerCssFile($baseUrl . '/css/' . $this->cssFile); 
		if($this->style == 'navbar')
			$cs->registerCssFile($baseUrl . '/css/' . 'superfish-navbar.css'); 
		if($this->style == 'vertical')
			$cs->registerCssFile($baseUrl . '/css/' . 'superfish-vertical.css'); 
		$cs->registerScriptFile($baseUrl . '/js/' . 'superfish.js',$this->position);
		//$cs->registerScriptFile($baseUrl . '/js/' . 'hoverIntent.js',$this->position);
		$cs->registerScriptFile($baseUrl . '/js/' . 'CDropDownMenu.js',$this->position);
	}

/**
	 * @var boolean
	 */
	public $optionalIndex = false;
	/**
	 * @var mixed may contain the ajaxOptions array or a boolean false
	 */
	public $ajax = false;
	/**
	 * @var boolean
	 */
	public $randomID = false;
	/**
	 * @var int counter for the menu items
	 */
	private $_itemCounter = 0;
	
	/**
	 * @see CMenu::isItemActive()
	 */
	protected function isItemActive($item,$route)
	{
		$optional_index = $this->optionalIndex ? !strcasecmp(str_replace('/index', NULL, $route),trim($item['url'][0], '/')) : false;
		if(isset($item['url']) && is_array($item['url']) && (!strcasecmp(trim($item['url'][0],'/'),$route) ) || $optional_index)
		{
			if(count($item['url'])>1)
			{
				foreach(array_splice($item['url'],1) as $name=>$value)
				{
					if(!isset($_GET[$name]) || $_GET[$name]!=$value)
						return false;
				}
			}
			return true;
		}
		return false;
	}
	
	/**
	 * @see CMenu::renderMenuItem()
	 */
	protected function renderMenuItem($item) {
		// raise the item counter
		$this->_itemCounter++;
		if (isset($item['url'])) {
		    // sets the link label
		    $label = $this->linkLabelWrapper === null ? $item['label'] : '<' . $this->linkLabelWrapper . '>' . $item['label'] . '</' . $this->linkLabelWrapper . '>';
		    // creates the ajax link
		    if (($this->ajax && (!isset($item['ajax']) || (isset($item['ajax']) && $item['ajax'] !== false))) || (isset($item['ajax']) && $item['ajax'])) {
		        // set the new id if randomID is true
		        if ($this->randomID)
		            $item['linkOptions']['id'] = isset($item['linkOptions']['id']) ? $item['linkOptions']['id'] . rand() : 'am' . uniqid();
		        else
		            $item['linkOptions']['id'] = isset($item['linkOptions']['id']) ? $item['linkOptions']['id'] : 'am-' . $this->_itemCounter;
		        // set the ajax options
		 
		        $ajax = isset($item['ajax']) ? $item['ajax'] : $this->ajax;
		        $ajax_options = $ajax;
		        if (isset($ajax['success']) == FALSE){
		            if (isset($ajax['update']))
		                $jquery_method = '$("' . $ajax['update'] . '").html(data);';
		            elseif (isset($ajax['replace']))
		                $jquery_method = '$("' . $ajax['replace'] . '").replaceWith(data);';
		            else
		                $jquery_method = NULL;
		            $ajax_options['success'] = 
		                'js: function(data) { $("#' . $this->id . ' li").removeClass("' . $this->activeCssClass . '");
		                $("#' . $item['linkOptions']['id'] . '").parent().addClass("' . $this->activeCssClass . '");
		                $("li.sf-breadcrumb").filter(function() {return $("li.current", this).length == 0;}).removeClass("sf-breadcrumb");
		                $("li.sf-breadcrumb").siblings().removeClass("sfHover");
		                $("#' . $item['linkOptions']['id'] . '").parent().parent().parent().addClass(["sf-breadcrumb","current"].join(" ")); '.
		                $jquery_method . ' }';
		        }
		        //$("#' . $item['linkOptions']['id'] . '").parent().parent().parent().addClass(["sf-breadcrumb","sfHover"].join(" "));
		        //$("li.sf-breadcrumb").filter(function() {return $("li.current", this).length == 0;}).removeClass("sf-breadcrumb"); 
		        //$("li.sf-breadcrumb").not(has(find("li.current"))).removeClass("sf-breadcrumb");
		        // creates the ajax link. $item['linkOptions'] should come 2nd in the array_merge.
		        $linkHtmlOptions = (isset($item['linkOptions']) ? array_merge(array('live'=>false), $item['linkOptions']) : array('live'=>false));
		        return CHtml::ajaxLink($label, $item['url'], $ajax_options, $linkHtmlOptions);
		 
		    } else
		        return CHtml::link($label, $item['url'], isset($item['linkOptions']) ? $item['linkOptions'] : array());
		}
		else
		    return CHtml::tag('span', isset($item['linkOptions']) ? $item['linkOptions'] : array(), $item['label']);
	}
}

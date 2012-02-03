<?php

Yii::import('zii.widgets.CMenu');
Yii::import('ext.AjaxMenu');

/**
 * @author Nicola Puddu
 * @see CMenu
 * @version 1.2
 */
class CMyAjaxMenu extends AjaxMenu {
	
	public $cssFile = 'mymenu.css';
	public $cssColorsFile = 'colors_common.css';
	public $tableHtmlOptions = array('cellpadding'=>'0', 'cellspacing'=>'0');
	public $currentSubMenuClass = 'current';
	public $submenuTableHtmlOptions = array('cellpadding'=>'0', 'cellspacing'=>'0','style'=>'display: none;');

	public function run()
	{
		$this->renderMyMenu($this->items);
	}
	
	protected function renderMenu($items)
	{
		if(count($items))
		{
			echo CHtml::openTag('div',array('id'=>'Toolbar'))."\n";
			$this->renderMenuRecursive($items);
			echo CHtml::closeTag('div')."\n";
			echo CHtml::closeTag('div')."\n";
		}
	}
	
	protected function renderMenuRecursive($items)
	{
		$count=0;
		$n=count($items);
		
		echo CHtml::openTag('div',array('id'=>'TabbarTop'));
		echo CHtml::openTag('table',$this->tableHtmlOptions)."\n";
		echo CHtml::openTag('tr')."\n";
		
		foreach($items as $key => $item)
		{
			$count++;
			$options=isset($item['itemOptions']) ? $item['itemOptions'] : array();
			$options['id'] = 'toptabdiv-'.$count;
			$class=array();
			if($item['active'] && $this->activeCssClass!='')
				$class[]=$this->activeCssClass;
			if($class!==array())
			{
				if(empty($options['class']))
					$options['class']=implode(' ',$class);
				else
					$options['class'].=' '.implode(' ',$class);
			}
			if($count != 1)
			{
				$options['class'] = 'none';
			}

			echo CHtml::openTag('td');
			echo CHtml::openTag('div', $options);

			$menu=$this->renderMenuItem($item,1);
			if(isset($this->itemTemplate) || isset($item['template']))
			{
				$template=isset($item['template']) ? $item['template'] : $this->itemTemplate;
				echo strtr($template,array('{menu}'=>$menu));
			}
			else
				echo $menu;
			echo CHtml::closeTag('div')."\n";
			echo CHtml::closeTag('td')."\n";
		}
		echo CHtml::closeTag('tr');
		echo CHtml::closeTag('table')."\n";
		echo CHtml::closeTag('div')."\n";
		
		echo CHtml::openTag('div',array('id'=>'ToolbarIn'));
		$count=0;
		foreach($items as $key => $item)
		{
			$count++;
			if(isset($item['items']) && count($item['items']))
			{
				
				$this->submenuTableHtmlOptions['id'] = 'subtab-'.$count;
				echo CHtml::openTag('table',$this->submenuTableHtmlOptions);
				echo "\n".CHtml::openTag('tr',isset($item['submenuOptions']) ? $item['submenuOptions'] : $this->submenuHtmlOptions)."\n";
				foreach($item['items'] as $subkey => $subitem)
				{
					$options = array();
					if($subkey == 0)
					{
						if(empty($options['class']))
							$options['class']=implode(' ',array($this->currentSubMenuClass));
						else
							$options['class'].=' '.implode(' ',array($this->currentSubMenuClass));
					}
					$options['id'] = 'subtabtd-'.++$subkey;
					echo CHtml::openTag('td', $options);
					echo CHtml::openTag('div');
					$options['class']='';
					$menu=$this->renderMenuItem($subitem,2);
					if(isset($this->itemTemplate) || isset($subitem['template']))
					{
						$template=isset($subitem['template']) ? $subitem['template'] : $this->itemTemplate;
						echo strtr($template,array('{menu}'=>$menu));
					}
					else
						echo $menu;
					echo CHtml::closeTag('div')."\n";
					echo CHtml::closeTag('td')."\n";
				}
				echo CHtml::closeTag('tr')."\n";
				echo CHtml::closeTag('table')."\n";
			}
		}
		echo CHtml::closeTag('div')."\n";
	}
	
	protected function renderMyMenu($items)
	{
		
		$this->renderMenu($items);

		$this->registerClientScript();
	}
	
	protected function registerClientScript() {
		$basePath = Yii::getPathOfAlias('ext.CMyAjaxMenu');
		$baseUrl = Yii::app()->getAssetManager()->publish($basePath);

		$cs = Yii::app()->clientScript;
		$cs->registerCoreScript('jquery');
		$cs->registerCssFile($baseUrl . '/css/' . $this->cssColorsFile);
		$cs->registerCssFile($baseUrl . '/css/' . $this->cssFile);
	}
}
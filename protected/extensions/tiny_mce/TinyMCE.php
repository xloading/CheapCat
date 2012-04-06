<?php
class TinyMCE extends CInputWidget
{
    public $editorOptions = array();
    
    public function run()
    {
        list($name, $id) = $this->resolveNameID();
        
        // Publishing assets.
        $dir = dirname(__FILE__);
        $assets = Yii::app()->getAssetManager()->publish($dir.DIRECTORY_SEPARATOR.'assets');
        $this->editorOptions['script_url'] = $assets.'/tiny_mce.js';
        
        // Registering javascript.
        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        $cs->registerScriptFile($assets.'/jquery.tinymce.js');
        
        $cs->registerScript(
            'Yii.'.get_class($this).'#'.$id,
            '$(function(){$("#'.$id.'").tinymce('.CJavaScript::encode($this->editorOptions).');});'
        );
        
        $this->htmlOptions['id'] = $id;
        
        if($this->hasModel())
            $html = CHtml::activeTextArea($this->model, $this->attribute, $this->htmlOptions);
        else
            $html = CHtml::textArea($name, $this->value, $this->htmlOptions);
            
        echo $html;
    }
}
?>
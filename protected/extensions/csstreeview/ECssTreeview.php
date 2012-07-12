<?php
class ECssTreeview extends CWidget
{
	
	public function run() {
		$assets = Yii::app()->getAssetManager()->publish( Yii::getPathOfAlias(
	      'ext.csstreeview' ) . '/assets' );
	    
	    // Register extension assets
	    $cs = Yii::app()->getClientScript();
	    $cs->registerScriptFile( $assets . '/csstreeview.js',
	      CClientScript::POS_END );?>
		<div class="treeview">
		<?php
		
	}
}
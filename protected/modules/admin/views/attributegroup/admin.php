<div id='grouplist'>
<b class="niftycorners" style="margin-left: 0px; margin-right: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); margin-bottom: -5px;">
	<b class="r1" style="background-color: rgb(245, 240, 187); border-color: rgb(250, 247, 221); border-right-width: 0pt; margin-right: 0pt;"></b>
	<b class="r2" style="background-color: rgb(245, 240, 187); border-color: rgb(250, 247, 221); border-right-width: 0pt; margin-right: 0pt;"></b>
	<b class="r3" style="background-color: rgb(245, 240, 187); border-color: rgb(250, 247, 221); border-right-width: 0pt; margin-right: 0pt;"></b>
	<b class="r4" style="background-color: rgb(245, 240, 187); border-color: rgb(250, 247, 221); border-right-width: 0pt; margin-right: 0pt;"></b>
</b>
<?php
$this->widget('application.extensions.MTreeView.MTreeView',array(
        'collapsed'=>true,
        'animated'=>'fast',
		//'htmlOptions' => array('class' => 'categorylist'),
        //---MTreeView options from here
        'ajaxOptions' => array('update' => '#attributes',),
        'table'=>'attributegroup',//what table the menu would come from
        'hierModel'=>'adjacency',//hierarchy model of the table
        //'conditions'=>array('visible=:visible',array(':visible'=>1)),//other conditions if any                                    
        'fields'=>array(//declaration of fields
            'text'=>'name',//no `text` column, use `title` instead
            'alt'=>false,//skip using `alt` column
            'id_parent'=>'parent_id',//no `id_parent` column,use `parent_id` instead
            'task'=>false,
            'icon'=>false,
			'tooltip'=>false,
			'position' => 'position', //order
            'url'=>array('/admin/attribute/admingroupattributes',array('id'=>'id'))
        ),
    ));
    ?>
<b class="niftycorners" style="margin-left: 0px; margin-right: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); margin-top: -5px;">
	<b class="r4" style="background-color: rgb(245, 240, 187); border-color: rgb(250, 247, 221); border-right-width: 0pt; margin-right: 0pt;"></b>
	<b class="r3" style="background-color: rgb(245, 240, 187); border-color: rgb(250, 247, 221); border-right-width: 0pt; margin-right: 0pt;"></b>
	<b class="r2" style="background-color: rgb(245, 240, 187); border-color: rgb(250, 247, 221); border-right-width: 0pt; margin-right: 0pt;"></b>
	<b class="r1" style="background-color: rgb(245, 240, 187); border-color: rgb(250, 247, 221); border-right-width: 0pt; margin-right: 0pt;"></b>
</b>
</div>
<div id='groupdetails'>
<div id='groupactions'></div>
<div id='attributes'></div>
</div>
<?php
	Yii::app()->clientScript->registerScript('treeview_click', "$('#yw0').delegate('a','click',function () { $('#yw0').find('span').filter('.active').removeClass('active'); $(this).parent().removeClass('none').addClass('active'); return true;});", CClientScript::POS_READY);
	$this->widget( 'zii.widgets.jui.CJuiWidget');
	//Yii::app()->clientScript->registerScript('unbind_yt_click', '$("a[id^="yt"]").unbind("click");', CClientScript::POS_HEAD);
	//
	//Yii::app()->clientScript->registerScript('any_click', "jQuery('a').live('click', function(){alert('you clicked me!');});",CClientScript::POS_READY);
?>
<div id="large" style="position: relative; z-index: 1003;"></div>
<div id="background"></div>

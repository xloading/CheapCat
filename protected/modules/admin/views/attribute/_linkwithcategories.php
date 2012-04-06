<div id='assignedattrs'>
<?php
//$this->GetLinkedToCategory($category->id);
$this->widget('zii.widgets.jui.CJuiNestedSortable', array(
    'items'=>$this->GetLinkedToCategory($category->id),
    'id' => 'attrlist1',
    'itemTemplate' => '<li id="{id}"><div>{content}</div></li>',
    'htmlOptions' => array('class' => 'sortable connectedSortable'),
    // additional javascript options for the accordion plugin
    'options'=>array(
    	'disableNesting' => 'no-nest',
		'forcePlaceholderSize' => 'true',
		'handle' => 'div',
		'helper' => 'clone',
		'items' => 'li',
		'maxLevels' => '3',
		'opacity' => '.6',
		'placeholder' => 'placeholder',
		'revert' => '250',
		'tolerance' => 'pointer',
		'toleranceElement' => 'div',    
    	'delay'=>'300',
		'connectWith' => '.connectedSortable',
    ),
));
?>
</div>
<div id='unassignedattrs'>
<?php
$this->widget('zii.widgets.jui.CJuiNestedSortable', array(
    'items'=>$this->GetUnassigned($category->id),
    'id' => 'attrlist2',
    'itemTemplate' => '<li id="{id}"><div>{content}</div></li>',
    'htmlOptions' => array('class' => 'sortable connectedSortable'),
    // additional javascript options for the accordion plugin
    'options'=>array(
    	'disableNesting' => 'no-nest',
		'forcePlaceholderSize' => 'true',
		'handle' => 'div',
		'helper' => 'clone',
		'items' => 'li',
		'maxLevels' => '3',
		'opacity' => '.6',
		'placeholder' => 'placeholder',
		'revert' => '250',
		'tolerance' => 'pointer',
		'toleranceElement' => 'div',    
    	'delay'=>'300',
		'connectWith' => '.connectedSortable',
    ),
));
?>
</div>
<div id='divSaveAttrs'>
<?php
	// Add a Submit button to send data to the controller
    echo CHtml::ajaxButton('Save attributes', '', array(
        'type' => 'POST',
        'data' => array(
            // Turn the Javascript array into a PHP-friendly string
            'SaveAttrs' => 'js:$("ol#attrlist1").nestedSortable("serialize").toString()',
        ),
        //'update' => '#debugattrs',
        'dataType' => 'json',
        'success' => "function(data)
                {
                    // data will contain the json data passed by the hpicheck action in the controller
                    // Update the status
                    $('#debugattrs').html(data.content);
				}",
    ),
    array('id'=>'btnSaveAttrs-'.uniqid())
    );
?>
</div>
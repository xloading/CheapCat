<?php
Yii::app()->clientScript->registerScript('supplier_filter', '(function ($) {
  // custom css expression for a case-insensitive contains()
  jQuery.expr[":"].Contains = function(a,i,m){
      return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase())>=0;
  };


  function listFilter(header, list) { // header is any element, list is an unordered list
    // create and add the filter form to the header
    var form = $("<form>").attr({"class":"filterform","action":"#"}),
        input = $("<input>").attr({"class":"filterinput","type":"text"});
    $(form).append(input).appendTo(header);

    $(input)
      .change( function () {
        var filter = $(this).val();
        if(filter) {
          // this finds all links in a list that contain the input,
          // and hide the ones not containing the input while showing the ones that do
          $(list).find("a:not(:Contains(" + filter + "))").parent().slideUp();
          $(list).find("a:Contains(" + filter + ")").parent().slideDown();
        } else {
          $(list).find("li").slideDown();
        }
        return false;
      })
    .keyup( function () {
        // fire the above change event after every letter
        $(this).change();
    });
  }


  //ondomready
  $(function () {
    listFilter($("#supplheader"), $("#supplierul"));
  });
}(jQuery));');
?>
<div id='supplierlist'>

<?php
if($models != null)
{
	echo CHtml::openTag("h1",array('id' => 'supplheader'));
	echo CHtml::closeTag("h1");
	echo CHtml::openTag("ul",array('id' => 'supplierul'));
	foreach($models as $supplier)
	{
	    echo CHtml::openTag("li");
	    echo CHtml::ajaxLink($supplier->name, array('/admin/productbysupplier/adminsupplierproducts', 'supplierid'=>$supplier->id), array('update' => '#products'));
	    echo CHtml::closeTag("li");
	}
	echo CHtml::closeTag("ul");
}
?>
</div>
<div id='supplierdetails'>
<div id='supplieractions'></div>
<div id='products'></div>
</div>
<?php
Class SuppliersBriefList extends CWidget {
	
	public $product;
	
	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		ob_start();
		ob_implicit_flush(false);
	}
	
	public function run() {
		$content = ob_get_clean();
		$this->render('suppbrieflist',array('product' => $this->product));
		echo $content;
	}
}
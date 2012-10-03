<?php
Class ProductList extends CWidget {
	
	public $products = array();
	
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
		$this->render('productlist');
		echo $content;
	}
}
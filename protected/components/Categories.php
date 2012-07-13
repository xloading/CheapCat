<?php
Class Categories extends CWidget {
	
	public $categories = array();
	
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
		$this->render('categories');
		echo $content;
	}
}
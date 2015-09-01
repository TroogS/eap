<?php
class Navigation {
	private $items = array ();
	public function addItem($item) {

		if (is_a ( $item, 'NavBarItem' ) || is_a ( $item, 'NavBarDropDown' )) {
			array_push ( $this->items, $item );
		}
	}
	public function build() {
		$output = "\n<ul class=\"nav navbar-nav\">\n";
		
		foreach ( $this->items as $item ) {
			
			if (is_a ( $item, 'NavBarItem' )) {
				
				$output .= sprintf ( "\t<li class=\"%s\"><a href=\"%s\">%s</a></li>\n", $item->getClasses(), $item->getUrl (), $item->getValue () );
			} else if (is_a ( $item, 'NavBarDropDown' )) {
				$output .= sprintf ( "\t<li class=\"dropdown\"><a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">%s <b class=\"caret\"></b></a>\n", $item->getValue () );
				$output .= "\t\t<ul class=\"dropdown-menu\">\n";
				
				$subItems = $item->getItems ();
				foreach ( $subItems as $subItem ) {
					if (is_a ( $subItem, 'NavBarItem' )) {
						
						$output .= sprintf ( "\t\t\t<li class=\"%s\"><a href=\"%s\">%s</a></li>\n", $subItem->getClasses(), $subItem->getUrl (), $subItem->getValue ());
					}
				}
				
				$output .= "\t\t</ul>\n\t</li>\n";
			}
		}
		
		$output .= "</ul>";
		
		return $output;
	}
}
class NavBarItem {
	private $url = "";
	private $value = "";
	private $classes = "";
	function __construct($value = "Empty", $url = "#", $classes = "") {
		$this->url = $url;
		$this->value = $value;
		$this->classes = $classes;
	}
	public function getUrl() {
		return $this->url;
	}
	public function getValue() {
		return $this->value;
	}
	public function getClasses() {
		return $this->classes;
	}
}
class NavBarDropDown {
	private $value = "";
	private $items = array ();
	function __construct($value = "Empty") {
		$this->value = $value;
	}
	public function addItem($item) {
		if (is_a ( $item, 'NavBarItem' )) {
			array_push ( $this->items, $item );
		}
	}
	public function getValue() {
		return $this->value;
	}
	public function getItems() {
		return $this->items;
	}
}
?>
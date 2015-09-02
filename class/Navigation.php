<?php

/**
 *
 * @author Andre Beging
 *        
 *         Class to build the navigation from given items
 *        
 */
class Navigation {

	private $items = array ();

	/**
	 * Add navigation item.
	 * Can be NavBarItem, NavBarDropDown, NavSeparator, NavHeader
	 *
	 * @param unknown $item        	
	 */
	public function addItem($item) {

		if (is_a ( $item, 'NavBarItem' ) || is_a ( $item, 'NavBarDropDown' ) || is_a ( $item, 'NavSeparator' ) || is_a ( $item, 'NavHeader' )) {
			array_push ( $this->items, $item );
		}
	
	}

	/**
	 * Builds the navigation from the added items
	 *
	 * @return string
	 */
	public function build() {

		$output = "\n<ul class=\"nav navbar-nav\">\n";
		
		foreach ( $this->items as $item ) {
			
			if (is_a ( $item, 'NavBarItem' )) {
				
				$output .= sprintf ( "\t<li class=\"%s\"><a href=\"%s\">%s</a></li>\n", $item->getClasses (), $item->getUrl (), $item->getValue () );
			}
			else if (is_a ( $item, 'NavBarDropDown' )) {
				
				$output .= sprintf ( "\t<li class=\"dropdown\"><a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">%s <b class=\"caret\"></b></a>\n", $item->getValue () );
				$output .= "\t\t<ul class=\"dropdown-menu\">\n";
				
				$subItems = $item->getItems ();
				foreach ( $subItems as $subItem ) {
					// var_dump ( $subItem );
					if (is_a ( $subItem, 'NavBarItem' )) {
						
						$output .= sprintf ( "\t\t\t<li class=\"%s\"><a href=\"%s\">%s</a></li>\n", $subItem->getClasses (), $subItem->getUrl (), $subItem->getValue () );
					}
					else if (is_a ( $subItem, "NavSeparator" )) {
						$output .= $subItem->getValue ();
					}
					else if (is_a ( $subItem, "NavHeader" )) {
						$output .= sprintf ( "\t\t\t<li class=\"dropdown-header\">%s</li>\n", $subItem->getValue () );
					}
				}
				
				$output .= "\t\t</ul>\n\t</li>\n";
			}
		}
		
		$output .= "</ul>";
		
		return $output;
	
	}

}

/**
 *
 * @author Andre Beging
 *        
 *         Class to create a dropdown navigation separator
 *        
 */
class NavSeparator {

	private $value = "";

	function __construct() {

		$this->value = "<li role=\"separator\" class=\"divider\"></li>";
	
	}

	/**
	 * Get value in HTML
	 *
	 * @return string
	 */
	public function getValue() {

		return $this->value;
	
	}

}

/**
 *
 * @author Andre Beging
 *        
 *         Class to create a dropdown navigation header
 */
class NavHeader {

	private $value = "";

	function __construct($value) {

		$this->value = $value;
	
	}

	/**
	 * Get the header name
	 *
	 * @return string
	 */
	public function getValue() {

		return $this->value;
	
	}

}

/**
 *
 * @author Andre Beging
 *        
 *         Class to create a navigation bar item
 *        
 */
class NavBarItem {

	private $url = "";

	private $value = "";

	private $classes = "";

	function __construct($value = "Empty", $url = "#", $classes = "") {

		$this->url = $url;
		$this->value = $value;
		$this->classes = $classes;
	
	}

	/**
	 * Get the url
	 *
	 * @return string
	 */
	public function getUrl() {

		return $this->url;
	
	}

	/**
	 * Get the name of the item
	 *
	 * @return string
	 */
	public function getValue() {

		return $this->value;
	
	}

	/**
	 * Get the css classes
	 *
	 * @return string
	 */
	public function getClasses() {

		return $this->classes;
	
	}

}

/**
 *
 * @author Andre Beging
 *        
 *         Class to create a dropdown menu
 */
class NavBarDropDown {

	private $value = "";

	private $items = array ();

	function __construct($value = "Empty") {

		$this->value = $value;
	
	}

	/**
	 * Add Item to dropdown menu.
	 * Can be NavBarItem, NavSeparator, NavHeader
	 *
	 * @param
	 *        	$item
	 */
	public function addItem($item) {

		if (is_a ( $item, 'NavBarItem' ) || is_a ( $item, 'NavSeparator' ) || is_a ( $item, 'NavHeader' )) {
			array_push ( $this->items, $item );
		}
	
	}

	/**
	 * Get the item name
	 *
	 * @return string
	 */
	public function getValue() {

		return $this->value;
	
	}

	/**
	 * Get all added items
	 *
	 * @return multitype:
	 */
	public function getItems() {

		return $this->items;
	
	}

}
?>
<?php
// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

/**
 * To generate the pagination pass in:
 * string $id - the unigue id for your pagination div
 * int $start - Your start page
 * string $link - A link for your pages with {start} to be replaced
 * int $count - The total number of entries in your list
 * int $per - The number of elements shown per page
 *
 * Example: 
 * 	paginate = new HTML_Paginate('divID', !empty($_GET['start']) ? $_GET['start'] : 0, 'index.php?start={start}', 52, 5);
 *	print $paginate->toHTML();
 */

class HTML_Paginate extends HTML_Element
{
	protected $registry;
	private $vars;
	
	public function __construct($id, $start, $link, $count, $per=10, $page_numbers=true)
	{
		parent::__construct();
		
		if ($start < 0 || $start > $count) $start = 0;
		
		$link = stripslashes($link);
		
		$current = floor($start/$per) + 1;
		$current_records = ($start + 1). '-' . (($current * $per) > $count ? $count : ($current * $per));
		$pages = ceil($count/$per);
		
		$this->vars = array(
			'id' => 'paginate_'.$id,
			'current_records' => $current_records,
			'count' => $count,
			'current' => $current,
			'previous' => $previous,
			'next' => $next,
			'link' => $link,
			'pages' => $pages,
			'per' => $per,
			'start' => $start,
			'page_numbers' => $page_numbers
		);
		
		$this->make();
	}
	
	public function __set($index, $value)
	{
		$this->vars[$index] = $value;
	}
	
	public function __get($index)
	{
		if (array_key_exists($index, $this->vars)) return $this->vars[$index];
        return null;
	}
	
	private function make()
	{
		$wrap = $this->createElement('div', null, array('id' => $this->id, 'class' => 'paginate_wrap '.$this->id));
		$wrap->appendChild($this->currentView());
		$wrap->appendChild($this->paginate());
		$wrap->appendChild($this->createElement('div', null, array('class' => 'both')));
		$wrap->appendChild($this->previousLink());
		$wrap->appendChild($this->nextLink());
		$this->appendChild($wrap);
	}
	
	private function currentView()
	{
		$cv = $this->createElement('div', null, array('class' => 'current_view'));
		$cv->appendChild($this->createTextNode('Currently viewing records '));
		$cv->appendChild($this->createElement('b', $this->current_records));
		$cv->appendChild($this->createTextNode(' of '.$this->count));
		return $cv;
	}
	
	private function paginate()
	{
		$paginate = $this->createElement('div', null, array('class' => 'paginate'));
		$paginate->appendChild($this->createElement('a', $this->pages, array('href' => urlencode($this->link), 'class' => 'link', 'style' => 'display:none;')));
		$paginate->appendChild($this->createElement('span', $this->per, array('class' => 'per', 'style' => 'display:none;')));
		$slider = $this->createElement('div', null, array('class' => 'slider', 'style' => ($this->page_numbers) ? 'display:none;' : null));
		$slider->appendChild($this->createElement('div', null, array('class' => 'Tips knob', 'title' => 'Drag me to go to the desired page')));
		$paginate->appendChild($slider);
		if ($this->page_numbers) $paginate->appendChild($this->pageNumbers());
		$current = $this->createElement('div', null, array('style' => 'float:left;'));
		$current->appendChild($this->createTextNode('Page '));
		$current->appendChild($this->createElement('span', $this->current, array('class' => 'current')));
		$current->appendChild($this->createTextNode(' of '.$this->pages));
		$paginate->appendChild($current);
		return $paginate;
	}
	
	private function pageNumbers()
	{
		$numbers = $this->createElement('div', null, array('class' => 'numbers'));
		for ($i = 1; $i <= $this->pages; $i++):
			if ($i != $this->current):
				// (($display * ($i - 1))) 
				$link = str_replace("{start}", ($this->per * ($i - 1)), $this->link);
				$numbers->appendChild($this->createElement('a', $i.' ', array('href' => $link)));
			else:
				$numbers->appendChild($this->createTextNode($i.' '));
			endif;
		endfor;
		return $numbers;
	}
	
	private function previousLink()
	{
		$previous = $this->createElement('div', null, array('class' => 'previous'));
		if ($this->current != 1):
			$link = str_replace("{start}", ($this->start - $this->per), $this->link);
			$previous->appendChild($this->createElement('a', 'Previous', array('href' => $link)));
		endif;
		return $previous;
	}
	
	private function nextLink()
	{
		$next = $this->createElement('div', null, array('class' => 'next'));
		if ($this->current != $this->pages):
			$link = str_replace("{start}", ($this->start + $this->per), $this->link);
			$next->appendChild($this->createElement('a', 'Next', array('href' => $link)));
		endif;
		return $next;
	}
}

class PaginateException extends UthandoException {}

?>
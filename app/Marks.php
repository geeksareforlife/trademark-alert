<?php

namespace GeeksAreForLife\TM;

use H0gar\Xpath\Doc;

class Marks
{
	private $jnl;

	private $url = 'https://www.ipo.gov.uk/tmcase/Results/4/%s';

	private $terms = [];

	public function __construct($xmlUrl)
	{
		$this->jnl = new Doc(file_get_contents('https://www.ipo.gov.uk/t-tmj/tm-journals/2017-014/jnl.xml'), 'xml');
	}

	public function addTerms($terms)
	{
		$this->terms = array_merge($this->terms, $terms);
	}

	public function find()
	{
		$markNodes = $this->jnl->items('//JournalEntries');
		$marks = [];
		foreach ($markNodes as $markNode) {
		    $text = strtolower($markNode->item('//MarkVerbalElementText')->text());
		    $id = $markNode->item('//RegistrationNumber')->text();


		    foreach ($this->terms as $term) {
		        if (strpos($text, $term) !== false) {
		            $mark = [
		                'id'            =>  $id,
		                'mark'          =>  $text,
		                'url'           =>  sprintf($this->url, $id),
		                'owner'         =>  $markNode->item('//ApplicantName')->text(),
		                'registered'    =>  $markNode->item('//ApplicationDate')->text(),
		                'classes'       =>  [],
		            ];

		            $classes = $markNode->items('//GoodsServicesDetails');
		            foreach ($classes as $class) {
		                $mark['classes'][] = [
		                    'number'        =>  $class->item('//ClassNumber')->text(),
		                    'description'   =>  $class->item('//GoodsServicesDescription')->text(),
		                ];
		            }

		            $marks[] = $mark;

		            break;
		        }
		    }
		}

		return $marks;
	}
}
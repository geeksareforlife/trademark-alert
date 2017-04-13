<?php
require __DIR__ . '/vendor/autoload.php';

use GeeksAreForLife\TM\Marks;

$marks = new Marks('https://www.ipo.gov.uk/t-tmj/tm-journals/2017-014/jnl.xml');

$marks->addTerms(['newcastle', 'london']);

$foundMarks = $marks->find();


var_dump($foundMarks);
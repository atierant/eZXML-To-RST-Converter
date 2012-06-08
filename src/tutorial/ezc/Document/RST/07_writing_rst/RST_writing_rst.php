<?php
require_once './src/tutorial/autoload.php';

// Loading the document in Docbook format
$docbook = new ezcDocumentDocbook();
$docbook->loadFile( dirname(__FILE__).'/docbook.xml' );

// Converting to RST
$rst = new ezcDocumentRst();
$rst->createFromDocbook( $docbook );
$result = $rst->save();

// We store it in a new file
$myRstResult = fopen(dirname(__FILE__).'/07_writing_rst.rst', 'a+');
fputs($myRstResult, $result );
fclose($myRstResult);



<?php
    require 'tutorial_autoload.php';

    // Load custom directive
    require '00_01_address_directive.php';

    $document = new ezcDocumentRst();
    $document->registerDirective( 'address', 'myAddressDirective' );
    $document->loadFile( 'RST_adress_directive.txt');

    $docbook = $document->getAsDocbook();
    echo $docbook->save();
    ?> 

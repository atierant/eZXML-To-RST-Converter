<?php
/**
 * @copyright
 * @license 
 * @version 
 * @filesource
 * @package 
 */

/**
 * Desc
 *
 * @package 
 * @version 
 */
class EzcDocumentEzXmlToRstConverter
{
    public function convertRstToEzXml( ezcDocumentRst $rstInput )
    {
        // Create a new transitional ezcDocbook object to recieve the first convert
        $docbook = new ezcDocumentDocbook();
        
        // Set our object to catch all errors during conversion
        $docbook->options->errorReporting = E_PARSE | E_ERROR | E_WARNING;
        
        //Convert the RST File into the ezcDocbook object
        $docbook = $rstInput->getAsDocbook();

        // We store it in a new file
        $myDocbookResult = fopen(dirname(__FILE__).'/result/convert_rst_docbook_result.xml', 'a+');
        fputs($myDocbookResult, $docbook->save() );
        fclose($myDocbookResult);

        var_dump($docbook->validateFile( dirname(__FILE__).'/result/convert_rst_docbook_result.xml' ));


        // Loading the document in Docbook format
        //$docbookToConvert = new ezcDocumentDocbook();
        //$docbookToConvert->loadFile( dirname(__FILE__).'/convert_rst_docbook_result.xml' );

        // Create a new eZ XML object to recieve the convert
        //$ezXml = new ezcDocumentEzXml();

        // Transformation in eZ XML object
        //$ezXml->createFromDocbook( $docbook );

        // We store it in a new file
        //$myEZXmlResult = fopen(dirname(__FILE__).'/result/ezxml_result.xml', 'a+');
        //fputs($myEZXmlResult, $ezXml );
        //fclose($myEZXmlResult);
        //$result = $ezXml->save();
    }

    public function convertEZXML2RST( ezcDocumentEzXml $ezXmlInput )
    {
        
        
        
        
        
    }
}

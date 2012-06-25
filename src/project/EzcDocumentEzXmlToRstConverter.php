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
        
        $errors = $docbook->validateString($docbook->save());
        var_dump($errors);

        // We store it in a new file
        $docbookResult = fopen(dirname(__FILE__).'/result/convert_rst_docbook_result.xml', 'w+');
        fputs($docbookResult, $docbook->save());
        fclose($docbookResult);

        // To debug, we store the validation in a new file
        //$validationDocbookResult = fopen(dirname(__FILE__).'/result/validationDocbookResult.log', 'a+');
        //fputs(
        //    $validationDocbookResult,
        //    var_dump($docbook->validateFile( dirname(__FILE__).'/result/convert_rst_docbook_result.xml' ))
        //);
        //fclose($validationDocbookResult);
        
        // To debug, we store errors in a new file
        //$errorDocbookResult = fopen(dirname(__FILE__).'/result/errorDocbookResult.log', 'a+');
        //fputs($errorDocbookResult, var_dump($docbook->getErrors()) );
        //fclose($errorDocbookResult);

        // Loading the document in Docbook format
        //$docbookToConvert = new ezcDocumentDocbook();
        //$docbookToConvert->loadFile( dirname(__FILE__).'/convert_rst_docbook_result.xml' );

        // Create a new eZ XML object to recieve the convert
        //$ezXml = new ezcDocumentEzXml();

        // Set our object to catch all errors during conversion
        //$ezXml->options->errorReporting = E_PARSE | E_ERROR | E_WARNING;
        
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

#     /**
#     * Return document compiled to the HTML format
#     *
#     * The internal document structure is compiled to the HTML format and the
#     * resulting HTML document is returned.
#     *
#     * This is an optional interface for document markup languages which
#     * support a direct transformation to HTML as a shortcut.
#     *
#     * @return ezcDocumentXhtml
#     */
#    public function getAsXhtml()
#    {
#        $tokenizer = new ezcDocumentRstTokenizer();
#        $parser    = new ezcDocumentRstParser();
#        $parser->options->errorReporting = $this->options->errorReporting;

#        $this->ast = $parser->parse( $tokenizer->tokenizeString( $this->contents ) );

#        $document = new ezcDocumentXhtml();

#        $visitorClass = $this->options->xhtmlVisitor;
#        $visitor = new $visitorClass( $this, $this->path );
#        $visitor->options = $this->options->xhtmlVisitorOptions;

#        $document->setDomDocument(
#            $visitor->visit( $this->ast, $this->path )
#        );

#        return $document;
#    }

#    /**
#     * Validate the input file
#     *
#     * Validate the input file against the specification of the current
#     * document format.
#     *
#     * Returns true, if the validation succeded, and an array with
#     * ezcDocumentValidationError objects otherwise.
#     *
#     * @param string $file
#     * @return mixed
#     */
#    public function validateFile( $file )
#    {
#        return $this->validateString( file_get_contents( $file ) );
#    }
}

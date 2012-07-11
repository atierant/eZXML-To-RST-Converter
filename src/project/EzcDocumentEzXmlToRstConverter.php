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
class EzcDocumentEzXmlToRstConverter extends ezcDocumentElementVisitorConverter
{

    /**
     * AS A REMEMBER :
     * RST can be converted forth and back between Docbook and RST. Additionally
     * you may register cusom visitors for the abstract sysntax tree (AST) the RST
     * parser creates, to directly convert the AST into other languages then
     * Docbook. Two different visitors for XHTML are already implemented in the
     * component:
     * - ezcDocumentRstXhtmlVisitor
     * - ezcDocumentRstXhtmlBodyVisitor
     * We can use them to create a ezcDocumentRstEzXmlVisitor
     */
     
     
     /**
     * Return document compiled to the eZ XML format
     *
     * The internal document structure is compiled to the eZ XML format and the
     * resulting eZ XML document is returned.
     *
     * @return ezcDocumentEzXml
     */
    public function convertRstToEzXml()
    {
    
        //////////////////////////////////////////////////////////
        // Première partie : traitement du RST ///////////////////
        //////////////////////////////////////////////////////////
     
        // Parse the RST Document
        $tokenizer = new ezcDocumentRstTokenizer();
        $parser    = new ezcDocumentRstParser();
        $parser->options->errorReporting = $this->options->errorReporting;
        $this->ast = $parser->parse( $tokenizer->tokenizeString( $this->contents ) );
        
        // Prepare the visitor
//        $visitorClass = $this->options->ezXmlVisitor;
//        $visitor = new $visitorClass( $this, $this->path );
//        $visitor->options = $this->options->ezXmlVisitorOptions;

        $document->setDomDocument(
            $visitor->visit( $this->ast, $this->path )
                );

        return $document;
    }
    
    public function convertRstToEzXmlPart2()
    {
     //////////////////////////////////////////////////////////
     // Seconde partie : conversion en docbook ////////////////
     //////////////////////////////////////////////////////////
    
        $rstInput = new ezcDocumentRst;
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

    public function convertEZXML2RST( ezcDocumentEzXml $ezXmlInput )
    {
        
        
    }

    

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

    /**
     * Return document as string
     *
     * Serialize the document to a string an return it.
     *
     * @return string
     */
    public function save()
    {
        return $this->contents;
    }
    
    
}

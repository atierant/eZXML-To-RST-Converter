<?php
/**
 * File containing the ezcDocumentRstEzXmlDirective interface.
 *
 * @package 
 * @version 
 * @copyright 
 * @license 
 */

/**
 * Interface for directives also supporting eZ XML output
 *
 * @package 
 * @version 
 */
interface ezcDocumentRstEzXmlDirective
{
    /**
     * Transform directive to eZ XML
     *
     * Create a eZ XML structure at the directives position in the document.
     *
     * @param DOMDocument $document
     * @param DOMElement $root
     * @return void
     */
    public function toEzXml( DOMDocument $document, DOMElement $root );
}

?>

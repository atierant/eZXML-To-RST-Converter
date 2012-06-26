<?php
/**
 * File containing the ezcDocumentRstEzXmlTextRole interface.
 *
 * @copyright
 * @license 
 * @version 
 * @filesource
 * @package 
 */

/**
 * Create a eZ XML structure at the text roles position in the document.
 *
 * @package 
 * @version 
 */
interface ezcDocumentRstEzXmlTextRole
{
    /**
     * Transform text role to eZ XML
     *
     * Create a eZ XML structure at the text roles position in the document.
     *
     * @param DOMDocument $document
     * @param DOMElement $root
     * @return void
     */
    public function toEzXml( DOMDocument $document, DOMElement $root );
}

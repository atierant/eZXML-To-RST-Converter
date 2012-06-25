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

<?php
class ezcDocumentEzXmlToRstConverterTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }

    public function testRstToEzXml()
    {
        $data = null;

        ezcDocumentEzXmlToRstConverter::convertRST2EZXML($data);
    }

    public function testRstEzXmlToRst()
    {
        $data = null;

        ezcDocumentEzXmlToRstConverter::convertEZXML2RST($data);
    }
}

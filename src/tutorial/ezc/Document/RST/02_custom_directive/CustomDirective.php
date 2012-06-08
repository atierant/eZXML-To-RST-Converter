<?php
class myCustomDirective extends ezcDocumentRstDirective
{
    public function toDocbook( DOMDocument $document, DOMElement $root )
    {
        $my_directive = $document->createElement( 'my_directive' );
        $root->appendChild( $my_directive );
        if ( !empty( $this->node->parameters ) )
        {
            $parameters = $document->createElement( 'parameters', htmlspecialchars( $this->node->parameters ) );
            $my_directive->appendChild( $parameters );
        }
        if ( isset( $this->node->options['option'] ) )
        {
            $option = $document->createElement( 'option', htmlspecialchars( $this->node->options['option'] ) );
            $my_directive->appendChild( $option );
        }
    }
}

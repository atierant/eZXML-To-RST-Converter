<?php

class myDocumentRstXhtmlVisitor extends ezcDocumentRstXhtmlVisitor
{
    protected function visitBulletList( DOMNode $root, ezcDocumentRstNode $node )
    {
        $list = $this->document->createElement( 'ul' );
        $root->appendChild( $list );

        $listTypes = array(
            '*'            => 'circle',
            '+'            => 'disc',
            '-'            => 'square',
            "\xe2\x80\xa2" => 'disc',
            "\xe2\x80\xa3" => 'circle',
            "\xe2\x81\x83" => 'square',
        );
        // Not allowed in XHTML strict
        $list->setAttribute( 'type', $listTypes[$node->token->content] );

        // Decoratre blockquote contents
        foreach ( $node->nodes as $child )
        {
            $this->visitNode( $list, $child );
        }
    }
}

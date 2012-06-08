.. _ez_components_-_document:

========================
eZ Components - Document
========================

.. _introduction:

------------
Introduction
------------

The document component offers transformations between different semantic
markup languages, like\:

- `ReStructured text`__

- `XHTML`__

- `Docbook`__

- `eZ Publish XML markup`__

- Wiki markup languages, like\: `Creole`__, `Dokuwiki`__ and `Confluence`__

Where each format support conversions from and to docbook as a central
intermediate format and may implement additional shortcuts for conversions
from and to other formats. Not each format can express the same semantics, so
there may be some information lost, which is `documented in a dedicated
document`__.

__ http://docutils.sourceforge.net/rst.html
__ http://www.w3.org/TR/xhtml1/
__ http://www.docbook.org/
__ Document_conversion.html
__ ezxml
__ creole
__ dokuwiki
__ confluence

There are central handler classes for each markup language, which follow a
common conversion interface ezcDocument and all implement the methods
getAsDocbook\(\) and createFromDocbook\(\).

.. _markup_languages:

----------------
Markup languages
----------------

The following markup languages are currently handled by the document
component.

.. _restructured_text:

ReStructured text
=================

.. _error_handling:

Error handling
--------------

By default each parsing or compiling error will be transformed into an
exception, so that you are noticed about those errors. The error reporting
settings can be modified like for all other document handlers\:

::

    <?php
    $document = new ezcDocumentRst();
    $document->options->errorReporting = E_PARSE | E_ERROR | E_WARNING;
    $document->loadFile( '../tutorial.txt' );
    
    $docbook = $document->getAsDocbook();
    echo $docbook->save();
    ?>
    
    
Where the setting in line 3 causes, that only warnings, errors and fatal
errors are transformed to exceptions now, while the notices are only
collected, but ignored. This setting affects both, the parsing of the source
document and the compiling into the destination language.

.. _directives:

Directives
----------

.. _directive_example:

Directive example
^^^^^^^^^^^^^^^^^

A full example for a custom directive, where we want to embed real world
addresses into our RST document and maintain the semantics in the resulting
docbook, could look like\:

::

    Address example
    ===============
    
    .. address:: John Doe
        :street: Some Lane 42
    
    
We would possibly add more information, like the ZIP code, city and state, but
skip this to keep the code short. The implemented directive then would just
need to take these information and transform it into valid docbook XML using
the DOM extension.

::

    <?php
    class myAddressDirective extends ezcDocumentRstDirective
    {
        public function toDocbook( DOMDocument $document, DOMElement $root )
        {
            $address = $document->createElement( 'address' );
            $root->appendChild( $address );
    
            if ( !empty( $this->node->parameters ) )
            {
                $name = $document->createElement( 'personname', htmlspecialchars( $this->node->parameters ) );
                $address->appendChild( $name );
            }
    
            if ( isset( $this->node->options['street'] ) )
            {
                $street = $document->createElement( 'street', htmlspecialchars( $this->node->options['street'] ) );
                $address->appendChild( $street );
            }
        }
    }
    ?>
    
The AST node, which should be rendered, is passed to the constructor of the
custom directive visitor and available in the class property $node. The
complete DOMDocument and the current DOMNode are passed to the method. In this
case we just create a `address node`__ with the optional child nodes street
and personname, depending on the existence of the respective values.

__ http://docbook.org/tdg/en/html/address.html

You can now render the RST document after you registered you custom directive
handler as shown above\:

::

    <?php
    
    require 'tutorial_autoload.php';
    
    // Load custom directive
    require 'address_directive.php';
    
    $document = new ezcDocumentRst();
    $document->registerDirective( 'address', 'myAddressDirective' );
    $document->loadString( <<<EORST
    Address example
    ===============
    
    .. address:: John Doe
        :street: Some Lane 42
    EORST
    );
    
    $docbook = $document->getAsDocbook();
    echo $docbook->save();
    ?>
    
The output will then look like\:

::

    <?xml version="1.0"?>
    <article xmlns="http://docbook.org/ns/docbook">
      <section ID="address_example">
        <sectioninfo/>
        <title>Address example</title>
        <address>
          <personname> John Doe</personname>
          <street> Some Lane 42</street>
        </address>
      </section>
    </article>
    
    
.. _xhtml_rendering:

XHTML rendering
---------------

.. _modification_of_xhtml_rendering:

Modification of XHTML rendering
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

You can modify the generated output of the XHTML visitor by creating a custom
visitor for the RST AST. The easiest way probably is to extend from one of the
existing XHTML visitors and reusing it. For example you may want to fill the
type attribute in bullet lists, like known from HTML, which isn\'t valid
XHTML, though\:

::

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
    
    
The structure, which is not enforced for visitors, but used in the docbook and
XHTML visitors, is to call special methods for each node type in the AST to
decorate the AST recursively. This method will be called for all bullet list
nodes in the AST which contain the actual list items. As the first parameter
the current position in the XHTML DOM tree is also provided to the method.

To create the XHTML we can now just create a new list node \(<ul>\) in the
current DOMNode, set the new attribute, and recursively decorate all
descendants using the general visitor dispatching method visitNode\(\) for all
children in the AST. For the AST childs being also rendered as children in the
XML tree, we pass the just created DOMNode \(<ul>\) as the new root node to
the visitNode\(\) method.

After defining such a class, you could use the custom visitor like shown
above\:

::

    <?php
    $document = new ezcDocumentRst();
    $document->options->xhtmlVisitor = 'myDocumentRstXhtmlVisitor';
    $document->loadFile( $from );
    
    $xhtml = $document->getAsXhtml();
    $xml = $xhtml->save();
    ?>
    
    
Now the lists in the generated XHTML will also the type attribute set.

========================
eZ Components - Document
========================

.. contents:: Table of Contents
   :depth: 2

Introduction
============

The document component offers transformations between different semantic markup
languages, like:

- `ReStructured text`__
- `XHTML`__
- `Docbook`__
- eZ Publish XML markup

Where each format support conversions from and to docbook as a central
intermediate format and may implement additional shortcuts for conversions
from and to other formats. Not each format can express the same semantics, so
there may be some information lost, which is `documented in a dedicated
document`__.

There are central handler classes for each markup language, which follow a
common conversion interface ezcDocument and all implement the methods
getAsDocbook() and createFromDocbook().

__ http://docutils.sourceforge.net/rst.html
__ http://www.w3.org/TR/xhtml1/
__ http://www.docbook.org/
__ Document_conversion.html

Markup languages
================

The following markup languages are currently handled by the document
component.

ReStructured text
-----------------

`RsStructured Text`__ (RST) is a simple text based markup language, intended
to be easy to read and write by humans. Examples can be found in the
`documentation of RST`__.

The transformation of a simple RST document to docbook can be done just like
this::

    <?php
    $document = new ezcDocumentRst();
    $document->loadFile( 'my_rst_file.txt' );

    $docbook = $document->getAsDocbook();
    echo $docbook->save();
    ?>

In line 3 the document is actually loaded and parsed into an internal abstract
syntax tree. In line 5 the internal structure is then transformed back to a
docbook document. In the last line the resulting document is returned as a
string, so that you can echo or store it.

__ http://docutils.sourceforge.net/rst.html
__ http://docutils.sourceforge.net/docs/user/rst/quickstart.html

Error handling
^^^^^^^^^^^^^^

By default each parsing or compiling error will be transformed into an
exception, so that you are noticed about those errors. The error reporting
settings can be modified like for all other document handlers::

    <?php
    $document = new ezcDocumentRst();
    $document->options->errorReporting = E_PARSE | E_ERROR | E_WARNING;
    $document->loadFile( 'my_rst_file.txt' );

    $docbook = $document->getAsDocbook();
    echo $docbook->save();
    ?>

Where the setting in line 3 causes, that only warnings, errors and fatal errors
are transformed to exceptions now, while the notices are only collected, but
ignored. This setting affects both, the parsing of the source document and the
compiling into the destination language.

Directives
^^^^^^^^^^

`RST directives`__ are elements in the RST documents with parameters, optional
named options and optional content. The document component implements a well
known subset of the `directives implemented in the docutils RST parser`__. You
may register custom directive handlers, or overwrite existing directive
handlers using your own implementation. A directive in RST markup with
parameters, options and content could look like::

    My document
    ===========

    The custom directive:

    .. my_directive:: parameters
        :option: value

        Some indented text...

For such a directive you should register a handler on the RST document, like::

    <?php
    $document = new ezcDocumentRst();
    $document->registerDirective( 'my_directive', 'myCustomDirective' );
    $document->loadFile( $from );

    $docbook = $document->getAsDocbook();
    $xml = $docbook->save();
    ?>

The class myCustomDirective must extend the class ezcDocumentRstDirective, and
implement the method toDocbook(). For rendering you get access to the full AST,
the contents of the current directive and the base path, where the document
resist in the file system - which is necessary for accessing external files.

__ http://docutils.sourceforge.net/docs/ref/rst/restructuredtext.html#directives
__ http://docutils.sourceforge.net/docs/ref/rst/directives.html

Directive example
`````````````````

A full example for a custom directive, where we want to embed real world
addresses into our RST document and maintain the semantics in the resulting
docbook, could look like::

    Address example
    ===============

    .. address:: John Doe
        :street: Some Lane 42

We would possibly add more information, like the ZIP code, city and state, but
skip this to keep the code short. The implemented directive then would just
need to take these information and transform it into valid docbook XML using
the DOM extension.

.. include: tutorial/address_directive.php
   :literal:

The AST node, which should be rendered, is passed to the constructor of the
custom directive visitor and available in the class property $node. The
complete DOMDocument and the current DOMNode are passed to the method. In this
case we just create a `address node`__ with the optional child nodes street and
personname, depending on the existence of the respective values.

You can now render the RST document after you registered you custom directive
handler as shown above:

.. include: tutorial/01_custom_directive.php
   :literal:

The output will then look like::

    <?xml version="1.0"?>
    <article xmlns="http://docbook.org/ns/docbook">
      <section id="address_example">
        <sectioninfo/>
        <title>Address example</title>
        <address>
          <personname> John Doe</personname>
          <street> Some Lane 42</street>
        </address>
      </section>
    </article>

__ http://docbook.org/tdg/en/html/address.html

XHTML rendering
^^^^^^^^^^^^^^^

For RST a conversion shortcut has been implemented, so that you don't need to
convert the RST to docbook and the docbook to XHTML. This saves conversion time
and enables you to prevent from information loss during multiple conversions::

    <?php
    $document = new ezcDocumentRst();
    $document->loadFile( $from );

    $xhtml = $document->getAsXhtml();
    $xml = $xhtml->save();
    ?>

The default XHTML compiler generates complete XHTML documents, including header
and meta-data in the header. If you want to in-line the result, you may specify
another XHTML compiler, which just creates a XHTML block level element, which
can be embedded in your source code::

    <?php
    $document = new ezcDocumentRst();
    $document->options->xhtmlVisitor = 'ezcDocumentRstXhtmlBodyVisitor';
    $document->loadFile( $from );

    $xhtml = $document->getAsXhtml();
    $xml = $xhtml->save();
    ?>

You can of course also use the predefined and custom directives for XHTML
rendering. The directives used during XHTML generation also need to implement
the interface ezcDocumentRstXhtmlDirective.

Modification of XHTML rendering
```````````````````````````````

You can modify the generated output of the XHTML visitor by creating a custom
visitor for the RST AST. The easiest way probably is to extend from one of the
existing XHTML visitors and reusing it. For example you may want to fill the
type attribute in bullet lists, like known from HTML, which isn't valid XHTML,
though::

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

To create the XHTML we can now just create a new list node (<ul>) in the
current DOMNode, set the new attribute, and recursively decorate all
descendants using the general visitor dispatching method visitNode() for all
children in the AST. For the AST childs being also rendered as children in the XML
tree, we pass the just created DOMNode (<ul>) as the new root node to the
visitNode() method.

After defining such a class, you could use the custom visitor like shown
above::

    <?php
    $document = new ezcDocumentRst();
    $document->options->xhtmlVisitor = 'myDocumentRstXhtmlVisitor';
    $document->loadFile( $from );

    $xhtml = $document->getAsXhtml();
    $xml = $xhtml->save();
    ?>

Now the lists in the generated XHTML will also the type attribute set.

Writing RST
^^^^^^^^^^^

This is not yet supported.

XHTML
-----

XHTML can only be generated from RST, but not converted from or to docbook yet.


..
   Local Variables:
   mode: rst
   fill-column: 79
   End:
   vim: et syn=rst tw=79


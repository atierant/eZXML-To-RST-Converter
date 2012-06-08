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

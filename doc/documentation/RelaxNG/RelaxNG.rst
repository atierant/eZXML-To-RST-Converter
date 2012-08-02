========
Relax NG
========

.. contents:: Table of Contents
   :depth: 3

Introduction
============

Source : Wikipedia : http://fr.wikipedia.org/wiki/Relax_NG

**Relax NG** (REgular LAnguage for XML Next Generation) est un langage de description de document XML issu de la fusion de TreX de James Clark et de Relax de Murata Makoto. Considéré comme une **alternative à XML Schema**, c'est un dialecte XML permettant de définir précisément les différentes contraintes qui déterminent la classe des documents XML qui peuvent passer l'étape de validation. Il **propose aussi cependant une syntaxe compacte**, non-XML.

Relax NG ne spécifie que la structure des documents XML (quels éléments, comment les combiner) et pas la valeur des éléments (par exemple le fait que le contenu d'un élément doit forcément être une date ou bien forcément être une chaîne de dix caractères). Cette vérification de la valeur des éléments est sous-traitée à la bibliothèque de types de XML Schema (ce qui est fait automatiquement par le processeur Relax NG).

Le leader sur ce projet est James Clark, déjà reconnu pour ses travaux en SGML, notamment sur le parseur nsgmls.
Relax NG est spécifié par l'OASIS et est en passe de devenir une partie de la norme ISO/CEI 19757-2, les langages de définitions de schémas de documents (DSDL).
Relax NG est utilisé pour spécifier OpenDocument, le futur DocBook et Atom.

-------------------------------

Le Design Relax NG
==================

Source : http://www.thaiopensource.com/relaxng/design.html

-------------------------------


Source : http://books.xmlschemata.org/relaxng/relax-PREFACE-4.html

Relax NG a pour but d'alléger le XML. Il s'agit d'un langage de schéma XML :

    - axé sur la validation de la structure des documents XML
    - assez léger pour être facile à apprendre, à lire et à écrire
    - Suffisamment puissant pour décrire n'importe quel vocabulaire basé sur du XML  1.0 et sur les espaces de noms.

En outre, un outil open-source (Trang de James Clark) permet de convertir le Relax NG en d'autres formats, y compris XML Schema.


Fonctionnement
==============

Considérons une représentation XML simple d'un carnet d'adresses e-mail :

::

    <addressBook>
      <card>
        <name>John Smith</name>
        <email>js@example.com</email>
      </card>
      <card>
        <name>Fred Bloggs</name>
        <email>fb@example.net</email>
      </card>
    </addressBook>

La DTD correspondante :

::

    <!DOCTYPE addressBook [
    <!ELEMENT addressBook (card*)>
    <!ELEMENT card (name, email)>
    <!ELEMENT name (#PCDATA)>
    <!ELEMENT email (#PCDATA)>
    ]>  

Un motif Relax NG pour ce qui pourrait être rédigé comme suit:

::

    <element name="addressBook" xmlns="http://relaxng.org/ns/structure/1.0">
      <zeroOrMore>
        <element name="card">
          <element name="name">
            <text/>
          </element>
          <element name="email">
            <text/>
          </element>
        </element>
      </zeroOrMore>
    </element>

Si le carnet d'adresses ne doit pas être vide, alors on peut utiliser ``oneOrMore`` au lieu de ``zeroOrMore``:

::

    <element name="addressBook" xmlns="http://relaxng.org/ns/structure/1.0">
      <oneOrMore>
        <element name="card">
          <element name="name">
            <text/>
          </element>
          <element name="email">
            <text/>
          </element>
        </element>
      </oneOrMore>
    </element>

Maintenant, changeons-le pour permettre à chaque ``card`` d'avoir un élément ``note`` optionnel:

::

    <element name="addressBook" xmlns="http://relaxng.org/ns/structure/1.0">
      <zeroOrMore>
        <element name="card">
          <element name="name">
            <text/>
          </element>
          <element name="email">
            <text/>
          </element>
          <optional>
            <element name="note">
                <text/>
            </element>
          </optional>
        </element>
      </zeroOrMore>
    </element>


Le modèle de texte correspond à un texte arbitraire, y compris du texte vide. De plus, les espaces séparant les balises sont ignorés lors de la recherche d'un motif.

Tous les éléments précisant le motif doivent être définis dans l'espace de noms par l'URI d'espace de nom :

::

  http://relaxng.org/ns/structure/1.0 

Les exemples ci-dessus utilisent un espace de noms par défaut ``xmlns="http://relaxng.org/ns/structure/1.0"``. Il est également possible de préfixer l'espace de noms : 

::

    <rng:element name="addressBook" xmlns:rng="http://relaxng.org/ns/structure/1.0">
      <rng:zeroOrMore>
        <rng:element name="card">
          <rng:element name="name">
            <rng:text/>
          </rng:element>
          <rng:element name="email">
            <rng:text/>
          </rng:element>
        </rng:element>
      </rng:zeroOrMore>
    </rng:element>

Pour le reste de ce document, la déclaration d'espace de noms par défaut sera laissée de côté dans les exemples.

Maintenant, supposons que nous voulons permettre au ``name`` de se décomposer en un prénom ``givenName`` et un nom de famille ``familyName``, permettant un carnet d'adresses comme ceci :

::

    <addressBook>
      <card>
        <givenName>John</givenName>
        <familyName>Smith</familyName>
        <email>js@example.com</email>
      </card>
      <card>
        <name>Fred Bloggs</name>
        <email>fb@example.net</email>
      </card>
    </addressBook>

Nous procèderons de cette manière :

::

    <element name="addressBook">
      <zeroOrMore>
        <element name="card">
          <choice>
            <element name="name">
              <text/>
            </element>
            <group>
              <element name="givenName">
                <text/>
              </element>
              <element name="familyName">
                <text/>
              </element>
            </group>
          </choice>
          <element name="email">
            <text/>
          </element>
          <optional>
        <element name="note">
          <text/>
        </element>
          </optional>
        </element>
      </zeroOrMore>
    </element>

Ceci correspond à la DTD suivante :

::

    <!DOCTYPE addressBook [
    <!ELEMENT addressBook (card*)>
    <!ELEMENT card ((name | (givenName, familyName)), email, note?)>
    <!ELEMENT name (#PCDATA)>
    <!ELEMENT email (#PCDATA)>
    <!ELEMENT givenName (#PCDATA)>
    <!ELEMENT familyName (#PCDATA)>
    <!ELEMENT note (#PCDATA)>
    ]>

Les attributs
=============

Supposons que nous voulions que l'élément ``card`` ait des attributs plutôt que des éléments enfants. La DTD pourrait ressembler à ceci:

::

    <!DOCTYPE addressBook [
    <!ELEMENT addressBook (card*)>
    <!ELEMENT card EMPTY>
    <!ATTLIST card
      name CDATA #REQUIRED
      email CDATA #REQUIRED>
    ]>

Il suffit de changer chaque modèle ``element`` en un modèle ``attribute``: 

::

    <element name="addressBook">
      <zeroOrMore>
        <element name="card">
          <attribute name="name">
            <text/>
          </attribute>
          <attribute name="email">
            <text/>
          </attribute>
        </element>
      </zeroOrMore>
    </element>

En XML, l'ordre des attributs est traditionnellement non significatif. Il en est de même pour Relax NG. Les deux modèles ci-dessus sont identiques :

::

    <card name="John Smith" email="js@example.com"/>

et

::

    <card email="js@example.com" name="John Smith"/>

En revanche, l'ordre des éléments est significatif :

::

    <element name="card">
      <element name="name">
        <text/>
      </element>
      <element name="email">
        <text/>
      </element>
    </element>

ne correspond pas à 

::

    <card><email>js@example.com</email><name>John Smith</name></card>

Notez que l'``attribute`` par lui-même indique un attribut obligatoire, tout comme un ``element`` indique un élément requis. Pour spécifier un attribut optionnel, utilisez ``optional`` tout comme avec un ``element``:

::

    <element name="addressBook">
      <zeroOrMore>
        <element name="card">
          <attribute name="name">
            <text/>
          </attribute>
          <attribute name="email">
            <text/>
          </attribute>
          <optional>
            <attribute name="note">
              <text/>
            </attribute>
          </optional>
        </element>
      </zeroOrMore>
    </element>

Les modèles ``group`` et ``choice`` peuvent être appliqués aux ``attribute`` de la même manière qu'ils sont appliqués à des ``element``. Par exemple, si nous voulons permettre soit un attribut ``name`` soit à la fois un ``givenName`` et un ``familyName``, nous pouvons le préciser de la même manière que nous le ferions si nous utilisions des éléments :

::

    <element name="addressBook">
      <zeroOrMore>
        <element name="card">
          <choice>
            <attribute name="name">
              <text/>
            </attribute>
            <group>
              <attribute name="givenName">
                <text/>
              </attribute>
              <attribute name="familyName">
                <text/>
              </attribute>
            </group>
          </choice>
          <attribute name="email">
            <text/>
          </attribute>
        </element>
      </zeroOrMore>
    </element>

Les modèles ``group`` et ``choice`` peuvent combiner à la fois des ``element`` et des ``attribute`` sans restriction. Par exemple, le schéma suivant permettrait un choix des éléments et des attributs, de manière indépendante, à la fois pour le ``name`` et l'``e-mail`` d'une ``card``:

::

    <element name="addressBook">
      <zeroOrMore>
        <element name="card">
          <choice>
            <element name="name">
              <text/>
            </element>
            <attribute name="name">
              <text/>
            </attribute>
          </choice>
          <choice>
            <element name="email">
              <text/>
            </element>
            <attribute name="email">
              <text/>
            </attribute>
          </choice>
        </element>
      </zeroOrMore>
    </element>

Comme décrit plus haut, l'ordre relatif des éléments est significatif, mais l'ordre relatif des attributs ne l'est pas. Ainsi, l'exemple précédent correspondrait à :

::

    <card name="John Smith" email="js@example.com"/>
    <card email="js@example.com" name="John Smith"/>
    <card email="js@example.com"><name>John Smith</name></card>
    <card name="John Smith"><email>js@example.com</email></card>
    <card><name>John Smith</name><email>js@example.com</email></card>

Mais pas à :

::

    <card><email>js@example.com</email><name>John Smith</name></card>

parce que le modèle pour ``card`` nécessite que chaque élément enfant ``email`` suive un élément enfant ``name`` dans cet ordre.

Il ya une différence entre l'attribut et les modèles d'éléments: <text/> est le défaut pour le contenu d'un modèle d'attribut, alors qu'un motif d'élément n'est pas autorisé à être vide. Par exemple

::

    <attribute name="email"/>

est la version raccourcie de

::

    <attribute name="email">
        <text/>
    </attribute>

Il pourrait sembler naturel que :

::

    <element name="x"/>

corresponde à un élément ``x`` sans attributs ni contenu. Toutefois, cela rendrait le sens du contenu vide incohérent entre les patrons ``element`` et ``attribute``. Relax NG ne permet donc pas au modèle ``element`` d'être vide. Un modèle qui correspond à un élément sans attribut et sans enfants doit utiliser explicitement ``<empty/>`` :

::

    <element name="addressBook">
      <zeroOrMore>
        <element name="card">
          <element name="name">
            <text/>
          </element>
          <element name="email">
            <text/>
          </element>
          <optional>
            <element name="prefersHTML">
              <empty/>
            </element>
          </optional>
        </element>
      </zeroOrMore>
    </element>

Même si le motif dans un motif ``element``  correspond uniquement à des attributs, il n'est pas nécessaire d'utiliser ``empty``. Par exemple :

::

     <element name="card">
      <attribute name="email">
        <text/>
      </attribute>
    </element>

est équivalent à :

::

    <element name="card">
      <attribute name="email">
        <text/>
      </attribute>
      <empty/>
    </element>


Modèles nommés
==============

Pour un modèle Relax NG non trivial, il est souvent pratique de pouvoir donner des noms à certaines parties du modèle. Au lieu de :

::

    <element name="addressBook">
      <zeroOrMore>
        <element name="card">
          <element name="name">
            <text/>
          </element>
          <element name="email">
            <text/>
          </element>
        </element>
      </zeroOrMore>
    </element>

on peut écrire :

::

    <grammar>

      <start>
        <element name="addressBook">
          <zeroOrMore>
            <element name="card">
              <ref name="cardContent"/>
            </element>
          </zeroOrMore>
        </element>
      </start>

      <define name="cardContent">
        <element name="name">
          <text/>
        </element>
        <element name="email">
          <text/>
        </element>
      </define>

    </grammar>

Un élément de grammaire ``grammar`` contient un élément enfant unique de départ ``start``, et zéro ou plus éléments enfants de définition ``define``. Les éléments ``start`` et ``define``  contiennent des motifs. Ces motifs peuvent contenir des éléments ``ref`` qui font référence à des motifs définis par l'un des éléments ``define`` dans l'élément ``grammar`` considéré. Un motif ``grammar`` est identifié en faisant correspondre le motif contenu dans l'élément ``start``.

Nous pouvons utiliser l'élément ``grammar`` pour écrire des motifs dans un style similaire aux DTD :

::

    <grammar>

      <start>
        <ref name="AddressBook"/>
      </start>

      <define name="AddressBook">
        <element name="addressBook">
          <zeroOrMore>
            <ref name="Card"/>
          </zeroOrMore>
        </element>
      </define>

      <define name="Card">
        <element name="card">
          <ref name="Name"/>
          <ref name="Email"/>
        </element>
      </define>

      <define name="Name">
        <element name="name">
          <text/>
        </element>
      </define>

      <define name="Email">
        <element name="email">
          <text/>
        </element>
      </define>

    </grammar>

Les références récursives sont autorisés. Par exemple :

::

    <define name="inline">
      <zeroOrMore>
        <choice>
          <text/>
          <element name="bold">
            <ref name="inline"/>
          </element>
          <element name="italic">
            <ref name="inline"/>
          </element>
          <element name="span">
            <optional>
              <attribute name="style"/>
            </optional>
            <ref name="inline"/>
          </element>
        </choice>
      </zeroOrMore>
    </define>

Toutefois, les références récursives doivent être dans un ``element``. Ainsi, ce qui suit n'*est pas* permis :

::

    <define name="inline">
      <choice>
        <text/>
        <element name="bold">
          <ref name="inline"/>
        </element>
        <element name="italic">
          <ref name="inline"/>
        </element>
        <element name="span">
          <optional>
        <attribute name="style"/>
          </optional>
          <ref name="inline"/>
        </element>
      </choice>
      <optional>
        <ref name="inline"/>
      </optional>
    </define>

Typage des données
==================

Relax NG permet aux motifs de référencer des types de données définis en dehors du schéma, tels que ceux définis par les [`Types de données XML schema du W3C <http://relaxng.org/tutorial-20011203.html#xmlschema-2>`_]. Les implémentations de Relax NG peuvent être différentes dans les types de données pris en charge. On doit utiliser les types de données supportés par l'implémentation que l'on prévoit d'utiliser.

Le modèle de données correspond à une chaîne de caractères qui représente la valeur d'un type de données nommé. L'attribut ``datatypeLibrary`` contient un URI identifiant la bibliothèque de types de données utilisée. La bibliothèque de type de données définie par les [`Types de données XML schema du W3C <http://relaxng.org/tutorial-20011203.html#xmlschema-2>`_] serait identifiée par l'URI ``http://www.w3.org/2001/XMLSchema-datatypes``. L'attribut ``type`` spécifie le nom du type de données dans la bibliothèque identifiée par l'attribut ``datatypeLibrary``. Par exemple, si une implémentation  de Relax NG doit prendre en charge les les [`Types de données XML schema du W3C <http://relaxng.org/tutorial-20011203.html#xmlschema-2>`_], on peut utiliser :

::

    <element name="number">
      <data type="integer" datatypeLibrary="http://www.w3.org/2001/XMLSchema-datatypes"/>
    </element>

Il est peu pratique de spécifier l'attribut ``datatypeLibrary`` sur chaque élément ``data``. Relax NG permet heureusement à l'attribut ``datatypeLibrary`` d'être hérité. L'attribut ``datatypeLibrary`` peut être précisé sur chaque élément Relax NG. Si un élément ``data`` n'a pas d'attribut ``datatypeLibrary``, il va utiliser la valeur du plus proche parent qui a un attribut ``datatypeLibrary``. Typiquement, l'attribut ``datatypeLibrary`` est spécifié sur l'élément racine du schéma Relax NG. Par exemple :

::

    <element name="point" datatypeLibrary="http://www.w3.org/2001/XMLSchema-datatypes">
      <element name="x">
        <data type="double"/>
      </element>
      <element name="y">
        <data type="double"/>
      </element>
    </element>

Si les enfants d'un élément ou d'un attribut correspondent à un modèle ``data``, alors le contenu complet de l'élément ou l'attribut doit correspondre à ce ``data``. Il n'est pas autorisé d'avoir un modèle qui permet à une partie du contenu de correspondre à un motif de données, et une autre partie de correspondre à un autre motif. Par exemple, le modèle suivant n'est pas autorisé :

::

    <element name="bad">
      <data type="int"/>
      <element name="note">
        <text/>
      </element>
    </element>

Cependant, ceci conviendrait :

::

    <element name="ok">
      <data type="int"/>
      <attribute name="note">
        <text/>
      </attribute>
    </element>

Notez que cette restriction ne s'applique pas au modèle ``text``.

Les datatypes peut avoir des paramètres. Par exemple, une chaîne de type de données peut avoir un paramètre controlant la longueur de la chaîne. Les paramètres applicables à n'importe quel datatype particulier sont déterminés par le vocabulaire du datatype. Les paramètres sont spécifiés par l'ajout d'un ou plusieurs éléments ``param`` en tant qu'enfants de l'élément ``data``. Par exemple, ce qui suit contraint l'élément ``e-mail`` à contenir une chaîne d'au plus 127 caractères :

::

    <element name="email">
      <data type="string">
        <param name="maxLength">127</param>
      </data>
    </element>

Les énumérations
================

Beaucoup de vocabulaires de langages de balisage ont des attributs dont la valeur est contrainte à être une valeur présente dans un ensemble de valeurs définies. Le modèle ``value`` correspond à une chaîne qui a une valeur spécifiée. Par exemple :

::

    <element name="card">
      <attribute name="name"/>
      <attribute name="email"/>
      <attribute name="preferredFormat">
        <choice>
          <value>html</value>
          <value>text</value>
        </choice>
      </attribute>
    </element>

permet à l'attribut ``preferredFormat`` d'avoir la valeur ``html`` ou ``text``. Cela correspond à la DTD :

::

    <!DOCTYPE card [
    <!ELEMENT card EMPTY>
    <!ATTLIST card
      name CDATA #REQUIRED
      email CDATA #REQUIRED
      preferredFormat (html|text) #REQUIRED>
    ]>

Le modèle ``value`` ne se limite pas à des valeurs d'attributs. Par exemple, le modèle suivant est autorisé:

::

    <element name="card">
      <element name="name">
        <text/>
      </element>
      <element name="email">
        <text/>
      </element>
      <element name="preferredFormat">
        <choice>
          <value>html</value>
          <value>text</value>
        </choice>
      </element>
    </element>

L'interdiction correspondant à un modèle ``data`` d'une partie seulement du contenu d'un élément s'applique également à des modèles ``value``.

Par défaut, le modèle ``value`` examinera la chaîne dans le modèle pour correspondre à la chaîne dans le document si les deux chaînes sont les mêmes après que les espaces dans les deux chaînes aient été normalisés. La normalisation des espaces enlève les espaces avant et après, et réduit les suites de plusieurs espaces à un unique caractère espace. Cela correspond au comportement d'un analyseur XML pour un attribut déclaré comme non CDATA. Ainsi, le motif ci-dessus correspond aux modèles suivants :

::

<card name="John Smith" email="js@example.com" preferredFormat="html"/>
<card name="John Smith" email="js@example.com" preferredFormat="  html  "/>

La manière dont le motif ``value`` compare la chaîne de configuration avec la chaîne document peut être commandée en spécifiant un attribut ``type`` et éventuellement un attribut ``datatypeLibrary``, qui identifient un type de données de la même manière que pour la configuration de ``data``. La chaîne du modèle ne correspond à la chaîne du document que s'ils représentent tous les deux la même valeur du type de données spécifié. Ainsi, alors que le modèle ``data`` correspond à une valeur arbitraire d'un type de données, le modèle ``value`` correspond à une valeur spécifique d'un type de données.

Si il n'existe aucun élément ancêtre avec un élément ``datatypeLibrary``, la bibliothèque de type de données attribuée par défaut est une bibliothèque intégrée au datatype de Relax NG. Celle-ci offre deux types de données, ``string`` et ``token``. Le datatype prédéfini ``token`` correspond au comportement par défaut de la comparaison du motif ``value``. Le datatype ``string`` compare les chaînes sans aucune normalisation des espaces (autres que la fin de ligne et que la normalisation de la valeur d'attribut, automatiquement réalisés par XML). Par exemple :

::

    <element name="card">
      <attribute name="name"/>
      <attribute name="email"/>
      <attribute name="preferredFormat">
        <choice>
          <value type="string">html</value>
          <value type="string">text</value>
        </choice>
      </attribute>
    </element>

Ne *correspond pas* à :

::

    <card name="John Smith" email="js@example.com" preferredFormat="  html  "/>

Listes
======

Le motif ``list`` correspond à une séquence de tokens séparés par des espaces; il contient un motif auquel la séquence de tokens individuels doit correspondre. Le modèle ``list`` divise une chaîne en une liste de chaînes, et fait correspondre la liste résultante de chaînes contre le modèle à l'intérieur du modèle ``list``.

Par exemple, supposons que nous voulons avoir un élément ``vector`` qui contient deux nombres à virgule flottante, séparés par des espaces. Nous pourrions utiliser ``list`` comme suit :

::

    <element name="vector">
      <list>
        <data type="float"/>
        <data type="float"/>
      </list>
    </element>

Ou supposons que nous voulions que l'élément ``vector`` contienne une liste d'un ou plusieurs nombres à virgule flottante, séparés par des espaces :

::

    <element name="vector">
      <list>
        <oneOrMore>
          <data type="double"/>
        </oneOrMore>
      </list>
    </element>

Ou supposons que nous voulions un élément chemin ``path`` contenant un nombre pair de nombres à virgule flottante :

::

    <element name="path">
      <list>
        <oneOrMore>
          <data type="double"/>
          <data type="double"/>
        </oneOrMore>
      </list>
    </element>

Entrelacement
=============

Le motif d'entrelacement ``interleave`` permet aux éléments enfants d'exister dans n'importe quel ordre. Par exemple, pour permettre à l'élément ``card`` de contenir les éléments ``name`` et ``email`` dans n'importe quel ordre :

::

    <element name="addressBook">
      <zeroOrMore>
        <element name="card">
          <interleave>
            <element name="name">
              <text/>
            </element>
            <element name="email">
              <text/>
            </element>
          </interleave>
        </element>
      </zeroOrMore>
    </element>

Le motif est appelé ``interleave`` en raison de la façon dont il fonctionne avec des modèles qui contiennent plus d'un élément. Supposons que nous voulons écrire un modèle pour l'élément HTML ``head`` qui exige au moins un élément titre ``title``, au maximum un seul élément optionnel ``base`` et zéro ou plusieurs éléments ``style``, ``script``, ``link`` et ``meta``. Supposons que nous écrivons un modèle de grammaire ``grammar`` qui a une définition pour chaque Elément. Nous pourrions alors définir le modèle ``head`` comme suit :

::

    <define name="head">
      <element name="head">
        <interleave>
          <ref name="title"/>
          <optional>
            <ref name="base"/>
          </optional>
          <zeroOrMore>
            <ref name="style"/>
          </zeroOrMore>
          <zeroOrMore>
            <ref name="script"/>
          </zeroOrMore>
          <zeroOrMore>
            <ref name="link"/>
          </zeroOrMore>
          <zeroOrMore>
            <ref name="meta"/>
          </zeroOrMore>
        </interleave>
      </element>
    </define>

Supposons que nous ayons eu un élément ``head`` qui contenait un élément ``meta``, suivi d'un élément ``title``, suivi d'un autre élément ``meta``. Ceci correspondrait au modèle, car il comprend un entrelacement d'une séquence de deux éléments ``meta``, qui correspondent au motif enfant

::

    <zeroOrMore>
        <ref name="meta"/>
    </zeroOrMore>

et d'une séquence d'un élément ``title``, qui correspond au motif enfant

::

    <ref name="title"/>

La sémantique du motif ``interleave`` est lorsqu'une séquence d'éléments correspond au motif ``interleave`` si elle est un entrelacement de séquences qui correspondent aux motifs enfants du motif ``interleave``. Notons que ceci est différent du connecteur ``&`` en SGML : ``A* & B`` correspond à la séquence d'éléments ``A A B`` ou à la séquence d'éléments ``B A A`` mais pas à la séquence d'éléments ``A B A``.


Un cas particulier d'``interleave`` est très fréquent : l'entrelacement ``<text/> `` avec un motif ``p`` représente un modèle qui correspond aux correspondances de ``p``, mais qui permet également aux caractères d'exister en tant qu'enfants. L'élément ``mixed`` en est un raccourci.

::
    <mixed> p </mixed>

est un raccourci de :

::

    <interleave> <text/> p </interleave>

Modularité
==========

Référencement de modèles externes
---------------------------------

Le modèle ``externalRef`` peut être utilisé pour faire référence à un modèle défini dans un fichier séparé. L'élément ``externalRef`` a un attribut ``href`` obligatoire qui spécifie l'URL d'un fichier contenant le motif. L'``externalRef`` correspond si le motif contenu dans l'URL spécifiée correspond. Supposons par exemple qu'on ait un modèle Relax NG qui corresponde à du contenu HTML en ligne, stocké dans le fichier ``inline.rng`` :


::

    <grammar>
      <start>
        <ref name="inline"/>
      </start>

      <define name="inline">
        <zeroOrMore>
          <choice>
            <text/>
            <element name="code">
              <ref name="inline"/>
            </element>
            <element name="em">
              <ref name="inline"/>
            </element>
            <!-- etc -->
          </choice>
        </zeroOrMore>
      </define>
    </grammar>

Ensuite, nous pourrions permettre à l'élément ``note`` de contenir des balises HTML en ligne en utilisant ``externalRef`` comme suit: 

::

    <element name="addressBook">
      <zeroOrMore>
        <element name="card">
          <element name="name">
            <text/>
          </element>
          <element name="email">
            <text/>
          </element>
          <optional>
            <element name="note">
              <externalRef href="inline.rng"/>
        </element>
          </optional>
        </element>
      </zeroOrMore>
    </element>

For another example, suppose you have two RELAX NG patterns stored in files pattern1.rng and pattern2.rng. Then the following is a pattern that matches anything matched by either of those patterns:

Prenons un autre exemple, supposons que nous disposons de deux modèles Relax NG, stockés dans des fichiers ``pattern1.rng`` et ``pattern2.rng``. Alors ce qui suit est un modèle qui correspond aux deux :

::

    <choice>
      <externalRef href="pattern1.rng"/>
      <externalRef href="pattern2.rng"/>
    </choice>

Combiner les définitions
------------------------

Si une grammaire contient plusieurs définitions avec le même nom, alors les définitions doivent préciser comment elles doivent être combinées en une seule définition en utilisant l'attribut ``combine``. L'attribut ``combine`` peut avoir les valeurs ``choice`` ou ``interleave``. Par exemple :

::

    <define name="inline.class" combine="choice">
      <element name="bold">
        <ref name="inline"/>
      </element>
    </define>

    <define name="inline.class" combine="choice">
      <element name="italic">
        <ref name="inline"/>
      </element>
    </define>

équivaut à :

::

    <define name="inline.class">
      <choice>
        <element name="bold">
          <ref name="inline"/>
        </element>
        <element name="italic">
          <ref name="inline"/>
        </element>
      </choice>
    </define>

Lorsque l'on combine les attributs, ``combine="interleave"`` est généralement utilisé. Par exemple :

::

    <grammar>

      <start>
        <element name="addressBook">
          <zeroOrMore>
        <element name="card">
          <ref name="card.attlist"/>
        </element>
          </zeroOrMore>
        </element>
      </start>

      <define name="card.attlist" combine="interleave">
        <attribute name="name">
          <text/>
        </attribute>
      </define>

      <define name="card.attlist" combine="interleave">
        <attribute name="email">
          <text/>
        </attribute>
      </define>

    </grammar>

équivaut à :

::

    <grammar>

      <start>
        <element name="addressBook">
          <zeroOrMore>
        <element name="card">
          <ref name="card.attlist"/>
        </element>
          </zeroOrMore>
        </element>
      </start>

      <define name="card.attlist">
        <interleave>
          <attribute name="name">
        <text/>
          </attribute>
          <attribute name="email">
        <text/>
          </attribute>
        </interleave>
      </define>

    </grammar>

qui est équivalent à :

::

    <grammar>

      <start>
        <element name="addressBook">
          <zeroOrMore>
        <element name="card">
          <ref name="card.attlist"/>
        </element>
          </zeroOrMore>
        </element>
      </start>

      <define name="card.attlist">
        <group>
          <attribute name="name">
        <text/>
          </attribute>
          <attribute name="email">
        <text/>
          </attribute>
        </group>
      </define>

    </grammar>

Combiner les attributs avec ``interleave`` a le même effet que de les combiner avec ``group``.
C'est une erreur d'avoir deux définitions du même nom qui spécifient des valeurs différentes à ``combine``. Notez que l'ordre des définitions au sein d'une grammaire n'est pas significatif.
De multiples éléments ``start`` peuvent être combinés de la même manière que les définitions multiples.

Fusion de grammaires
--------------------

L'élément ``include`` permet aux grammaires d'être fusionnées ensemble. Un modèle grammar`` peut-être inclure (via ``include``) des éléments en tant qu'enfants. Un élément ``include`` a un attribut ``href`` obligatoire qui spécifie l'URL d'un fichier contenant un modèle de grammaire ``grammar``. Les définitions figurant dans le modèle de grammaire référencé seront incluses dans le modèle de grammaire contenant l'élément ``include``.

L'attribut ``combine`` est particulièrement utile en conjonction avec ``include``. Par exemple, supposons qu'un modèle Relax NG ``inline.rng`` fournit un modèle pour un contenu en ligne, modèle qui définit les éléments ``bold`` et ``italic`` arbitrairement imbriqués :

::

    <grammar>

      <define name="inline">
        <zeroOrMore>
          <ref name="inline.class"/>
        </zeroOrMore>
      </define>

      <define name="inline.class">
        <choice>
          <text/>
          <element name="bold">
            <ref name="inline"/>
          </element>
          <element name="italic">
            <ref name="inline"/>
          </element>
        </choice>
      </define>

    </grammar>

Un autre motif Relax NG pourrait utiliser ``inline.rng`` et ajouter ``code`` et ``em`` à l'ensemble des éléments en ligne, comme suit :

::

    <grammar>

      <include href="inline.rng"/>

      <start>
        <element name="doc">
          <zeroOrMore>
        <element name="p">
          <ref name="inline"/>
        </element>
          </zeroOrMore>
        </element>
      </start>

      <define name="inline.class" combine="choice">
        <choice>
          <element name="code">
            <ref name="inline">
          </element>
          <element name="em">
            <ref name="inline">
          </element>
        </choice>
      </define>
      
    </grammar>

Ce serait l'équivalent de :

::

    <grammar>

      <define name="inline">
        <zeroOrMore>
          <ref name="inline.class"/>
        </zeroOrMore>
      </define>

      <define name="inline.class">
        <choice>
          <text/>
          <element name="bold">
            <ref name="inline"/>
          </element>
          <element name="italic">
            <ref name="inline"/>
          </element>
        </choice>
      </define>

      <start>
        <element name="doc">
          <zeroOrMore>
            <element name="p">
              <ref name="inline"/>
            </element>
          </zeroOrMore>
        </element>
      </start>

      <define name="inline.class" combine="choice">
        <choice>
          <element name="code">
            <ref name="inline">
          </element>
          <element name="em">
            <ref name="inline">
          </element>
        </choice>
      </define>
    
    </grammar>

qui est aussi équivalent à :

::

    <grammar>

      <define name="inline">
        <zeroOrMore>
          <ref name="inline.class"/>
        </zeroOrMore>
      </define>

      <define name="inline.class">
        <choice>
          <text/>
          <element name="bold">
            <ref name="inline"/>
          </element>
          <element name="italic">
            <ref name="inline"/>
          </element>
          <element name="code">
            <ref name="inline">
          </element>
          <element name="em">
            <ref name="inline">
          </element>
        </choice>
      </define>

      <start>
        <element name="doc">
          <zeroOrMore>
            <element name="p">
                <ref name="inline"/>
            </element>
          </zeroOrMore>
        </element>
      </start>

    </grammar>

Notez qu'il est autorisé pour l'une des définitions d'un nom d'omettre l'attribut ``combine``. Cependant, c'est considéré comme une erreur si il y a plus d'une définition qui le fait.

Le modèle ``notAllowed`` est utile lors de la fusion des grammaires. Le modèle ``notAllowed`` ne correspond jamais à quoi que ce soit. Tout comme l'ajout de ``empty`` à un ``group`` ne change rien, l'ajout de ``notAllowed`` à un ``choice`` ne fait aucune différence. Il est généralement utilisé pour permettre à un modèle inclus de spécifier des options supplémentaires avec ``combine="choice"``. Par exemple, si ``inline.rng`` était écrit comme ceci :

::

    <grammar>

      <define name="inline">
        <zeroOrMore>
          <choice>
            <text/>
            <element name="bold">
              <ref name="inline"/>
            </element>
            <element name="italic">
              <ref name="inline"/>
            </element>
            <ref name="inline.extra"/>
          </choice>
        </zeroOrMore>
      </define>

      <define name="inline.extra">
        <notAllowed/>
      </define>

    </grammar>

... il pourrait alors être personnalisé pour permettre des éléments ``code`` et ``em`` en ligne comme suit :

::

    <grammar>

      <include href="inline.rng"/>

      <start>
        <element name="doc">
          <zeroOrMore>
            <element name="p">
              <ref name="inline"/>
            </element>
          </zeroOrMore>
        </element>
      </start>

      <define name="inline.extra" combine="choice">
        <choice>
          <element name="code">
            <ref name="inline">
          </element>
          <element name="em">
            <ref name="inline">
          </element>
        </choice>
      </define>
      
    </grammar>

Remplacement des définitions
----------------------------

Relax NG permet des éléments définis ``define`` à mettre à l'intérieur de l'élément ``include`` pour indiquer que l'on doit remplacer les définitions dans le modèle ``grammar`` inclus.

Supposons que le fichier ``addressBook.rng`` contienne :

::

    <grammar>

      <start>
        <element name="addressBook">
          <zeroOrMore>
            <element name="card">
              <ref name="cardContent"/>
            </element>
          </zeroOrMore>
        </element>
      </start>

      <define name="cardContent">
        <element name="name">
          <text/>
        </element>
        <element name="email">
          <text/>
        </element>
      </define>

    </grammar>

Supposons que nous voulions modifier ce modèle afin que l'élément ``card`` contienne un élément ``emailAddress`` au lieu d'un élément ``email``. Nous pourrions alors remplacer la définition de ``cardContent`` comme suit:

::

    <grammar>

      <include href="addressBook.rng">

        <define name="cardContent">
          <element name="name">
            <text/>
          </element>
          <element name="emailAddress">
            <text/>
          </element>
        </define>

      </include>

    </grammar>

qui serait équivalent à :

::

    <grammar>

      <start>
        <element name="addressBook">
          <zeroOrMore>
            <element name="card">
              <ref name="cardContent"/>
            </element>
          </zeroOrMore>
        </element>
      </start>

      <define name="cardContent">
        <element name="name">
          <text/>
        </element>
        <element name="emailAddress">
          <text/>
        </element>
      </define>

    </grammar>

Un élément ``include`` peut aussi contenir un élément ``start``, qui remplace ``start`` dans le modèle original.

Namespaces (Espaces de noms)
============================

Relax NG inclut également la gestion des espaces de noms. Ainsi, il considère qu'un élément ou un attribut dispose à la fois d'un nom local et d'une URI dans un espace de noms, qui, ensemble, constituent le nom de cet élément ou de cet attribut.

Utilisation de l'attribut ``ns``
--------------------------------

Le motif ``element`` utilise un attribut ``ns`` pour spécifier l'espace de noms URI des éléments qui correspondent. Par exemple :

::

    <element name="foo" ns="http://www.example.com">
      <empty/>
    </element>

correspond aux exemples suivants :

::

    <foo xmlns="http://www.example.com"/>
    <e:foo xmlns:e="http://www.example.com"/>
    <example:foo xmlns:example="http://www.example.com"/>

mais à aucun des exemples ci-dessous :

::

    <foo/>
    <e:foo xmlns:e="http://WWW.EXAMPLE.COM"/>
    <example:foo xmlns:example="http://www.example.net"/>

Une valeur d'une chaîne vide pour l'attribut ``ns`` indique un espace de noms URI nul ou absent (tout comme avec l'attribut ``xmlns``). Ainsi, le modèle suivant :

::

    <element name="foo" ns="">
      <empty/>
    </element>

correspond aux exemples suivants :

::

    <foo xmlns=""/>
    <foo/>

mais à aucun des exemples ci-dessous :

::

    <foo xmlns="http://www.example.com"/>
    <e:foo xmlns:e="http://www.example.com"/>

It is tedious and error-prone to specify the ns attribute on every element, so RELAX NG allows it to be defaulted. If an element pattern does not specify an ns attribute, then it defaults to the value of the ns attribute of the nearest ancestor that has an ns attribute, or the empty string if there is no such ancestor. Thus,

Il est fastidieux et source d'erreurs de spécifier l'attribut ``ns`` sur chaque ``element``, Relax NG permet cependant de mettre une valeur par défaut. Si un ``element`` ne précise pas d'attribut ``ns``, il prend par défaut la valeur de l'attribut ``ns`` du parent le plus proche qui possède un attribut ``ns``, ou une chaîne vide si un tel ancêtre n'existe pas. Ainsi :

::

    <element name="addressBook">
      <zeroOrMore>
        <element name="card">
          <element name="name">
            <text/>
          </element>
          <element name="email">
            <text/>
          </element>
        </element>
      </zeroOrMore>
    </element>

est équivalent à :

::

    <element name="addressBook" ns="">
      <zeroOrMore>
        <element name="card" ns="">
          <element name="name" ns="">
            <text/>
          </element>
          <element name="email" ns="">
            <text/>
          </element>
        </element>
      </zeroOrMore>
    </element>

et :

::

    <element name="addressBook" ns="http://www.example.com">
      <zeroOrMore>
        <element name="card">
          <element name="name">
            <text/>
          </element>
          <element name="email">
            <text/>
          </element>
        </element>
      </zeroOrMore>
    </element>

est équivalent à :

::

    <element name="addressBook" ns="http://www.example.com">
      <zeroOrMore>
        <element name="card" ns="http://www.example.com">
          <element name="name" ns="http://www.example.com">
            <text/>
          </element>
          <element name="email" ns="http://www.example.com">
            <text/>
          </element>
        </element>
      </zeroOrMore>
    </element>



Le modèle ``attribut``  pren également un attribut ``ns``. Cependant, il ya une différence dans la façon dont il est géré par défaut. C'est en raison du fait que la recommandation des espaces de noms en XML n'applique pas l'espace de noms par défaut aux attributs. Si un attribut ``ns`` n'est pas spécifié sur le modèle ``attribute``, alors il prend par défaut la chaîne vide. Ainsi :

::

    <element name="addressBook" ns="http://www.example.com">
      <zeroOrMore>
        <element name="card">
          <attribute name="name"/>
          <attribute name="email"/>
        </element>
      </zeroOrMore>
    </element>

est équivalent à :

::

    <element name="addressBook" ns="http://www.example.com">
      <zeroOrMore>
        <element name="card" ns="http://www.example.com">
          <attribute name="name" ns=""/>
          <attribute name="email" ns=""/>
        </element>
      </zeroOrMore>
    </element>

et correspondra alors à :

::

    <addressBook xmlns="http://www.example.com">
      <card name="John Smith" email="js@example.com"/>
    </addressBook>

ou :

::

    <example:addressBook xmlns:example="http://www.example.com">
      <example:card name="John Smith" email="js@example.com"/>
    </example:addressBook>

mais pas à :

::

    <example:addressBook xmlns:example="http://www.example.com">
      <example:card example:name="John Smith" example:email="js@example.com"/>
    </example:addressBook>

Qualification des noms
----------------------

Quand un motif correspond à des éléments et des attributs de plusieurs espaces de noms, utiliser l'attribut ``ns`` demanderait de répéter l'espace de noms URI dans différents endroits dans le modèle. C'est souce d'erreurs et difficile à maintenir. Relax NG permet alors également aux motifs ``element`` et ``attribute`` d'utiliser un préfixe dans la valeur de l'attribut ``name`` pour spécifier l'espace de noms URI adéquat. Dans ce cas, le préfixe spécifie l'espace de noms URI auquel ce préfixe est lié grace aux déclarations d'espaces de noms dans le périmètre défini des modèles ``element`` ou ``attribute``. Ainsi :

::

    <element name="ab:addressBook" xmlns:ab="http://www.example.com/addressBook"
                                   xmlns:a="http://www.example.com/address">
      <zeroOrMore>
        <element name="ab:card">
          <element name="a:name">
            <text/>
          </element>
          <element name="a:email">
            <text/>
          </element>
        </element>
      </zeroOrMore>
    </element>

est équivalent à :

    <element name="addressBook" ns="http://www.example.com/addressBook">
      <zeroOrMore>
        <element name="card" ns="http://www.example.com/addressBook">
          <element name="name" ns="http://www.example.com/address">
            <text/>
          </element>
          <element name="email" ns="http://www.example.com/address">
            <text/>
          </element>
        </element>
      </zeroOrMore>
    </element>

Si un préfixe est spécifié dans la valeur de l'attribut ``name`` d'un element`` ou d'un ``attribute``, alors ce préfixe détermine l'espace de noms URI des éléments ou des attributs qui seront appariés par ce modèle, indépendamment de la valeur d'un attribut ``ns``.

Notez que l'espace de noms XML par défaut (tel que spécifié par l'attribut xmlns) n'est pas utilisé dans la détermination de l'espace de noms URI des éléments et des attributs correspondants aux modèles ``element`` et ``attribute``.

Classes de noms
===============

Normalement, le nom de l'élément qui doit correspondre à un ``element`` est spécifié par un attribut ``name``. Un ``element`` peut également commencer avec un élément spécifiant un nom de classe. Dans ce cas, le motif ``element`` ne correspond à un élément que si le nom de l'élément est un élément du nom de classe. Le nom de classe le plus simple est ``anyName``, dont tous les noms appartiennent, quel que soit le nom local et l'URI. Par exemple, le schéma suivant correspond à tout document XML bien formé :

::

    <grammar>

      <start>
        <ref name="anyElement"/>
      </start>

      <define name="anyElement">
        <element>
          <anyName/>
          <zeroOrMore>
        <choice>
          <attribute>
            <anyName/>
          </attribute>
          <text/>
          <ref name="anyElement"/>
        </choice>
          </zeroOrMore>
        </element>
      </define>

    </grammar>

Le nom de classe `` nsName`` contient n'importe quel nom avec l'espace de noms URI spécifié par l'attribut ``ns``, défini par défaut, de la même manière que l'attribut ``ns`` sur le motif ``element``.
Le nom de classe `` choice`` correspond à n'importe quel nom qui est membre d'un nom de classe de ses enfants.
Les noms de classe ``anyName`` et ``nsName`` peuvent contenir une clause d'exception ``except``. Par exemple :

::

    <element name="card" ns="http://www.example.com">
      <zeroOrMore>
        <attribute>
          <anyName>
            <except>
              <nsName/>
              <nsName ns=""/>
            </except>
          </anyName>
        </attribute>
      </zeroOrMore>
      <text/>
    </element>

permettrait à l'élément ``card`` d'avoir une quelconque quantité d'attributs définis dans des espace de noms, à condition qu'ils aient été qualifiés avec un espace de noms autre que celui de l'élément ``card``.

Notez qu'un ``attribute`` correspond à un attribut unique, même si il a un nom de classe qui contient plusieurs noms. Pour faire correspondre zéro ou plusieurs attributs, l'élément ``zeroOrMore`` doit être utilisé.

Le nom de classe ``name`` contient un seul nom. Le contenu de l'élément ``name`` spécifie le nom de la même manière que l'attribut ``name`` du motif ``element``. L'attribut ``ns`` spécifie l'espace de noms URI de la même manière que pour le motif ``element``.

Certains langages de description de format ont un concept de validation de type *lax*, où un élément ou un attribut est validé par rapport à une définition seulement si il en existe une. Nous pouvons implémenter ce concept dans Relax NG avec des classes de noms qui utilisent l'exception ``except`` et le nom ``name``. Supposons, par exemple, que nous ayons voulu permettre à un élément d'avoir un attribut avec un nom défini, mais que nous ayons également voulu faire en sorte que s'il y avait un attribut ``xml:space``, il prenne la valeur ``default`` ou ``preserve``. On ne pourrait alors pas utiliser :

::

    <element name="example">
      <zeroOrMore>
        <attribute>
          <anyName/>
        </attribute>
      </zeroOrMore>
      <optional>
        <attribute name="xml:space">
          <choice>
            <value>default</value>
            <value>preserve</value>
          </choice>
        </attribute>
      </optional>
    </element>

car un attribut ``xml:space`` avec une valeur autre ``default`` ou ``preserve`` correspondrait à :

::

    <attribute>
      <anyName/>
    </attribute>

même si elle ne correspondrait pas à :

::

    <attribute name="xml:space">
      <choice>
        <value>default</value>
        <value>preserve</value>
      </choice>
    </attribute>

La solution est d'utiliser le ``name`` en même temps que ``except`` :

::

    <element name="example">
      <zeroOrMore>
        <attribute>
          <anyName>
            <except>
              <name>xml:space</name>
            </except>
          </anyName>
        </attribute>
      </zeroOrMore>
      <optional>
        <attribute name="xml:space">
          <choice>
            <value>default</value>
            <value>preserve</value>
          </choice>
        </attribute>
      </optional>
    </element>

Notez que l'élément ``define`` ne peut pas contenir un nom de classe, il ne peut contenir qu'un motif.

Annotations
===========

Si un élément Relax NG dispose d'un attribut ou un élément enfant avec un espace de noms URI autre que l'espace de noms Relax NG, alors cet attribut ou cet élément est ignoré. Ainsi, on peut ajouter des annotations aux modèles Relax NG en utilisant simplement un attribut ou un élément dans un espace de noms distinct :

::

    <element name="addressBook" xmlns="http://relaxng.org/ns/structure/1.0" xmlns:a="http://www.example.com/annotation">
      <zeroOrMore>
        <element name="card">
          <a:documentation>Information about a single email address.</a:documentation>
          <element name="name">
            <text/>
          </element>
          <element name="email">
            <text/>
          </element>
        </element>
      </zeroOrMore>
    </element>

Relax NG fournit également un élément ``div`` qui permet à une annotation d'être appliquée à un groupe de définitions dans une grammaire. Par exemple, on peut vouloir diviser les définitions de la grammaire en modules :

::

    <grammar xmlns:m="http://www.example.com/module">

      <div m:name="inline">

        <define name="code"> pattern </define>
        <define name="em"> pattern </define>
        <define name="var"> pattern </define>

      </div>

      <div m:name="block">

        <define name="p"> pattern </define>
        <define name="ul"> pattern </define>
        <define name="ol"> pattern </define>

      </div>

    </grammar>

Cela permet facilement de générer des variantes de la grammaire basée sur une sélection de modules.

Une spécification, **Relax NG DTD Compatibility** [`Compatibility <http://relaxng.org/tutorial-20011203.html#compat>`_], définit des annotations pour implémenter certaines fonctionnalités de la DTD d'XML.

Grammaires imbriquées
=====================

Il n'existe aucune restriction concernant les comportements d'imbrication des grammaires. Un modèle ``ref`` fait référence à une définition de l'ancêtre ``grammar`` le plus proche. Il existe également un élément ``parentRef`` qui échappe à la grammaire en cours et fait référence à une définition du plus proche parent de la grammaire en cours.

Imaginez le problème d'écrire un modèle pour des tableaux. Le modèle pour les tableaux tient seulement compte de la structure des tables, il ne se soucie pas de ce qui se passe dans une cellule de tableau. Tout d'abord, nous créons un modèle Relax NG ``table.rng`` comme suit :

::

    <grammar>

    <define name="cell.content">
      <notAllowed/>
    </define>

    <start>
      <element name="table">
        <oneOrMore>
          <element name="tr">
            <oneOrMore>
              <element name="td">
                <ref name="cell.content"/>
              </element>
            </oneOrMore>
          </element>
        </oneOrMore>
      </element>
    </start>

    </grammar>

Les schémas qui incluent ``table.rng`` doivent redéfinir ``cell.content``. En utilisant un modèle de grammaire ``grammar`` imbriquée contenant un motif ``parentRef``, le motif inclus peut redéfinir ``cell.content`` pour le définir en tant que modèle dans celui de la grammaire. De ce fait, on réalise de manière efficace l'importation d'un modèle de la grammaire des parents vers la grammaire des enfants qui en héritent :

::

    <grammar>

    <start>
      <element name="doc">
        <zeroOrMore>
          <choice>
            <element name="p">
              <ref name="inline"/>
            </element>
            <grammar>
              <include href="table.rng">
                <define name="cell.content">
                  <parentRef name="inline"/>
                </define>
              </include>
            </grammar>
          </choice>
        </zeroOrMore>
      </element>
    </start>

    <define name="inline">
      <zeroOrMore>
        <choice>
          <text/>
          <element name="em">
            <ref name="inline"/>
          </element>
        </choice>
      </zeroOrMore>
    </define>

    </grammar>

Bien sûr, dans un cas trivial comme celui-ci, il n'y a aucun avantage à imbriquer des grammaires : on aurait pu simplement inclure ``table.rng`` à l'intérieur de la grammaire ``grammar`` externe. Toutefois, lorsque la grammaire incluse a de nombreuses définitions, l'imbrication évite la possibilité de conflits de noms entre la grammaire qui reçoit l'inclusion et la grammaire incluse.

Non-restrictions
================

Relax NG ne nécessite pas de patterns pour être «déterministe» ou «sans ambiguïté».

Supposons que nous voulions écrire le carnet d'adresse e-mail en HTML, mais en utilisant les attributs de classe pour spécifier la structure :

::

    <element name="html">
      <element name="head">
        <element name="title">
          <text/>
        </element>
      </element>
      <element name="body">
        <element name="table">
          <attribute name="class">
            <value>addressBook</value>
          </attribute>
          <oneOrMore>
            <element name="tr">
              <attribute name="class">
                <value>card</value>
              </attribute>
              <element name="td">
                <attribute name="class">
                  <value>name</value>
                </attribute>
                <interleave>
                  <text/>
                  <optional>
                    <element name="span">
                      <attribute name="class">
                        <value>givenName</value>
                      </attribute>
                      <text/>
                    </element>
                  </optional>
                  <optional>
                    <element name="span">
                      <attribute name="class">
                        <value>familyName</value>
                      </attribute>
                      <text/>
                    </element>
                  </optional>
                </interleave>
              </element>
              <element name="td">
                <attribute name="class">
                  <value>email</value>
                </attribute>
                <text/>
              </element>
            </element>
          </oneOrMore>
        </element>
      </element>
    </element>

Cela pourrait correspondre par exemple au document XML suivant :

::

    <html>
      <head>
        <title>Example Address Book</title>
      </head>
      <body>
        <table class="addressBook">
          <tr class="card">
            <td class="name">
              <span class="givenName">John</span>
              <span class="familyName">Smith</span>
            </td>
            <td class="email">js@example.com</td>
          </tr>
        </table>
      </body>
    </html>

mais pas à :

::

    <html>
      <head>
        <title>Example Address Book</title>
      </head>
      <body>
        <table class="addressBook">
          <tr class="card">
            <td class="name">
              <span class="givenName">John</span>
              <!-- Note the incorrect class attribute -->
              <span class="givenName">Smith</span>
            </td>
            <td class="email">js@example.com</td>
          </tr>
        </table>
      </body>
    </html>

Pour aller plus loin...
=======================

La spécification définitive de Relax NG est disponible ici : [`RELAX NG <http://relaxng.org/tutorial-20011203.html#spec>`_].

Relax NG fournit une fonctionnalité qui va au-delà des DTD de XML. En particulier, Relax NG :

     + utilise la syntaxe XML pour représenter les schémas
     + prend en charge le typage des données
     + intègre les attributs dans les modèles de contenu
     + prend en charge les espaces de noms XML
     + prend en charge le contenu non ordonné
     + prend en charge les modèles de contenu sensibles au contexte


La validation `ID/IDREF <http://www.liafa.univ-paris-diderot.fr/~carton/Enseignement/XML/Cours/DTD/index.html#sect.dtd.attribute.id>`_ n'est pas fournie par Relax NG, mais elle est cependant fournie par une spécification complémentaire, *Relax NG DTD Compatibility* [`Compatibility <http://relaxng.org/tutorial-20011203.html#compat>`_]. Il est prévu d'intégrer dans de prochaines spécifications le support des références croisées.

RELAX NG ne supporte pas les fonctions des DTD d'XML qui impliquent changer le jeu d'informations d'un document XML. En particulier, Relax NG :

     + ne permet pas de spécifier de valeur par défaut pour les attributs ; cependant, cela est admis par Relax NG DTD Compatibility [Compatibility `<http://relaxng.org/tutorial-20011203.html#compat>`_]
     + ne permet pas de définir des entités
     + ne permet pas de définir de notations
     + ne précise pas si les espaces blancs sont significatifs

De plus, Relax NG ne définit pas de moyen pour un document XML de s'associer lui-même avec un motif Relax NG.

References
==========

Compatibility
    James Clark, Makoto MURATA, editors. `RELAX NG DTD Compatibility <http://www.oasis-open.org/committees/relax-ng/compatibility.html>`_. OASIS, 2001.
RELAX
    MURATA Makoto. `RELAX (Regular Language description for XML) <http://www.xml.gr.jp/relax/>`_. INSTAC (Information Technology Research and Standardization Center), 2001.
RELAX NG
    James Clark, Makoto MURATA, editors. `RELAX NG Specification <http://www.oasis-open.org/committees/relax-ng/spec.html>`_. OASIS, 2001.
TREX
    James Clark. `TREX - Tree Regular Expressions for XML <http://www.thaiopensource.com/trex/>`_. Thai Open Source Software Center, 2001.
W3C XML Schema Datatypes
    Paul V. Biron, Ashok Malhotra, editors. `XML Schema Part 2: Datatypes <http://www.w3.org/TR/xmlschema-2/>`_. W3C (World Wide Web Consortium), 2001.

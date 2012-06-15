========================================================================
Balises XML (XML Tags) supportées par le datatype *XML block* d'*eZ Publish*
========================================================================

.. contents:: Table des matières
   :depth: 4

Résumé
------

Balises XML (XML Tags) supportées par le datatype *XML block* d'*eZ Publish*

Source originale
----------------

Le contenu de ce fichier est une traduction de la `documentation eZ Publish sur les balises XML supportées par le datatype XML Block <http://doc.ez.no/eZ-Publish/Technical-manual/4.x/Reference/XML-tags>`_ diffusée sous la licence `GNU Free Documentation License <http://www.gnu.org/licenses/fdl.html>`_.

Description
-----------

Par défaut, le datatype *XML block* supporte les balises XML suivantes :

-  **Headings** / `En-têtes ou Titres <#titres>`_
-  **Bold text** / `Texte gras <#texte_gras>`_
-  **Italic text** / `Texte italique <#texte_italique>`_
-  **Unformatted text** / `Texte non formaté <#texte_non_formate>`_
-  **Lists** / `Listes <#listes>`_
-  **Tables** / `Tableaux <#tableaux>`_
-  **Hyperlinks** / `Hyperliens <#hyperliens>`_
-  **Anchors** / `Ancres <#ancres>`_
-  **Object embedding** / `Insertion d'objets <#insertion_objets>`_
-  **Custom tags** / `Balises personnalisées <#balises_personnalisees>`_
-  **Paragraphs** / `Paragraphes <#paragraphes>`_

En tetes ou titres
------------------

**[Headings]** : On ajoute des **en-têtes ou des titres** avec les balises *h* ou *header* et le paramètre *level* dont la valeur variant de 1 à 6 indique la taille (le niveau) de l'en-tête (ou du titre). Le paramètre optionnel *class* permet d'utiliser une classe CSS et le paramètre optionnel *anchor\_name* de lier une ancre au titre. Utilisation :

::

    <h [level=""] [class=""] [anchor_name=""] [custom_parameter="" [...] ]>Example</h>

ou

::

    <header [level=""] [class=""] [anchor_name=""] [custom_parameter="" [...] ]>Example</header>

Les paramètres personnalisés sont optionnels et leurs noms doivent être définis dans le tableau `CustomAttributes[] <http://doc.ez.no/eZ-Publish/Technical-manual/4.x/Reference/Configuration-files/content.ini/name_of_XML_tag/CustomAttributes>`_ de la section **[header]** de l'une des surcharges du fichier de configuration **content.ini**. Lorsqu'il est utilisé, un tel paramètre est disponible en tant que variable de template dont le nom est identique à celui spécifié dans la balise même.

Par défaut, les niveaux indiqués sont incrémentés de 1, c'est à dire qu'un titre de niveau 1 dans le bloc XML devient un titre de niveau 2 dans le code HTML résultant. Ceci est dû au fait que le niveau 1 est réservé au titre/nom principal de l'objet de contenu. Les titres du bloc XML deviennent donc des sous-titres du titre principal. Cependant, ce comportement peut être modifié en créant une surcharge du template */content/datatype/view/ezxmltags/**header.tpl*** (il n'est pas possible de contrôler ce comportement à partir d'un fichier de configuration).

Texte en gras
-------------

**[Bold text]** : Il est possible de mettre du **texte en gras** avec les balises *b* ou *strong* et le paramètre optionnel *class* permet d'utiliser une classe CSS. Utilisation :

::

    <b [class=""] [custom_parameter="" [...] ]>Texte en gras.</b>

ou

::

    <bold [class=""] [custom_parameter="" [...] ]>Texte en gras.</bold>

ou

::

    <strong [class=""] [custom_parameter="" [...] ]>Texte en gras.</strong>

Les paramètres personnalisés sont optionnels et leurs noms doivent être définis dans le tableau `CustomAttributes[] <http://doc.ez.no/eZ-Publish/Technical-manual/4.x/Reference/Configuration-files/content.ini/name_of_XML_tag/CustomAttributes>`_ de la section **[strong]** de l'une des surcharges du fichier de configuration **content.ini**. Lorsqu'il est utilisé, un tel paramètre est disponible en tant que variable de template dont le nom est identique à celui spécifié dans la balise même.

Texte en italique/emphase
------------------------

**[Italic text]** : Il est possible de mettre du **texte en italique/emphase** avec les balises *i*, *em* ou *emphasize* et le paramètre optionnel *class* permet d'utiliser une classe CSS. Utilisation :

::

    <i [class=""] [custom_parameter="" [...] ]>Emphasized text.</i>

ou

::

    <em [class=""] [custom_parameter="" [...] ]>Emphasized text.</em>

ou

::

    <emphasize [class=""] [custom_parameter="" [...] ]>Emphasized text.</emphasize>


Les paramètres personnalisés sont optionnels et leurs noms doivent être définis dans le tableau `CustomAttributes[] <http://doc.ez.no/eZ-Publish/Technical-manual/4.x/Reference/Configuration-files/content.ini/name_of_XML_tag/CustomAttributes>`_ de la section **[emphasize]** de l'une des surcharges du fichier de configuration **content.ini**. Lorsqu'il est utilisé, un tel paramètre est disponible en tant que variable de template dont le nom est identique à celui spécifié dans la balise même.

Texte non formaté
-----------------

La balise *literal* permet de créer du **texte non formaté**. Par exemple, pour du code de programmation, du code HTML, du contenu XML, etc... Tout ce qui est inséré dans un bloc literal est retourné/affiché de la même manière (au caractère près) que s'il était placé à l'intérieur des balises literal (le texte résultant sera produit en utilisant les balises HTML *pre*). Le paramètre optionnel *class* permet d'utiliser une classe CSS. Utilisation :

::

    <literal [class=""] [custom_parameter="" [...] ]>Example</literal>

Les paramètres personnalisés sont optionnels et leurs noms doivent être définis dans le tableau `CustomAttributes[] <http://doc.ez.no/eZ-Publish/Technical-manual/4.x/Reference/Configuration-files/content.ini/name_of_XML_tag/CustomAttributes>`_ de la section **[literal]** de l'une des surcharges du fichier de configuration **content.ini**. Lorsqu'il est utilisé, un tel paramètre est disponible en tant que variable de template dont le nom est identique à celui spécifié dans la balise même.

Listes
------

Les balises *ol*, *ul* et *li* sont employées, exactement comme en HTML, pour créer des **listes**. Celles-ci peuvent être imbriquées et le paramètre optionnel *class* permet d'utiliser une classe CSS. Les exemples suivants illustrent la création de listes ordonnées et non ordonnées.

Listes ordonnées
~~~~~~~~~~~~~~~~

**[Ordered lists]**

::

    <ol [class=""] [custom_parameter="" [...] ]>
        <li [class=""] [custom_parameter="" [...] ]>Element 1</li>
        <li [class=""] [custom_parameter="" [...] ]>Element 2</li>
        <li [class=""] [custom_parameter="" [...] ]>Element 3</li>
    </ol>

Listes non ordonnées
~~~~~~~~~~~~~~~~~~~~

**[Unordered lists]**

::

    <ul [class=""] [custom_parameter="" [...] ]>
        <li [class=""] [custom_parameter="" [...] ]>Element 1</li>
        <li [class=""] [custom_parameter="" [...] ]>Element 2</li>
        <li [class=""] [custom_parameter="" [...] ]>Element 3</li>
    </ul>

Les paramètres personnalisés sont optionnels et leurs noms doivent être définis dans le tableau `CustomAttributes[] <http://doc.ez.no/eZ-Publish/Technical-manual/4.x/Reference/Configuration-files/content.ini/name_of_XML_tag/CustomAttributes>`_ des sections **[ol]**, **[ul]** et **[li]** de l'une des surcharges du fichier de configuration **content.ini**. Lorsqu'il est utilisé, un tel paramètre est disponible en tant que variable de template dont le nom est identique à celui spécifié dans la balise même.

Tableaux
--------

Tout comme en HTML, les balises *table*, *tr*, *th* et *td* servent à créer des tableaux. Il est possible de créer des tableaux imbriqués.

::

    <table [class=""] [border=""] [width=""] [custom_parameter="" [...] ]>
    ...
    </table>

Les paramètres *class*, *border* et *width* sont optionnels et le paramètre *class* permet d'utiliser une classe CSS. Le paramètre *border* sert à définir, en pixel, la taille d'une bordure. Quant au paramètre *width* il contrôle la largeur du tableau (soit entre 0 et 100% soit en nombre de pixels). Le contenu d'un tableau doit être écrit en respectant la syntaxe HTML des tableaux et à l'aide des balises *tr*, *th* et *td* comme indiqué ci-dessous.

Lignes du tableau
~~~~~~~~~~~~~~~~~

**Table rows can be created in the same way as in HTML:**
Les lignes d'un tableau sont créées de la même manière qu'en HTML:

::

    <tr [class=""] [custom_parameter="" [...] ]>Table row content goes here.</tr>

Le paramètre *class* permet d'utiliser une classe CSS.

En-tête du tableau
~~~~~~~~~~~~~~~~~~

Les en-têtes du tableau sont créés de la même manière qu'en HTML:

::

    <th [class=""] [width=""] [rowspan=""] [colspan=""] [custom_parameter="" [...] ]>Example.</th>

Tous les paramètres sont optionnels et le paramètre *class* permet d'utiliser une classe CSS. Le paramètre *width* contrôle la largeur de la cellule d'en-tête (soit en pourcentage soit en nombre de pixels). Quant aux paramètres *rowspan* et *colspan* ils remplissent le même rôle qu'en HTML.

Cellules/données du tableau
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Les données et les cellules du tableau sont créées de la même manière qu'en HTML :

::

    <td [class=""] [width=""] [rowspan=""] [colspan=""] [custom_parameter="" [...] ]>Example.</td>

Tous les paramètres sont optionnels et le paramètre *class* permet d'utiliser une classe CSS. Le paramètre *width* contrôle la largeur de la cellule (soit en pourcentage soit en nombre de pixels). Quant aux paramètres *rowspan* et *colspan* ils remplissent le même rôle qu'en HTML.

Retenons que tous les paramètres personnalisés mentionnés dans les exemples d’utilisation sont également optionnels. Pour les employer, leurs noms doivent être définis dans le tableau `CustomAttributes[] <http://doc.ez.no/eZ-Publish/Technical-manual/4.x/Reference/Configuration-files/content.ini/name_of_XML_tag/CustomAttributes>`_ des sections **[table]**, **[tr]**, **[th]** et **[td]** de l'une des surcharges du fichier de configuration **content.ini**. Lorsqu'il est utilisé, un tel paramètre est disponible en tant que variable de template dont le nom est identique à celui spécifié dans la balise même.

Hyperliens
----------

Les hyperliens sont créés à l'aide des balises *a* ou *link*.

::

    <a href="" [view=""] [target=""] [ class=""] [title=""] [id=""] [custom_parameter="" [...] ]>Example.</a>

ou

::

    <link href="" [view=""] [target=""] [ class=""] [title=""] [id=""] [custom_parameter="" [...] ]>Example.</link>

Le paramètre obligatoire *href* doit contenir une adresse web valide (qui peut être externe ou interne).

Le paramètre *view* n'aura d'effet que s'il est utilisé conjointement à un lien interne (voir ci-dessous). Ce paramètre permet de spécifier le mode de vue qui sera utilisé pour afficher le noeud (ou l'objet) pointé par le lien interne. Par défaut, le système a toujours recours au mode de vue *full* pour afficher les contenus pointés par les liens internes.

Le paramètre *target* permet de définir la manière dont doit s'ouvrir l'URL cible (dans la fénêtre active du navigateur ou dans une nouvelle fenêtre ou dans un nouvel onglet, etc...). Le paramètre *class* permet d'utiliser une classe CSS pour l'affichage du lien. Le paramètre *title* permet de spécifier un court texte qui sera affiché dans une petite bulle lorsque le pointeur de la souris survolera le lien. Enfin, le paramètre *id* sert à assigner des identifiants uniques.

Les paramètres personnalisés sont optionnels et leurs noms doivent être définis dans le tableau `CustomAttributes[] <http://doc.ez.no/eZ-Publish/Technical-manual/4.x/Reference/Configuration-files/content.ini/name_of_XML_tag/CustomAttributes>`_ de la section **[link]** de l'une des surcharges du fichier de configuration **content.ini**. Lorsqu'il est utilisé, un tel paramètre est disponible en tant que variable de template dont le nom est identique à celui spécifié dans la balise même.

Liens internes
~~~~~~~~~~~~~~

Il est possible de créer des liens internes (vers d'autres noeuds ou objets) avec les syntaxes *eznode://* ou *ezobject://*qui créeront dynamiquement le lien interne en se basant sur le numéro de ID du noeud ou de l'objet. Donc, si un noeud est déplacé, le lien pointera vers le nouvel emplacement et restera donc valide.

Lien vers un noeud
^^^^^^^^^^^^^^^^^^

Un lien pointant vers un noeud est créé en spécifiant soit le numéro de ID du noeud cible soit sont chemin. Les exemples suivants illustrent comment créer un lien interne vers le noeud 128 :

::

    <a href="eznode://128">Example.</a>

ou

::

    <link href="eznode://128">Example.</link>

Les exemples suivants illustrent la création d'un lien interne vers un noeud dont le chemin est *products/computers/example* :

::

    <a href="eznode://products/computers/example">Example.</a>

ou

::

    <link href="eznode://products/computers/example">Example.</link>

Lien vers un objet
^^^^^^^^^^^^^^^^^^

Les exemples suivants illustrent comment créer un lien interne vers l'objet 1024 :

::

    <a href="ezobject://1024">Example.</a>

ou

::

    <link href="ezobject://1024">Example.</link>

Lorsque l'on crée un lien vers un objet, l'adresse de destination est générée en utilisant l'affectation du noeud principal de l'objet cible.

Vues alternatives
~~~~~~~~~~~~~~~~~

Le paramètre *view* peut être utilisé avec les deux syntaxes *eznode://* et *ezobject://*et permet d'afficher le noeud indiqué (pour un objet, c'est son noeud principal qui sera utilisé) par le biais d'un mode de vue spécifique plutôt que par le biais du mode de vue par défaut *full*. Les exemples suivants illustrent la création d'un lien interne qui, lorsque l'on clique dessus, affiche le noeud 1024 en utilisant le mode de vue *line* :

::

    <a href="eznode://1024" view="line">Example (as line).</a>

Ancres
~~~~~~

La balise *anchor* permet d'insérer, dans un bloc XML, des ancres HTML fonctionnant de la même manière que les ancres HTML standards**.** Utilisation :

::

    <anchor name="" [custom_parameter="" [...] ] />

Le paramètre *name* doit contenir un identifiant unique assigné à l'ancre. Il est possible de rechercher une ancre en ajoutant, à la fin d'un URI, le symbole dièse (#) suivi du nom de l'ancre. Cela aura pour effet d'afficher, dans le navigateur, le texte à partir de la position de l'ancre. Par exemple: http://www.example.com/hobbies#music

Les paramètres personnalisés sont optionnels et leurs noms doivent être définis dans le tableau `CustomAttributes[] <http://doc.ez.no/eZ-Publish/Technical-manual/4.x/Reference/Configuration-files/content.ini/name_of_XML_tag/CustomAttributes>`_ de la section **[anchor]** de l'une des surcharges du fichier de configuration **content.ini**. Lorsqu'il est utilisé, un tel paramètre est disponible en tant que variable de template dont le nom est identique à celui spécifié dans la balise même.

Intégration d'objets
~~~~~~~~~~~~~~~~~~~~

Avec la balise *embed* il devient possible d'intégrer dans le bloc XML n'importe quel contenu d'objet. Cela permet d'insérer, par exemple, des images. Utilisation :

::

    <embed href="" [class=""] [view=""] [align=""] [target=""] [size=""] [id=""] [custom_parameter="" [...] ] />

Avec cette balise, les objets intégrés sont insérés en tant que bloc et leur affichage commence donc toujours sur une nouvelle ligne. L'élément est dans un conteneur virtuel qui lui est propre et est systématiquement suivi d'un retour chariot (comme si on appuyait sur la touche *Entrée* après avoir inséré l'objet). Ce qui signifie, par exemple, que l'insertion d'une image à l'aide d'une balise *embed* aura pour effet de casser le paragraphe courant. Cette balise est représentée par des balises de type *block-level* dans le code XHTML résultant.

La balise *embed-inline* permet d'intégrre des objets en tant qu'éléments en ligne. Cette balise vous permet par exemple d'intégrer une image dans une ligne de texte. Utilisation :

::

    <embed-inline href="" [class=""] [view=""] [align=""] [target=""] [size=""] [id=""] [custom_parameter="" [...] ] />

Cette balise est représentée par des balises en ligne dans le code XHTML résultant. Les templates utilisés pour afficher les balises *embed-inline* ne doivent contenir aucune balise XHTML de type bloc.

Le tableau ci-dessous détaille la liste des paramètres supportés par les balises *embed* et *embed-inline* :

+-------------------+------------------------------------------------+--------+
|     Paramètre     |                  Description                   | Requis |
+===================+================================================+========+
| href              | Le paramètre *href*, qui utilise la même       | Oui    |
|                   | syntaxe que celle des hyperliens (par exemple  |        |
|                   | *"eznode://134"* ou                            |        |
|                   | *"eznode://chemin/vers/un/noeud"* ou           |        |
|                   | *"ezobject://1024"*), doit contenir un lien    |        |
|                   | valide pointant soit vers un noeud soit vers   |        |
|                   | un objet. Dans le cas d'un lien vers un noeud, |        |
|                   | *eZ Publish* utilise l'objet encapsulé par le  |        |
|                   | noeud. En d'autres termes, c'est un objet qui, |        |
|                   | dans les deux cas, est inséré (le *nœud* n'est |        |
|                   | qu'un emballage).                              |        |
+-------------------+------------------------------------------------+--------+
| class             | La paramètre *class* sert à spécifier la       | Non    |
|                   | feuille de styles CSS à utiliser. Dans le      |        |
|                   | template, cette feuille de styles sera         |        |
|                   | disponible dans la variable                    |        |
|                   | **$classification**                            |        |
+-------------------+------------------------------------------------+--------+
| view              | Le paramètre *view* permet de définir le mode  | Non    |
|                   | de vue à utiliser pour afficher l'objet (par   |        |
|                   | exemple *full*, *line*, etc...). Par défaut,   |        |
|                   | le système utilise le mode de vue *embed* pour |        |
|                   | afficher les objets intégrés par le biais de   |        |
|                   | la balise *embed*. En revanche, le mode de vue |        |
|                   | *embed-inline* est utilisé conjointement avec  |        |
|                   | les balises *embed-inline*.                    |        |
+-------------------+------------------------------------------------+--------+
| align             | Le paramètre *align*, dont les valeurs         | Non    |
|                   | possibles sont *left* (gauche), *center*       |        |
|                   | (centré) et *right* (droite), est utilisé pour |        |
|                   | définir la position de l'objet inséré.         |        |
+-------------------+------------------------------------------------+--------+
| target            | Le paramètre *target* définit la façon dont va | Non    |
|                   | s'ouvrir la fenêtre ou l'onglet (du navagteur) |        |
|                   | qui affichera l'objet (quelques valeurs        |        |
|                   | possibles: *\_self*, *\_blank*, etc...).       |        |
+-------------------+------------------------------------------------+--------+
| size              | Le paramètre *size* définit la taille (par     | Non    |
|                   | exemple: *small*, *medium*, *large*, etc...)   |        |
|                   | utilisée lorsqu'un objet image est inséré. Les |        |
|                   | tailles possibles sont définies dans le        |        |
|                   | fichier **image.ini**                          |        |
+-------------------+------------------------------------------------+--------+
| id                | La paramètre *id* sert à assigner un ID unique | Non    |
|                   | qui sera l'attribut ID dans le code HTML       |        |
|                   | résultant.                                     |        |
+-------------------+------------------------------------------------+--------+
| custom parameters | Les noms des paramètres personnalisés doivent  | Non    |
|                   | être définis dans le tableau                   |        |
|                   | `CustomAttributes[]                            |        |
|                   | <http://doc.ez.no/eZ-Publish/Technical-manual/ |        |
|                   | 4.x/Reference/Configuration-files/content.ini/ |        |
|                   | name_of_XML_tag/CustomAttributes>`_ soit de la |        |
|                   | section **[embed]** soit de la section         |        |
|                   | **[embed-inline]**de l'une des surcharges du   |        |
|                   | fichier de configuration **content.ini**.      |        |
|                   | Lorsqu'il est utilisé, un tel paramètre est    |        |
|                   | disponible en tant que variable de template    |        |
|                   | dont le nom est identique à celui spécifié     |        |
|                   | dans la balise même.                           |        |
+-------------------+------------------------------------------------+--------+


Balises personnalisées
----------------------

En plus des balises présentes par défaut et décrites ci-dessus, le datatype *Bloc XML* permet l'usage de balises personnalisées. Ces dernières peuvent être employées aussi bien en tant qu'élément de type bloc ou de type en ligne. Les balises personnalisées doivent être définies dans le tableau **AvailableCustomTags[]** de la section **[CustomTagSettings]** de l'une des surcharges du fichier de configuration **content.ini**. Lors du rendu du code XML, le contenu d'une balise personnalisée est remplacé par un template personnalisé dont le nom doit être affecté au paramètre *name*. Exemple d'utilisation :

::

    <custom name="template_name" [custom_parameter="value" [...] ]>
    The quick brown fox jumps over the lazy dog.
    </custom>

Dans l'exemple ci-dessus, la balise personnalisée sera remplacée par un template appelé **template\_name.tpl** situé dans le répertoire */templates/content/datatype/view/ezxmltags/* du design courant (ou d'un design de replis). Il est également possible de créer une surcharge de ce template. Le contenu de la balise sera disponible dans le template inséré via la variable **$content**.

Les paramètres personnalisés sont optionnels et leurs noms doivent être définis dans le tableau `CustomAttributes[] <http://doc.ez.no/eZ-Publish/Technical-manual/4.x/Reference/Configuration-files/content.ini/name_of_XML_tag/CustomAttributes>`_ de l'une des surcharges du fichier de configuration **content.ini**. Lorsqu'il est utilisé, un tel paramètre est disponible en tant que variable de template dont le nom est identique à celui spécifié dans la balise même.

Paragraphes
-----------

Les paragraphes sont créés au moyen des balises *p* ou *paragraph*.

Le paramètre optionnel *class* permet d'utiliser une classe CSS. Si vous ne spécifiez pas ce paramètre, le paragraphe sera affiché de façon naturelle (sans balise) dans l'interface d'administration. Pour créer un paragraphe assigné d'aucune classe CSS il vous suffit d'appuyer deux fois sur la touche *Entrée* de votre clavier.

::

    <p [class=""] [custom_parameter="" [...] ]>Example</p>

ou

::

    <paragraph [class=""] [custom_parameter="" [...] ]>Example</paragraph>

Par défaut, le système utilise la balise *p* dans le code XHTML résultant. Ce comportement peut être modifié en créant une surcharge du template */content/datatype/view/ezxmltags/ **paragraph.tpl***

Les paramètres personnalisés sont optionnels et leurs noms doivent être définis dans le tableau `CustomAttributes[] <http://doc.ez.no/eZ-Publish/Technical-manual/4.x/Reference/Configuration-files/content.ini/name_of_XML_tag/CustomAttributes>`_ de la section **[paragraph]** de l'une des surcharges du fichier de configuration **content.ini**. Lorsqu'il est utilisé, un tel paramètre est disponible en tant que variable de template dont le nom est identique à celui spécifié dans la balise même.

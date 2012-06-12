Tutorial du composant _Document_ - Partie Conversion
====================================================

Conversion
----------

Ce document vise à dresser une liste des éléments de balisage sémantiques spécifiques, ne pouvant pas être convertis en un autre langage de balisage. On doit ainsi s'attendre à une perte de cette information sémantique, si non traitée manuellement, lors de conversions.

###Avec une source RST

####_Perte lors de conversion en Docbook_

- _Strong emphasis_

Il n'ya pas de balisage concernant la balise _strong emphasis_ en Docbook. Ceci est converti en \<emphasis role="strong" /\> pour conserver la valeur. Cependant, le rôle peut être perdu lors de conversions supplémentaires.

- _Table colspan_

La balise _Table colspan_ est disponible en format _Docbook_, cependant le balisage est peu intuitif et difficile à lire. Ces informations peuvent être perdues au cours d'autres conversions.

- _Footnote enumeration_

En _Docbook_, _Footnote enumeration_ n'a pas de numéro d'utilisateur affecté à chaque entrée. Cependant en RST il peut y avoir plusieurs notes de pied de page avec le même numéro d'utilisateur affecté. Cette information est complètement perdue lors de la conversion.

- _Substitutions_

Les références de substitution ne sont pas conservéess. Elles sont simplement remplacées durant le processus de conversion. Les informations sur les éléments substitués sont complètement perdues.

- _Line blocks / literal blocks_

Les _line blocks_ et les _literal blocks_ sont convertis en éléments <literalblock>, ne différant que par l'attribut de la classe donnée.

- _Bullet list tokens_

L'information concernant les _Bullet list tokens_ (listes à puces) est également omise lors de la conversion.

####_Perte lors de conversion en XHTML_

- _Headers_

XHTML autorise seulement une spécification des niveaux d'en-tête de 1 à 6. Toutes les en-têtes avec une profondeur ≥ 6 contiennent un attribut de classe spécifiant leur profondeur réelle.

- _Blockquote annotations_

Il n'y a aucun élément XHTML pour les annotations blockquote. Ils sont alors transformés en éléments \<div class="annotation" /\> contenant des éléments <cite>, qui peuvent être considérés comme une citation. Cette information peut dès lors être perdue au cours d'un traitement ultérieur. L'attribut _cite_ des _blockquote_ ne peut accepter que des _URI_.

- _Bullet list & ordered list_

XHTML strict ne permet pas de spécifier le type de listes à puces ou de listes ordonnées. Cette information est donc perdue lors de la conversion.

- _Footnotes_

Il n'y a aucun élément XHTML dédié aux _footnotes_ (notes de pied de page). Les notes sont alors référencées dans le texte par des liens internes avec la classe "_footnote_". Les _footnotes_ sont également ajoutées sous le document dans des listes de classe _footnote_ avec les références appropriées.

- _Line blocks_

Les _line blocks_ sont transformés en paragraphes, dont les lignes sont séparées par des éléments \<br /\>. La mise en forme correcte est conservée, mais il se pourrait que de l'information sémantique soit perdue.

Tutorial du composant _Document_ - Partie RST
=============================================

Description
-----------

http://docutils.sourceforge.net/rst.html  
http://fr.wikipedia.org/wiki/ReStructuredText  

ReStructuredText (RST) est un langage de balisage simple et cohérent, destiné à être facile à lire et à écrire par les humains. Des exemples peuvent être trouvés dans la documentation officielle.  

Suivi du tutorial
-----------------

_Transformation simple et chargement dans un fichier :_  

Le document est chargé et parsé en un arbre selon une syntaxe interne abstraite.  
Chaque erreur de parsing ou de compilation sera transformée en une exception, de sorte que l'on soit notifié de ces erreurs.  
Les paramètres de rapport d'erreur peuvent être modifiés comme pour tous les handlers.  
La structure est alors convertie au format Docbook. [Format à documenter]  
Le résultat est retourné sous la forme d'une chaine de caractères.  
Nous pouvons alors éventuellement construire un fichier de sortie. cf. 00_00_convert_rst_docbook_result.xml

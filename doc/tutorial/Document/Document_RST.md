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

        // The document is actually loaded and parsed into an internal abstract syntax tree
        $document = new ezcDocumentRst();

        // Each parsing or compiling error will be transformed into an exception, so that you are noticed about those errors. The error reporting settings can be modified like for all other document handlers
        $document->options->errorReporting = E_PARSE | E_ERROR | E_WARNING;

        $document->loadFile( dirname(__FILE__).'/rst_base_handler.txt' );

        // The internal structure is then transformed back to a docbook document
        $docbook = $document->getAsDocbook();

        // The resulting document is returned as a string, so that you can echo or store it
        // echo $docbook->save();

        // We store it in a new file
        $myDocbookResult = fopen(dirname(__FILE__).'/00_00_convert_rst_docbook_result.xml', 'a+');
        fputs($myDocbookResult, $docbook->save() );
        fclose($myDocbookResult);

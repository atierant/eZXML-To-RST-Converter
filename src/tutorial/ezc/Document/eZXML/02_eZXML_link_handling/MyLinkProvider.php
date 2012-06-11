<?php

class myLinkProvider extends ezcDocumentEzXmlLinkProvider
{
    public function fetchUrlById( $id, $view, $show_path )
    {
        return 'http://host/path/' . $id;
    }

    public function fetchUrlByNodeId( $id, $view, $show_path )
    {
    }
    
    public function fetchUrlByObjectId( $id, $view, $show_path )
    {
    }
}



ToDo, notes personnelles
========================

Classes intéressantes
---------------------

        ezcDocument (implements )
            ezcDocumentRst
            ezcDocumentXmlBase (implements )
                ezcDocumentDocbook
                ezcDocumentEzXml
        
        ezcDocumentConverter (implements )
            ezcDocumentElementVisitorConverter
                ezcDocumentDocbookToEzXmlConverter
                ezcDocumentDocbookToRstConverter
                ezcDocumentEzXmlToDocbookConverter
        
        ezcBaseOptions (Different package)
            ezcDocumentConverterOptions
                ezcDocumentDocbookToEzXmlConverterOptions
                ezcDocumentDocbookToRstConverterOptions
                ezcDocumentEzXmlToDocbookConverterOptions

        ezcDocumentElementVisitorHandler
            ezcDocumentDocbookToEzXmlAnchorHandler
            ezcDocumentDocbookToEzXmlCommentHandler
            ezcDocumentDocbookToEzXmlEmphasisHandler
            ezcDocumentDocbookToEzXmlExternalLinkHandler
            ezcDocumentDocbookToEzXmlFootnoteHandler
            ezcDocumentDocbookToEzXmlIgnoreHandler
            ezcDocumentDocbookToEzXmlInternalLinkHandler
            ezcDocumentDocbookToEzXmlItemizedListHandler
            ezcDocumentDocbookToEzXmlLiteralLayoutHandler
            ezcDocumentDocbookToEzXmlMappingHandler
            ezcDocumentDocbookToEzXmlOrderedListHandler
            ezcDocumentDocbookToEzXmlParagraphHandler
            ezcDocumentDocbookToEzXmlRecurseHandler
            ezcDocumentDocbookToEzXmlSectionHandler
            ezcDocumentDocbookToEzXmlTableCellHandler
            ezcDocumentDocbookToEzXmlTableHandler
            ezcDocumentDocbookToEzXmlTitleHandler
            
            ezcDocumentDocbookToRstBaseHandler
                ezcDocumentDocbookToRstBeginPageHandler
                ezcDocumentDocbookToRstBlockquoteHandler
                ezcDocumentDocbookToRstCitationHandler
                ezcDocumentDocbookToRstCommentHandler
                ezcDocumentDocbookToRstEmphasisHandler
                ezcDocumentDocbookToRstExternalLinkHandler
                ezcDocumentDocbookToRstFootnoteHandler
                ezcDocumentDocbookToRstHeadHandler
                ezcDocumentDocbookToRstIgnoreHandler
                ezcDocumentDocbookToRstInternalLinkHandler
                ezcDocumentDocbookToRstItemizedListHandler
                ezcDocumentDocbookToRstLiteralHandler
                ezcDocumentDocbookToRstLiteralLayoutHandler
                ezcDocumentDocbookToRstMediaObjectHandler
                    ezcDocumentDocbookToRstInlineMediaObjectHandler
                ezcDocumentDocbookToRstOrderedListHandler
                ezcDocumentDocbookToRstParagraphHandler
                ezcDocumentDocbookToRstSectionHandler
                ezcDocumentDocbookToRstSpecialParagraphHandler
                ezcDocumentDocbookToRstTableHandler
                ezcDocumentDocbookToRstVariableListHandler
            ezcDocumentDocbookToRstRecurseHandler
            ezcDocumentEzXmlToDocbookAnchorHandler
            ezcDocumentEzXmlToDocbookEmphasisHandler
            ezcDocumentEzXmlToDocbookHeaderHandler
            ezcDocumentEzXmlToDocbookLineHandler
            ezcDocumentEzXmlToDocbookLinkHandler
            ezcDocumentEzXmlToDocbookListHandler
            ezcDocumentEzXmlToDocbookLiteralHandler
            ezcDocumentEzXmlToDocbookMappingHandler
            ezcDocumentEzXmlToDocbookTableCellHandler
            ezcDocumentEzXmlToDocbookTableHandler
            ezcDocumentEzXmlToDocbookTableRowHandler
            
        ezcDocumentEzXmlLinkConverter
            ezcDocumentEzXmlDummyLinkConverter
            
        ezcDocumentEzXmlLinkProvider
            ezcDocumentEzXmlDummyLinkProvider
            
        
        ezcBaseOptions (Different package)
            ezcDocumentOptions
                ezcDocumentRstOptions
                ezcDocumentXmlOptions
                    ezcDocumentDocbookOptions
                    ezcDocumentEzXmlOptions
            ezcDocumentParserOptions
        
        ezcDocumentParser (implements )
            ezcDocumentRstParser
        
        ezcDocumentRstDirective
            ezcDocumentRstAttentionDirective
            ezcDocumentRstContentsDirective
            ezcDocumentRstDangerDirective
            ezcDocumentRstImageDirective (implements )
                ezcDocumentRstFigureDirective
            ezcDocumentRstIncludeDirective
            ezcDocumentRstNoteDirective
            ezcDocumentRstNoticeDirective
            ezcDocumentRstWarningDirective
        
        ezcBaseStruct (Different package)
            ezcDocumentRstNode
        
        ezcDocumentRstStack
        
        ezcDocumentRstTextRole
            ezcDocumentRstEmphasisTextRole
            ezcDocumentRstLiteralTextRole
            ezcDocumentRstStrongTextRole
            ezcDocumentRstSubscriptTextRole
            ezcDocumentRstSuperscriptTextRole
            ezcDocumentRstTitleReferenceTextRole


        ezcBaseStruct (Different package)
            ezcDocumentRstToken

        ezcDocumentRstTokenizer

        ezcDocumentRstVisitor (implements )
            ezcDocumentRstDocbookVisitor
            ezcDocumentRstXhtmlVisitor
                ezcDocumentRstXhtmlBodyVisitor
                
        
        ezcBaseException (Different package)
            ezcDocumentException
                ezcDocumentConversionException
                    ezcDocumentParserException
            ezcDocumentErroneousXmlException
            ezcDocumentInvalidDocbookException
            ezcDocumentMissingVisitorException
            ezcDocumentRstMissingDirectiveHandlerException
            ezcDocumentRstMissingTextRoleHandlerException
            ezcDocumentRstTokenizerException
            ezcDocumentVisitException

        Interfaces

            ezcDocumentErrorReporting
            ezcDocumentValidation

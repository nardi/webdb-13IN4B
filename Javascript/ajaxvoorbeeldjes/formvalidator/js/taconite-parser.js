// JavaScript Document
var taconite_parser_version=1.502;
var isIE=document.uniqueID;
String.prototype.trim = function() {
    //skip leading and trailing whitespace
    //and return everything in between
    var x=this;
    x=x.replace(/^\s*(.*)/, "$1");
    x=x.replace(/(.*?)\s*$/, "$1");
    return x;
};

function requiresContextNode(xmlTagName) {
    return !(xmlTagName == "taconite-execute-javascript" || xmlTagName == "taconite-redirect");
}


function XhtmlToDOMParser(){
    this.parseXhtml = function(xml){
        var xmlTagName=xml.tagName.toLowerCase();
        var contextNode=document.getElementById(xml.getAttribute("contextNodeID"));
        if(contextNode == null && requiresContextNode(xmlTagName)){
            return false;
        }
        switch (xmlTagName) {
            case "taconite-append-as-children":
                getReplaceChildren(contextNode,xml,false);
                break;
            case "taconite-delete":
                getDelete(contextNode,xml);
                break;
            case "taconite-append-as-first-child":
                getAppendAsFirstChild(contextNode,xml);
                break;                         
            case "taconite-insert-after":
                getInsertAfter(contextNode,xml);
                break;
            case "taconite-insert-before":
                getInsertBefore(contextNode,xml);
                break;                         
            case "taconite-replace-children":
                getReplaceChildren(contextNode,xml,true);
                break;
            case "taconite-replace":
                getReplace(contextNode,xml);
                break;                         
            case "taconite-set-attributes":
                xml.removeAttribute("contextNodeID");
                xml.removeAttribute("parseInBrowser");
                handleAttributes(contextNode,xml);
                break;
            case "taconite-redirect":
                handleRedirect(xml);
                break;
            case "taconite-execute-javascript":
                executeJavascript(xml);
                break;
        }  
        return true;
    };
    
    function isInlineMode(node) {
        var attrType;
        if(!node.tagName.toLowerCase() == "input") {
            return false;
        }
        attrType=node.getAttribute("type");
        
        if(attrType=="radio" || attrType=="checkbox") {
            return true;
        }
        return false;
    }  
    this.getJavaScript= function() {
        return "var dummy_taconite_variable=0";
    }; 
    function handleNode(xmlNode){
        var nodeType = xmlNode.nodeType;               
        switch(nodeType) {
            case 1:  //ELEMENT_NODE
                return handleElement(xmlNode);
            case 3:  //TEXT_NODE
            case 4:  //CDATA_SECTION_NODE
                var textNode = document.createTextNode(xmlNode.nodeValue);
                if(isIE) {
                    textNode.nodeValue = textNode.nodeValue.replace(/\n/g, '\r'); 
                }
                return textNode;
        }      
        return null;
    }
    function handleElement(xmlNode){
        var domElemNode=null;
        var xmlNodeTagName=xmlNode.tagName.toLowerCase();
        if(isIE){
            if(isInlineMode(xmlNode)) {
                return document.createElement("<INPUT " + handleAttributes(domElemNode,xmlNode,true) + ">");
            }
            if(xmlNodeTagName == "style"){
                //In internet explorer, we have to use styleSheets array.		
                var text,rulesArray,styleSheetPtr;
                var regExp = /\s+/g;
                text=xmlNode.text.replace(regExp, " ");
                rulesArray=text.split("}");
                
                domElemNode=document.createElement("style");
                styleSheetPtr=document.styleSheets[document.styleSheets.length-1];
                for(var i=0;i<rulesArray.length;i++){
                    rulesArray[i]=rulesArray[i].trim();
                    var rulePart=rulesArray[i].split("{");
                    if(rulePart.length==2) {//Add only if the rule is valid
                        styleSheetPtr.addRule(rulePart[0],rulePart[1],-1);//Append at the end of stylesheet.
                    }
                }							
                return domElemNode;			
            }
            
        }
        if(domElemNode == null){
            if(useIEFormElementCreationStrategy(xmlNodeTagName)) {
                domElemNode = createFormElementsForIEStrategy(xmlNode);
            }
            else {
                domElemNode = document.createElement(xmlNodeTagName);
            }
            
            handleAttributes(domElemNode,xmlNode);
            //Fix for IE Script tag: Unexpected call to method or property access error
            //IE don't allow script tag to have child
            if(isIE && !domElemNode.canHaveChildren){
                if(xmlNode.childNodes.length > 0){
                    domElemNode.text=xmlNode.text;
                }
                
            }                              
            else{
                for(var z = 0; z < xmlNode.childNodes.length; z++) {
                    var domChildNode=handleNode(xmlNode.childNodes[z]);
                    if(domChildNode!=null) {
                        domElemNode.appendChild(domChildNode);
                    }
                }
            }
        }      
        
        return domElemNode;
    }
    
    function useIEFormElementCreationStrategy(xmlNodeTagName) {
        var useIEStrategy = false;
        
        if (isIE && ( xmlNodeTagName.toLowerCase() == "form" ||
              xmlNodeTagName.toLowerCase() == "input" ||
              xmlNodeTagName.toLowerCase() == "textarea" ||
              xmlNodeTagName.toLowerCase() == "select" ||
              xmlNodeTagName.toLowerCase() == "a" ||
              xmlNodeTagName.toLowerCase() == "applet" ||
              xmlNodeTagName.toLowerCase() == "button" ||
              xmlNodeTagName.toLowerCase() == "img" ||
              xmlNodeTagName.toLowerCase() == "link" ||
              xmlNodeTagName.toLowerCase() == "map" ||
              xmlNodeTagName.toLowerCase() == "object")) {
                      
            useIEStrategy = true;
        }
        
        return useIEStrategy;
    }
    
    function createFormElementsForIEStrategy(xmlNode) {
        var attr = null;
        var name = "";
        var value = "";
        for (var x = 0; x < xmlNode.attributes.length; x++) {
            attr = xmlNode.attributes[x];
            name = attr.name.trim();
            if (name == "name") {
                value = attr.value.trim();
            }
        }

        domElemNode = document.createElement("<" + xmlNode.tagName + " name='" + value + "' />"); // e.g. document.createElement("<input name='slot2'>");
        
        return domElemNode;
    }
    
    function handleAttributes(domNode, xmlNode) {
        var attr = null;
        var attrString = "";
        var name = "";
        var value = "";
        var returnAsText = false;
        if(arguments.length == 3) {
            returnAsText = true;
        }
        
        for(var x = 0; x < xmlNode.attributes.length; x++) {
            attr = xmlNode.attributes[x];
            name = cleanAttributeName(attr.name.trim());
            value = attr.value.trim();
            if(!returnAsText){
                if(name == "style") {
                    /* IE workaround */
                    domNode.style.cssText = value;
                    /* Standards compliant */
                    domNode.setAttribute(name, value);
                }
                else if(name.trim().toLowerCase().substring(0, 2) == "on") {
                    /* IE workaround for event handlers */
                    //domNode.setAttribute(name,value);
                    eval("domNode." + name.trim().toLowerCase() + "=function(){" + value + "}");
                }
                else if(name == "value") {
                    /* IE workaround for the value attribute -- makes form elements selectable/editable */
                    domNode.value = value;
                }
                else if(useIEFormElementCreationStrategy(xmlNode.tagName) && name == "name") {
                    //Do nothing, as the "name" attribute was handled in the createFormElementsForIEStrategy function
                    continue;
                }
                else {
                    /* Standards compliant */
                    domNode.setAttribute(name,value);
                }
                /* class attribute workaround for IE */
                if(name == "class") {
                    domNode.setAttribute("className",value);
                }
            }else{
                attrString = attrString + name + "=\"" + value + "\" " ;
            }
        }
        return attrString;
    }
    function getAppendAsFirstChild(domNode,xml){
        var firstNode=null;
        if(domNode.childNodes.length > 0) {
            firstNode=domNode.childNodes[0];
        }
        
        for(var i=0;i<xml.childNodes.length;i++){
            domChildNode=handleNode(xml.childNodes[i]);
            if(domChildNode!=null){
                if(firstNode==null){
                    domNode.appendChild(domChildNode);
                    firstNode=domChildNode;
                }
                else {
                    domNode.insertBefore(domChildNode,firstNode);
                }
                
            }
        }              
    }
    
    function getInsertAfter(domNode,xml){
        var domChildNode=null;
        var nextSibling=domNode.nextSibling;
        for(var i=0;i<xml.childNodes.length;i++){
            domChildNode=handleNode(xml.childNodes[i]);
            if(domChildNode!=null){
                if(nextSibling!=null) {
                    domNode.parentNode.insertBefore(domChildNode,nextSibling);
                }
                else {
                    domNode.parentNode.appendChild(domChildNode);
                }
            }
        }              
    }
    function getInsertBefore(domNode,xml){
        var domChildNode=null;
        for(var i=0;i<xml.childNodes.length;i++){
            domChildNode=handleNode(xml.childNodes[i]);
            if(domChildNode!=null) {
                domNode.parentNode.insertBefore(domChildNode,domNode);
            }
        }              
    }      
    function getReplace(domNode,xml){
        getInsertAfter(domNode,xml);
        domNode.parentNode.removeChild(domNode);
    }
    function getDelete(domNode) {
        domNode.parentNode.removeChild(domNode);
    }
    function getReplaceChildren(domNode,xml,doRemoveChildren) {
        var domChildNode=null;
        if(doRemoveChildren){
            while(domNode.childNodes.length >0){
                domNode.removeChild(domNode.childNodes[0]);
            }      
        }
        for(var i=0;i<xml.childNodes.length;i++){
            domChildNode=handleNode(xml.childNodes[i]);
            if(domChildNode!=null) {
                domNode.appendChild(domChildNode);
            }
        }              
    }
    
    function handleRedirect(xmlNode) {
        var targetUrl = xmlNode.getAttribute("targetUrl");
        window.location.replace(targetUrl);
    }
    
    function executeJavascript(xmlNode) {
        var scripts = xmlNode.getElementsByTagName("script");
        for (var i = 0; i < scripts.length; i++) {
            var script = scripts[i];
            if (script.getAttribute("type") == "text/javascript") {
                var js = script.firstChild.nodeValue;
                eval(js);
            }
        }
    }

    function cleanAttributeName(name) {
        if(isIE == false) {
            return;
        }
        
        // IE workaround to change cellspacing to cellSpacing, etc
        var cleanName = name.toLowerCase();
        if(cleanName == "cellspacing") {
            cleanName = "cellSpacing";
        }
        else if(cleanName == "cellpadding") {
            cleanName = "cellPadding";
        }
        else if(cleanName == "colspan") {
            cleanName = "colSpan";
        }
        else if(cleanName == "tabindex") {
            cleanName = "tabIndex";
        }
        else if(cleanName == "readonly") {
            cleanName = "readOnly";
        }
        return cleanName;
    }
    
}

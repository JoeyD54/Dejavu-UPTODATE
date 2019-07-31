<?php
//This program is called by the form's submit button.
//When called, it will add the item from the form to the XML.

    if(isset($_REQUEST['location'])){
        $itemName = $_REQUEST['item'];
        if(!empty($_REQUEST['location'])){
            $destName = $_REQUEST['location'];
        } else {
            $destName = "Closest";
        }

        echo $destName;

        $xml = new DOMDocument('1.0','utf-8');
        $xml->formatOutput = true;
        $xml->preserveWhiteSpace = false;
        $xml->load('C:\wamp64\www\deja-vu\www\xml\toDoList.xml');
        //$xml->load('http://localhost:8080/DejaVu/xml/toDoList.xml');

        $newItem = $xml->createElement('todo');

        $newItem->appendChild($xml->createElement('item', $itemName));
        $newItem->appendChild($xml->createElement('dest', $destName));
        
        $xml->getElementsByTagName('list')->item(0)->appendChild($newItem);

        $xml->save('C:\wamp64\www\deja-vu\www\xml\toDoList.xml');
        //$xml->save('http://localhost:8080/DejaVu/xml/toDoList.xml');


        header("Location: http://localhost/deja-vu/www/dejaVuMainPage");  
    }

?>
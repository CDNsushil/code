<?php
/**
 * This class contains mothods to convert a xml tree into a complex array with nested properties and to convert a complex array object into an xml tree.
 *
 * @package xml-utils
 * @author Anoop
 * @version 1.5
 */
final class xmlutils
{
       /**
         * Add a levels attributes directly to the levels node instead of into an attributes array.
         *
         */
        const XML_MERGE_ATTRIBUTES = 1;
        /**
         * Merge the attribures of a level into the parent level that they belong to.
         *
         */
        const XML_MERGE_VALUES = 2;
        /**
         * Add a levels children directly to the levels node instead of into a children array.
         *
         */
        const XML_MERGE_CHIILDREN = 4;
        /**
         * Process value as a lone entry under their level and ignore the other attributes and children.
         *
         */
        const XML_VALUE_PAIRS = 8;
        /**
         * Split the value of a node into an array on newlines.
         *
         */
        const XML_SPLIT_VALUES = 16;
        /**
         * If a value is an array with a single item, just use the item.
         *
         */
        const XML_SPLIT_SHIFT = 32;

        /**
         * This function will convert an XML tree into a multi-dimentional array.
         *
         * @param SimpleXMLElement $xml
         * @param bitfield $ops
         * @return array
         */
        public static function xml_to_array($xml, $ops=63) {
                // Store the name of this level.
                $level = array();
                $level["name"] = $xml->getName();

                // Grab the value of this level.
                $value = trim((string)$xml);

                // If we have a value, process it.
                if($value) {
                        // Split the value into an array on newlines.
                        if($ops & self::XML_SPLIT_VALUES)
                                $value = explode("\n", $value);

                        // If the value is an array with one item, remove the array.
                        if($ops & self::XML_SPLIT_SHIFT)
                                if(sizeof($value) == 1)
                                        $value = array_shift($value);

                        // Store the value of this level.
                        $level["value"] = $value;
                }

                // If this level had a value just return the name/value as an array.
                if($ops & self::XML_VALUE_PAIRS && array_key_exists("value", $level))
                        return array($level["name"] => $level["value"]);

                // Loop through each atribute of this level.
                foreach($xml->attributes() as $attribute) {
                        // Add each attribure directly to this level in the array.
                        if($ops & self::XML_MERGE_ATTRIBUTES)
                                $level[$attribute->getName()] = (string)$attribute;
                        // Add all the attributes to an attributes array under this level in the array.
                        else
                                $level["attributes"][$attribute->getName()] = (string)$attribute;
                }

                // Loop through each child of this level.
                foreach($xml->children() as $children) {
                        // Get an array of this childs data.
                        $child = self::xml_to_array($children, $ops);

                        if($ops & self::XML_MERGE_VALUES) {
                                // Add each child directly to this level  or to the children array of this level in the array.
                                if(sizeof($child) == 1) {
                                        // If there is only one child then merge it up.
                                        if($ops & self::XML_MERGE_CHIILDREN)
                                                $level[array_shift(array_keys($child))] = $child[array_shift(array_keys($child))];
                                        else
                                                $level["children"][array_shift(array_keys($child))] = $child[array_shift(array_keys($child))];
                                } elseif(array_key_exists("value", $child)) {
                                        // If there is a value key then merge it up.
                                        if($ops & self::XML_MERGE_CHIILDREN)
                                                $level[$child["name"]] = $child["value"];
                                        else
                                                $level["children"][$child["name"]] = $child["value"];
                                } elseif(array_key_exists("children", $child)) {
                                        // If there are children, then merge them up.
                                        if($ops & self::XML_MERGE_CHIILDREN)
                                                $level[] = $child;
                                        else
                                                $level["children"][] = $child;
                                } else {
                                        // Otherwise just assigne yourself.
                                        if($ops & self::XML_MERGE_CHIILDREN)
                                                $level[] = $child;
                                        else
                                                $level["children"][] = $child;
                                }
                        } else {
                                $level["children"][] = $child;
                        }
                }


                return $level;
        }

        /**
        * The main function for converting to an XML document.
        * Pass in a multi dimensional array and this recrusively loops through and builds up an XML document.
        *
        * @param array $data
        * @param string $rootNodeName - what you want the root node to be - defaultsto data.
        * @param SimpleXMLElement $xml - should only be used recursively
        * @return string XML
        */
        public static function array_to_xml($data, $rootNodeName = 'data', $xml=null, $parentXml=null)
        {

                // turn off compatibility mode as simple xml throws a wobbly if you don't.
                if (ini_get('zend.ze1_compatibility_mode') == 1)
                {
                        ini_set ('zend.ze1_compatibility_mode', 0);
                }
                //if ($rootNodeName == false) {
                //      $xml = simplexml_load_string("<s/>");
                //}
                if ($xml == null)
                {
                       $xml = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$rootNodeName />");
                }

                // loop through the data passed in.
                foreach($data as $key => $value)
                {
                        // Create a name for this item based off the attribute name or if this is a item in an array then the parent nodes name.
                        $nodeName = is_numeric($key) ? $rootNodeName . '-item' : $key;
                        $nodeName = preg_replace('/[^a-z1-9_-]/i', '', $nodeName);

                        // If this item is an array then we will be recursine to the logic is more complex.
                        if (is_array($value)) {
                                // If this node is part of an array we have to proccess is specialy.
                                if (is_numeric($key)) {
                                        // Another exception if this is teh root node and is an array.  In this case we don't have a parent node to use so we must use the current node and not update the reference. 
                                        if($parentXml == null) {
                                                $childXml = $xml->addChild($nodeName);
                                                self::array_to_xml($value, $nodeName, $childXml, $xml);
                                        // If this is a array node then we want to add the item under the parent node instead of out current node. Also we have to update $xml to reflect the change.
                                        } else {
                                                $xml = $parentXml->addChild($nodeName);
                                                self::array_to_xml($value, $nodeName, $xml, $parentXml);
                                        }
                                } else {
                                        // For a normal attribute node just add it to the parent node.
                                        $childXml = $xml->addChild($nodeName);
                                        self::array_to_xml($value, $nodeName, $childXml, $xml);
                                }
                        // If not then it is a simple value and can be directly appended to the XML tree.
                        } else {
                                $value = htmlentities($value);
                                $xml->addChild($nodeName, $value);
                        }
                }

                // Pass back as string or simple xml object.
                return $xml->asXML();
        }
	}
?>
<?php
require_once "$OWLLIB_ROOT/reader/OWLTag.php";


/**
 *  Load information from <rdf:RDF> node
 *  All functions are implemented in OWLTag
 *
 *  @version	$Id: OWLClassTag.php,v 1.4 2004/04/07 06:20:42 klangner Exp $
 */
class OWLClassTag extends OWLTag
{
	
	//---------------------------------------------------------------------------
	/**
	 * create tag
	 */
	function create(&$model, $name, $attributes, $base)
  {
  	OWLTag::create($model, $name, $attributes, $base);

  	if(array_key_exists($this->RDF_ID, $attributes)){
			$this->id = $model->getNamespace() . $attributes[$this->RDF_ID];
			$this->cls = $model->createClass($this->id);
  	}
  	else if(array_key_exists($this->RDF_ABOUT, $attributes)){
			$this->id = $this->addBaseToURI($attributes[$this->RDF_ABOUT]);
			$this->cls = $model->createClass($this->id);
		}
  }


	//---------------------------------------------------------------------------
	/**
	 * process child:
	 *
	 * OWLSubclassOfTag add super class information 
	 */
	function processChild($child)
  {
 		$name = get_class($child); 
  	if($name == "owlsubclassoftag"){
  		$parent = $child->getID();
			$this->cls->addSuperclass($parent);
  	}
  	else if($name == "owlintersectionoftag"){
  		$parent = $child->getID();
			$this->cls->addSuperclass($parent);
  	}
  	else if($name == "owllabeltag"){
  		$language = $child->getLanguage();
  		$label = $child->getLabel();
			$this->model->addLabel($this->id, $language, $label);
  	}
  }

	//---------------------------------------------------------------------------
	var $cls;	
}

?>

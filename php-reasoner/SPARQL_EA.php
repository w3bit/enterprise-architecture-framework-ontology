<?php

require_once 'sparqllib.php';

class SPARQL_EA{

	private static $_instance=null;
	private $db=null;

	
	private function __construct(){

		$this->db = sparql_connect( "http://localhost:3030/ea-new/sparql" );
		if( !$this->db) { print $this->db->errno() . ": " . $this->db->error(). "\n"; exit; }
		$this->db->ns( "rdf","http://www.w3.org/1999/02/22-rdf-syntax-ns#" );
		$this->db->ns( "rdfs","http://www.w3.org/2000/01/rdf-schema#" );
		$this->db->ns( "xsd","ttp://www.w3.org/2001/XMLSchema#" );
		$this->db->ns( "owl","http://www.w3.org/2002/07/owl#" );

	}

	public static function getInstance(){
		if(self::$_instance==null){
			self::$_instance=new SPARQL_EA();
		}
		return self::$_instance;
	}

	public function getObjectInfo($label){


		// Get ObjectProperty & Subject for a Object
		$sparql = "SELECT DISTINCT ?subject_label ?relation_label
		{ 
		  ?object rdfs:label '$label'@en.
		  ?super_class rdfs:subClassOf ?sub_classes.
		  ?sub_classes owl:onProperty ?o_property.
		  ?o_property rdfs:label ?relation_label.
		  ?sub_classes owl:someValuesFrom ?object.
		  ?super_class rdfs:label ?subject_label.
		}";

		$result = $this->db->query( $sparql ); 
		if( !$result ) { print $this->db->errno() . ": " . $this->db->error(). "\n"; exit; }

		return $result;

	}

	public function getFrameworkInfo($label){


		// Get Framework info for given class
		$sparql = "SELECT DISTINCT ?framework_label ?relation_label
		{ 
		  ?subject rdfs:label '$label'@en.
		  ?t rdfs:label 'Enterprise Architecture Framework'@en.
		  ?frameworks rdfs:subClassOf ?t.
		  ?frameworks rdfs:subClassOf ?sub_classes.
		  ?sub_classes owl:onProperty ?o_property.
		  ?o_property rdfs:label ?relation_label.
		  ?sub_classes owl:someValuesFrom ?subject.
		  ?frameworks rdfs:label ?framework_label.
		}";

		$result = $this->db->query( $sparql ); 
		if( !$result ) { print $this->db->errno() . ": " . $this->db->error(). "\n"; exit; }

		return $result;

	}

	public function getRelObjFrameworkInfo($class_label,$relation_label){

		// Get Framework info for given class
		$sparql = "SELECT DISTINCT ?framework_label ?relation_label
		{ 
		  ?object rdfs:label '$class_label'@en.

		  ?subject rdfs:subClassOf ?i.
		  ?i owl:onProperty ?q.
		  ?q rdfs:label '$relation_label'@en.
		  FILTER EXISTS {?i owl:someValuesFrom ?object}.

		  {
		  	?t rdfs:label 'Enterprise Architecture Framework'@en.
		  	?frameworks rdfs:subClassOf ?t.
		  	?frameworks rdfs:subClassOf ?sub_classes.
		  	?sub_classes owl:onProperty ?o_property.
		  	?o_property rdfs:label ?relation_label.
		  	?sub_classes owl:someValuesFrom ?object.
		  	?frameworks rdfs:label ?framework_label.
		  }
		  UNION
		  {
		  	?t rdfs:label 'Enterprise Architecture Framework'@en.
		  	?frameworks rdfs:subClassOf ?t.
		  	?frameworks rdfs:subClassOf ?sub_classes.
		  	?sub_classes owl:onProperty ?o_property.
		  	?o_property rdfs:label ?relation_label.
		  	?sub_classes owl:someValuesFrom ?subject.
		  	?frameworks rdfs:label ?framework_label.
		  }
		
		}";

		$result = $this->db->query( $sparql ); 
		if( !$result ) { print $this->db->errno() . ": " . $this->db->error(). "\n"; exit; }

		return $result;

	}

	public function getRelSubFrameworkInfo($class_label,$relation_label){

		$sparql = "SELECT DISTINCT ?framework_label ?relation_label
		{ 
		  ?subject rdfs:label '$class_label'@en.

		  ?subject rdfs:subClassOf ?i.
		  ?i owl:onProperty ?q.
		  ?q rdfs:label '$relation_label'@en.
		  FILTER EXISTS {?i owl:someValuesFrom ?o}.
		  {
		  	?t rdfs:label 'Enterprise Architecture Framework'@en.
		 	?frameworks rdfs:subClassOf ?t.
		  	?frameworks rdfs:subClassOf ?sub_classes.
		  	?sub_classes owl:onProperty ?o_property.
		  	?o_property rdfs:label ?relation_label.
		  	?sub_classes owl:someValuesFrom ?o.
		  	?frameworks rdfs:label ?framework_label.
		  }
		  UNION
		  {
		  	?t rdfs:label 'Enterprise Architecture Framework'@en.
		  	?frameworks rdfs:subClassOf ?t.
		  	?frameworks rdfs:subClassOf ?sub_classes.
		  	?sub_classes owl:onProperty ?o_property.
		  	?o_property rdfs:label ?relation_label.
		  	?sub_classes owl:someValuesFrom ?subject.
		  	?frameworks rdfs:label ?framework_label.
		  }
		
		}";

		$result = $this->db->query( $sparql ); 
		if( !$result ) { print $this->db->errno() . ": " . $this->db->error(). "\n"; exit; }

		return $result;

	}

	public function getRelSubObjFrameworkInfo($class_label,$relation_label,$object_label){

		$result= $this->getRelSubFrameworkInfo($class_label,$relation_label);
		if($result->num_rows($result)>=1){
			return $result;
		}else{
			$result= $this->getRelObjFrameworkInfo($object_label,$relation_label);
		}

		return $result;

	}

	public function getSubjectInfo($label){


		// Get ObjectProperty & Subject for a Object
		$sparql = "SELECT DISTINCT ?object_label ?relation_label
		{ 
		  ?subject rdfs:label '$label'@en;
		  		   rdfs:subClassOf ?sub_classes.
		  ?sub_classes owl:onProperty ?o_property.
		  ?o_property rdfs:label ?relation_label.
		  ?sub_classes owl:someValuesFrom ?object.
		  ?object rdfs:label ?object_label.
		}";

		$result = $this->db->query( $sparql ); 
		if( !$result ) { print $this->db->errno() . ": " . $this->db->error(). "\n"; exit; }

		return $result;

	}

	public function getRelObjInfo($obj_label,$relation_label){


		// Get ObjectProperty & Subject for a Object
		$sparql = "SELECT DISTINCT ?subject_label
		{ 
		  ?object rdfs:label '$obj_label'@en.
		  ?super_class rdfs:subClassOf ?sub_classes.
		  ?sub_classes owl:onProperty ?o_property.
		  ?o_property rdfs:label '$relation_label'@en.
		  ?sub_classes owl:someValuesFrom ?object.
		  ?super_class rdfs:label ?subject_label.
		}";

		$result = $this->db->query( $sparql ); 
		if( !$result ) { print $this->db->errno() . ": " . $this->db->error(). "\n"; exit; }

		return $result;

	}

	public function getRelSubInfo($sub_label,$relation_label){


		// Get ObjectProperty & Subject for a Object
		$sparql = "SELECT DISTINCT ?object_label
		{ 
		  ?subject rdfs:label '$sub_label'@en.
		  ?subject rdfs:subClassOf ?sub_classes.
		  ?sub_classes owl:onProperty ?o_property.
		  ?o_property rdfs:label '$relation_label'@en.
		  ?sub_classes owl:someValuesFrom ?object.
		  ?object rdfs:label ?object_label.
		}";

		$result = $this->db->query( $sparql ); 
		if( !$result ) { print $this->db->errno() . ": " . $this->db->error(). "\n"; exit; }

		return $result;

	}

	public function getRelSubObjInfo($sub_label,$relation_label,$object_label){


		// Get ObjectProperty & Subject for a Object
		$sparql = "SELECT DISTINCT ?object_label ?subject_label
		{ 
		  ?subject rdfs:label '$sub_label'@en.
		  ?object rdfs:label '$object_label'@en.
		  ?subject rdfs:subClassOf ?sub_classes.
		  ?sub_classes owl:onProperty ?o_property.
		  ?o_property rdfs:label '$relation_label'@en.
		  ?sub_classes owl:someValuesFrom ?object.
		  ?object rdfs:label ?object_label.
		}";

		$result = $this->db->query( $sparql ); 
		if( !$result ) { print $this->db->errno() . ": " . $this->db->error(). "\n"; exit; }

		return $result;

	}

	public function getObjects($label){

		$sparql = "SELECT DISTINCT ?label
		{ 
		  ?objects rdfs:label ?temp.
		  FILTER(regex(?temp,'$label','i')).
		  ?objects a owl:Class.
		  {
		  	 ?objects rdfs:label ?label
		  }
		  UNION
		  {
		  	?subclass rdfs:subClassOf ?objects.
		  	?subclass rdfs:label ?label

		  }
		 


		}";

		$result = $this->db->query( $sparql ); 
		if( !$result ) { print $this->db->errno() . ": " . $this->db->error(). "\n"; exit; }

		return $result;

		
	}
	public function getRelations($label){

		$sparql = "SELECT DISTINCT ?label
		{ 
		  ?objects rdfs:label ?temp.
		  FILTER(regex(?temp,'$label','i')).
		  ?objects a owl:ObjectProperty.
		  ?objects rdfs:label ?label
		}";

		$result = $this->db->query( $sparql ); 
		if( !$result ) { print $this->db->errno() . ": " . $this->db->error(). "\n"; exit; }

		return $result;

		
	}

}
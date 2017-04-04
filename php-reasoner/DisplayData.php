<?php 

class DisplayData{


	// result have two field, relation and object (eg: use o1) 
	public static function relationObject($result,$subject,$framework){
		

		$out = "<div class='row'>";
		$out .= "<h4>Subject: $subject </h4>";
		$out .= "<hr/>";

		$out .= "<h5>Recommended Frameworks:</h4>";
		$out .= "<table class='data'>";

		while( $row = $framework->fetch_array() )
		{
			$out .= "<tr>";
			$out .= "<td>".$row['framework_label']."</td>";
			$out .= "<td>".$row['relation_label']."</td>";
			$out .= "<td>".$subject."</td>";
			$out .= "</tr>";
		}
		$out .= "</table>";

		$out .= "<hr/>";

		$out .= "<h5>All relations:</h4>";

		$out .= "<table class='data'>";

		while( $row = $result->fetch_array() )
		{
			$out .= "<tr>";
			$out .= "<td>".$subject."</td>";
			$out .= "<td>".$row['relation_label']."</td>";
			$out .= "<td>".$row['object_label']."</td>";
			$out .= "</tr>";
		}
		$out .= "</table>";

		$out .= "</div>";

		return $out;

	}

	// result have two field, relation_label and subject_label (eg: s1 use) , object is main concept that is described
	public static function relationSubject($result,$object,$framework){
		if($result->num_rows($result)==0){
			return ;
		}

		$out = "<div class='row'>";
		$out .= "<h4>Subject: $object </h4>";
		$out .= "<hr/>";


		$out .= "<h5>Recommended Frameworks:</h4>";
		$out .= "<table class='data'>";

		while( $row = $framework->fetch_array() )
		{
			$out .= "<tr>";
			$out .= "<td>".$row['framework_label']."</td>";
			$out .= "<td>".$row['relation_label']."</td>";
			$out .= "<td>".$object."</td>";
			$out .= "</tr>";
		}
		$out .= "</table>";

		$out .= "<hr/>";
		

		$out .= "<h5>All relations:</h4>";
		$out .= "<table class='data'>";

		while( $row = $result->fetch_array() )
		{
			$out .= "<tr>";
			$out .= "<td>".$row['subject_label']."</td>";
			$out .= "<td>".$row['relation_label']."</td>";
			$out .= "<td>".$object."</td>";
			$out .= "</tr>";
		}
		$out .= "</table>";

		$out .= "</div>";

		return $out;

	}

	// result have two field, relation and object (eg: use o1) 
	public static function relObjFormatter($result,$object,$relation,$framework){
		if($result->num_rows($result)==0){
			return ;
		}

		$out = "<div class='row'>";
		$out .= "<h4>Relation and Object: $relation $object </h4>";
		$out .= "<hr/>";

		$out .= "<h5>Recommended Frameworks:</h4>";
		$out .= "<table class='data'>";

		while( $row = $framework->fetch_array() )
		{
			$out .= "<tr>";
			$out .= "<td>".$row['framework_label']."</td>";
			$out .= "<td>".$row['relation_label']."</td>";
			$out .= "<td>".$object."</td>";
			$out .= "</tr>";
		}
		$out .= "</table>";

		$out .= "<hr/>";

		$out .= "<h5>Other relations:</h4>";

		$out .= "<table class='data'>";

		while( $row = $result->fetch_array() )
		{
			$out .= "<tr>";
			$out .= "<td>".$row['subject_label']."</td>";
			$out .= "<td>".$relation."</td>";
			$out .= "<td>".$object."</td>";
			$out .= "</tr>";
		}
		$out .= "</table>";

		$out .= "</div>";

		return $out;

	}

	// result have two field, relation and object (eg: use o1) 
	public static function relSubFormatter($result,$subject,$relation,$framework){
		if($result->num_rows($result)==0){
			return ;
		}

		$out = "<div class='row'>";
		$out .= "<h4>Relation and Subject: $relation $subject </h4>";
		$out .= "<hr/>";

		$out .= "<h5>Recommended Frameworks:</h4>";
		$out .= "<table class='data'>";

		while( $row = $framework->fetch_array() )
		{
			$out .= "<tr>";
			$out .= "<td>".$row['framework_label']."</td>";
			$out .= "<td>".$row['relation_label']."</td>";
			$out .= "<td>".$subject."</td>";
			$out .= "</tr>";
		}
		$out .= "</table>";

		$out .= "<hr/>";

		$out .= "<h5>Other relations:</h4>";

		$out .= "<table class='data'>";

		while( $row = $result->fetch_array() )
		{
			$out .= "<tr>";
			$out .= "<td>".$subject."</td>";
			$out .= "<td>".$relation."</td>";
			$out .= "<td>".$row['object_label']."</td>";
			$out .= "</tr>";
		}
		$out .= "</table>";

		$out .= "</div>";

		return $out;

	}

	// result have two field, relation and object (eg: use o1) 
	public static function relSubObjFormatter($result,$subject,$relation,$object,$framework){
		if($result->num_rows($result)==0){
			return ;
		}

		$out = "<div class='row'>";
		$out .= "<h4>Relation, Object and Subject: $subject $relation $object</h4>";
		$out .= "<hr/>";

		$out .= "<h5>Recommended Frameworks:</h4>";
		$out .= "<table class='data'>";

		while( $row = $framework->fetch_array() )
		{
			$out .= "<tr>";
			$out .= "<td>".$row['framework_label']."</td>";
			$out .= "<td>".$row['relation_label']."</td>";
			$out .= "<td>".$subject."</td>";
			$out .= "</tr>";
		}
		$out .= "</table>";

		$out .= "<hr/>";

		$out .= "<h5>Other relations:</h4>";

		$out .= "<table class='data'>";

		while( $row = $result->fetch_array() )
		{
			$out .= "<tr>";
			$out .= "<td>".$subject."</td>";
			$out .= "<td>".$relation."</td>";
			$out .= "<td>".$row['object_label']."</td>";
			$out .= "</tr>";
		}
		$out .= "</table>";

		$out .= "</div>";

		return $out;

	}
	

}

<?php include_once 'header.php'; ?>	

<?php 

require_once './SPARQL_EA.php';
require_once './DisplayData.php';

if(strlen($_GET['q'])>2){
	
	
	list($s_label,$p_label,$o_label)=explode(",", $_GET['q']);

	$sparql=SPARQL_EA::getInstance();

	// Only Object
	// Find Object with regular Expression of label

	if($s_label=="?" && $p_label=="?" && $o_label!="?"){

		$objects= $sparql->getObjects($o_label);

		foreach ($objects->rows as $object) {
			echo DisplayData::relationSubject(
				$sparql->getObjectInfo($object['label']['value']),
				$object['label']['value'],
				$sparql->getFrameworkInfo($object['label']['value'])
				);
		}
	}


	// Only Subject

	// Find Object with regular Expression of label

	if($o_label=="?" && $p_label=="?" && s_label!="?"){

		$subjects= $sparql->getObjects($s_label);

		foreach ($subjects->rows as $subject) {
			echo DisplayData::relationObject(
				$sparql->getSubjectInfo($subject['label']['value']),
				$subject['label']['value'],
				$sparql->getFrameworkInfo($subject['label']['value'])
				);
		}
	}

	// Relation + Object
	// Find Object with regular Expression of label

	if($s_label=="?" && $p_label!="?" && $o_label!="?"){

		$objects 	= $sparql->getObjects($o_label);
		$relations 	= $sparql->getRelations($p_label);


		foreach ($objects->rows as $object) {
			foreach ($relations->rows as $relation) {
				echo DisplayData::relObjFormatter(
					$sparql->getRelObjInfo($object['label']['value'],$relation['label']['value']),
					$object['label']['value'],
					$relation['label']['value'],
					$sparql->getRelObjFrameworkInfo($object['label']['value'],$relation['label']['value'])
					);

			}
		}
	}

	// Relation + Subject
	// Find Object with regular Expression of label

	if($s_label!="?" && $p_label!="?" && $o_label=="?"){

		$subjects 	= $sparql->getObjects($s_label);
		$relations 	= $sparql->getRelations($p_label);


		foreach ($subjects->rows as $subject) {
			foreach ($relations->rows as $relation) {
				echo DisplayData::relSubFormatter(
					$sparql->getRelSubInfo($subject['label']['value'],$relation['label']['value']),
					$subject['label']['value'],
					$relation['label']['value'],
					$sparql->getRelSubFrameworkInfo($subject['label']['value'],$relation['label']['value'])
					);

			}
		}
	}

	// Relation + Subject + Object
	// Find Object with regular Expression of label

	if($s_label!="?" && $p_label!="?" && $o_label!="?"){

		$subjects 	= $sparql->getObjects($s_label);
		$relations 	= $sparql->getRelations($p_label);
		$objects 	= $sparql->getObjects($o_label);



		foreach ($subjects->rows as $subject) {
			foreach ($relations->rows as $relation) {
				foreach ($objects->rows as $object) {
					echo DisplayData::relSubObjFormatter(
						$sparql->getRelSubObjInfo($subject['label']['value'],$relation['label']['value'],$object['label']['value']),
						$subject['label']['value'],
						$relation['label']['value'],
						$object['label']['value'],
						$sparql->getRelSubObjFrameworkInfo($subject['label']['value'],$relation['label']['value'],$object['label']['value'])
						);
				}

			}
		}
	}

	 

}

?>

<hr/>

<br/>
<h5>Ask other Question:</h5>

<form action="answer.php" method="get" style="center">

<input type="text" value="<?=$_GET['q']?>" style="width:400px;height:50px;padding:5px 20px;" name="q" placeholder="Write your Question." />
<input type="submit" value="send" id="submit" style="width:150px;height:60px;-webkit-appearance: none;" />

</form>

<?php

 include_once 'footer.php';


?>
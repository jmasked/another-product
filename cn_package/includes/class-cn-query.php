<?php

/**
 * Register all Query for the plugin
 *
 * @link       http://greencraft.design
 * @since      1.0.0
 *
 * @package    Cn_Query
 * @subpackage Cn_Query/includes
 */

/**
 * 
 *
 *
 * @since      1.0.0
 * @package    Cn_Query
 * @subpackage Cn_Query/includes
 * @author     Jaime Manikas
 */
class Cn_Query {

	// public function __construct() {
	// }

	public function iFetch($SQL)
	{
		global $wpdb;
		$record = array_shift($wpdb->get_results($SQL));
		$record=json_decode(json_encode($record),true);
		return $record;
	}

	public function iWhileFetch($sql){
		global $wpdb;
		$record = $wpdb->get_results($sql);
		$record=json_decode(json_encode($record),true);
		return $record;
	}

	public function iUpdateArray($table, $postData = array(),$conditions = array(),$html_spl='No')
	{
		global $wpdb;
		foreach($postData as $k=>$value)
		{				
			if($html_spl=='Yes')
			{
				$value = htmlspecialchars($value);
			}
			if($value==NULL)
				$values .= "`$k` = NULL, ";
			else
				$values .= "`$k` = '$postData[$k]', ";
		}
		$values = substr($values, 0, strlen($values) - 2);
		foreach($conditions as $k => $v)
		{
			$v = htmlspecialchars($v);			
			$conds .= "$k = '$v'";
		}			
		$update = "UPDATE `$table` SET $values WHERE $conds";
		$rs=$wpdb->query($update);
		if($wpdb->last_error){
			$error=$wpdb->last_error;
			$last_query=$wpdb->last_query;
			$success='warning';
			$msg='Something was wrong';
		}
		else{
			$success='success';
			$msg='updated successfully';
		}
		$response=array('success'=> $success,'msg'=>$msg,'error'=> $error,'last_query' =>$last_query);
		return json_encode($response);
	}

	public function iQuery($SQL,&$rs)
	{
		if($this->iMainQuery($SQL,$rs))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function iMainQuery($SQL,&$rs)
	{
		global $wpdb;		
		$rs=$wpdb->query($SQL);
		if($wpdb->last_error){
			$error=$wpdb->last_error;
			$last_query=$wpdb->last_query;
			$success='warning';
		}
		else{
			$success='success';
		}
		$response=array('success'=> $success,'error'=> $error,'last_query' =>$last_query);
		return $response;

	}

	public function iInsert($table, $postData = array(),$html_spl='No')
	{
		global $wpdb;
		$sql = "DESC $table";
		$getFields = array();		
		$fieldArr = $wpdb->get_results($sql);
		foreach($fieldArr as $field)
		{
			$field=json_decode(json_encode($field),true);
			$getFields[sizeof($getFields)] = $field['Field'];
		}
		$fields = "";
		$values = "";
		if (sizeof($getFields) > 0)
		{				
			foreach($getFields as $k)
			{
				if (isset($postData[$k]))
				{
					if($html_spl=='No')
					{
						$postData[$k] = $postData[$k];
					}
					else
					{
						$postData[$k] = htmlspecialchars($postData[$k]);
					}
					$fields .= "`$k`, ";
					$values .= "'$postData[$k]', ";
				}
			}			
			$fields = substr($fields, 0, strlen($fields) - 2);
			$values = substr($values, 0, strlen($values) - 2);
			$insert = "INSERT INTO $table ($fields) VALUES ($values)";
			$rs=$wpdb->query($insert);
			if($wpdb->last_error){
				$error=$wpdb->last_error;
				$last_query=$wpdb->last_query;
				$success='warning';
				$msg='Something was wrong';
			}
			else{
				$success='success';
				$msg='Added successfully';
				$insert_id=$wpdb->insert_id;
			}
		}
		else
		{
			$msg='Something was wrong';
			$success='warning';
		}
		$response=array('success'=> $success,'msg'=>$msg,'error'=> $error,'last_query' =>$last_query,'insert_id'=>$insert_id);
		return json_encode($response);
	}	

	public function showMessage($type,$title,$text=NULL,$Button=false,$timer=1600)
	{
		// if ($response->success=='success') {
		// 	echo $this->query->showMessage($response->success,$response->msg);
		// }else{
		// 	echo $this->query->showMessage($response->success,$response->msg,$response->$msg,true,'');
		// }
		ob_start();
		?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				swal({
					type: '<?php echo $type ?>',
					title: '<?php echo $title ?>',
					text: '<?php echo $text ?>',
					showConfirmButton: '<?php echo $Button ?>',
					timer: '<?php echo $timer ?>'
				});
				
			});
		</script>
		<?php 
		$ReturnString = ob_get_contents(); ob_end_clean(); 
 		return $ReturnString;
	}
	
	public function iFetchCount($SQL,&$totalRecord)
	{
		global $wpdb;
		if($SQL)
		{
			if($this->is_debug==true)
			{
				$this->iQuery($SQL,$rs);
			}
			$record = array_shift($wpdb->get_results($SQL));
			$record=json_decode(json_encode($record),true);
			$totalRecord=$record['count'];
			return true;
		}
		else
		{
			return false;
		}
	}

	public function cnAllCount(&$total_record,$table,$field_id,$conditions = array())
	{
		$conds="";
		foreach($conditions as $k => $v)
		{
			$v = htmlspecialchars($v);
			$conds .= "$k = '$v'";
		}
		 $select="SELECT COUNT($field_id) as total_rec FROM $table ";
		$record=$this->iFetch($select,$record);
		return $total_record=$record['total_rec'];
	}

	public function iCount(&$total_record,$table,$field_id,$conditions = array())
	{
		$conds="";
		foreach($conditions as $k => $v)
		{
			$v = htmlspecialchars($v);
			$conds .= "$k = '$v'";
		}
		$select="SELECT COUNT($field_id) as total_rec FROM $table WHERE $conds";
		$record=$this->iFetch($select,$record);
		return $total_record=$record['total_rec'];
	}

	public function iCnCount(&$total_record,$table,$field_id,$conditions)
	{
		
		$select="SELECT COUNT($field_id) as total_rec FROM $table WHERE $conditions";
		$record=$this->iFetch($select,$record);
		return $total_record=$record['total_rec'];
	}

}


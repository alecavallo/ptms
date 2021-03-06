<?php
class User extends AppModel {
	var $name = 'User';
	var $displayField = 'alias';
	var $cacheQueries = true;
	var $fileStatus = "";
	var $validate = array(
		'id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Debe especificar un numero entero',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'first_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'El nombre no puede ser vacío',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'alpha' => array(
				'rule' => array('onlyLetters','first_name'),
				'message' => 'El nombre solo puede contener letras',
				'allowEmpty' => false,
				//'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'last_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'El apellido no puede ser vacío',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'alphanumeric' => array(
				'rule' => array('onlyLetters', 'last_name'),
				'message' => 'El apellido solo puede contener letras',
				'allowEmpty' => false,
				//'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'alias' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'El Nick name no puede ser vacío',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'rating' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'city_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'email' => array(
			'rule' => array('email', true),
			'message' => 'Ingrese una dirección de correo válida',
			'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
		'password' => array(
			'notEmpty' => array(
				'rule' => array('alphanumeric', true),
				'message' => 'La contraseña solo puede contener alfanuméricos y no debe ser vacía',
				'allowEmpty' => false,
				//'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notEmpty' => array(
				'rule' => array('alphanumeric', true),
				'message' => 'La contraseña solo puede contener alfanuméricos y no debe ser vacía',
				'allowEmpty' => false,
				//'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notEmpty' => array(
				'rule' => 'notemptypasswd',
				'message' => 'La contraseña está vacía',
				'allowEmpty' => false,
				//'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'password_confirm' => array(
			'rule' => array('identicalValues', 'password'),
			'message' => 'La contraseñas no coinciden',
			'allowEmpty' => false,
			//'required' => true,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
		'home_layout' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Debe especificar un numero entero',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'avatar'	=>	array(
			'rule'	=>	'isUploadedImage',
			'message'=>	array('Formato de imágen no válido. Solo estan permitidos JPG, PNG y GIF'),
			'allowEmpty' => true,
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasOne = array(
		'PreferredLayout' => array(
			'className' => 'PreferredLayout',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

	var $belongsTo = array(
		'City' => array(
			'className' => 'City',
			'foreignKey' => 'city_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Source' => array(
			'className' => 'Source',
			'foreignKey' => 'sources_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

	var $hasMany = array(
		'Comment' => array(
			'className' => 'Comment',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'News' => array(
			'className' => 'News',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	function notemptypasswd(){
		$val = array_shift($params);
		return $val != Security::hash('', null, true);
	}

	function isUploadedImage($params){
		$val = array_shift($params);
		debug($val);
		if($val['error'] == 4){
			return true;
		}
		if (((isset($val['error']) && $val['error'] == 0) ||
		(!empty( $val['tmp_name']) && $val['tmp_name'] != 'none')) && (stripos($val['type'], 'image') !== false)) {
			return true;
		}else{
			return false;
		}
		
	}
	
	function identicalValues( $field=array(), $compare_field=null ){
        foreach( $field as $key => $value ){
            $v1 = $value;
            $v2 = $this->data[$this->name][ $compare_field ];
            if($v1 !== $v2) {
                return FALSE;
            } else {
                continue;
            }
        }
        return TRUE;
    }

	function onlyLetters($value,$field){		
		$value = $value[$field];
		$value = html_entity_decode($value, ENT_QUOTES);
		$pattern = '(^[a-z|ñ|Ñ|á|é|í|ó|ú|à|è|ì|ò|ù|ä|ë|ï|ö|ü|â|ê|î|ô|û][a-z|ñ|Ñ| |á|é|í|ó|ú|à|è|ì|ò|ù|ä|ë|ï|ö|ü|â|ê|î|ô|û]*\'?[a-z|ñ|Ñ| |á|é|í|ó|ú|à|è|ì|ò|ù|ä|ë|ï|ö|ü|â|ê|î|ô|û]*[a-z|ñ|Ñ| |á|é|í|ó|ú|à|è|ì|ò|ù|ä|ë|ï|ö|ü|â|ê|î|ô|û]$)';
		//$pattern=utf8_encode($pattern);
		$aux=eregi($pattern,$value);

		return $aux;
	}


	function usersWithNews($limit=NULL, $page=0){
		if (!empty($limit)) {
			$limit = "limit {$page},{$limit}";
		}else {
			$limit = "";
		}
		$limit = mysql_real_escape_string($limit);
		$sql = <<<SQL
select first_name, last_name, avatar, alias, posteamos_alias, description
from users User
inner join news News on News.user_id=User.id
group by News.user_id
having count(News.id) > 0
order by User.rating desc
{$limit};
SQL;
		
		return $this->query($sql);

	}

	function afterFind($results, $primary){
		//parent::afterFind($results,$primary);
		if(count($results)>1){
			return $results;
		}
		
			/*si no tiene definido los resultados de google adwords, retornar como está*/
			if (empty($results[0]['User']['gadw_code'])) {
				return $results;
			}
			
			$gadw_code = $results[0]['User']['gadw_code'];
			$aux = array();
			$google_ad_client = preg_match_all('/google_ad_client = "(.*)";/', $gadw_code, $aux, PREG_PATTERN_ORDER);
			if ($google_ad_client > 0) {
				$google_ad_client = $aux[1][0];
			}
			
			$aux = array();
			$google_ad_slot = preg_match_all('/google_ad_slot = "(.*)";/', $gadw_code, $aux, PREG_PATTERN_ORDER);
			if ($google_ad_slot > 0) {
				$google_ad_slot = $aux[1][0];
			}
			
			$aux = array();
			$google_ad_width = preg_match_all('/google_ad_width = (.*);/', $gadw_code, $aux, PREG_PATTERN_ORDER);
			if ($google_ad_width > 0) {
				$google_ad_width = $aux[1][0];
			}
			
			$aux = array();
			$google_ad_height = preg_match_all('/google_ad_height = (.*);/', $gadw_code, $aux, PREG_PATTERN_ORDER);
			if ($google_ad_height > 0) {
				$google_ad_height = $aux[1][0];
			}
			
			/*elimino código javascript en crudo para prevenir una inclusion accidentar que puede facilitar XSS*/
			//unset($results[0]['User']['gadw_code']);
			
			$results[0]['User']['google_ad_client'] = $google_ad_client;
			$results[0]['User']['google_ad_slot'] = $google_ad_slot;
			$results[0]['User']['google_ad_width'] = $google_ad_width;
			$results[0]['User']['google_ad_height'] = $google_ad_height;
			return $results;
	}

	function beforeSave(){
		if (array_key_exists('avatar', $this->data['User']) && is_array($this->data['User']['avatar'])){
			//$this->fileStatus = $this->data['User']['avatar'];
			$folderName = WWW_ROOT."img".DS."avatars";
			$filename = time().$this->data['User']['avatar']['name'];
			$filename = explode(".", $filename);
			$filename = $filename[0].".jpg";
			$avatarUrl = str_ireplace(WWW_ROOT, '', $folderName.DS.$filename);
			$avatarUrl = str_ireplace(DS, "/", $avatarUrl);
			$this->data['User']['avatar'] = "/".$avatarUrl;
		}
		return true;
	}

}
?>
<?php
    
    class TemplateLeitor 
    {
        
        public static function pegaCampos($string,$leitor){
            $campos = preg_match_all('/'.$leitor.'/',$string, $matches);

            $fields['chave'] = array();
            $fields['campo'] = array();

            foreach ($matches[0] as $key => $value) {
                $fields['chave'][] = $value;
            }

            foreach ($matches[1] as $key => $value) {
                $fields['campo'][] = $value;
            }

            return $fields;
        }

        public static function generateSlug($str){
			$str = mb_strtolower($str);
			$str = preg_replace('/(â|á|ã)/', 'a', $str);
			$str = preg_replace('/(ê|é)/', 'e', $str);
			$str = preg_replace('/(í|Í)/', 'i', $str);
			$str = preg_replace('/(ú)/', 'u', $str);
			$str = preg_replace('/(ó|ô|õ|Ô)/', 'o',$str);
			$str = preg_replace('/(_|\/|!|\?|#)/', '',$str);
			$str = preg_replace('/( )/', '-',$str);
			$str = preg_replace('/ç/','c',$str);
			$str = preg_replace('/(-[-]{1,})/','-',$str);
			$str = preg_replace('/(,)/','-',$str);
			$str=strtolower($str);
			return $str;
		}
    }
    


?>
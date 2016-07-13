<?php
	if (rex::isBackend()) {
		rex_extension::register('ART_ADDED', function(rex_extension_point $ep) {
			$params = $ep->getParams();
			
			
			$sql = rex_sql::factory();
			$profiles = $sql->getArray('SELECT * FROM `'.rex::getTablePrefix().'articlepresets_profiles`');
			unset($sql);
			
			foreach ($profiles as $profile) {
				$copy = false;
				
				
				if ($profile['categories'] != '') {
					$profile['categories'] = explode(',', $profile['categories']);
					
					if (in_array($params['data']['category_id'], $profile['categories'])) {
						$copy = true;
					} else {
						$copy = false;
					}
				}
				
				if ($profile['templates'] != '') {
					$profile['templates'] = explode('|', substr($profile['templates'],1,-1));
					
					if (in_array($params['data']['template_id'], $profile['templates'])) {
						$copy = true;
					} else {
						$copy = false;
					}
				}
				
				if ($copy === true) {
					//todo: copy $profile['articlereference']
					
					//evtl. Anlegen abbrechen und kopieren?
					//rex_article_service::copyArticle($id, $to_cat_id)
				}
			}
		});
	}
?>
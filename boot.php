<?php

    if (rex::isBackend()) {
        rex_extension::register('ART_ADDED', static function (rex_extension_point $ep): void {
            $params = $ep->getParams();

            $sql = rex_sql::factory();
            $profiles = $sql->getArray('SELECT * FROM `'.rex::getTablePrefix().'articlepresets_profiles`');
            unset($sql);

            foreach ($profiles as $profile) {
                $copyStatusCategories = true;
                $copyStatusTemplates = true;

                if ('' != $profile['categories']) {
                    $profile['categories'] = explode('|', substr($profile['categories'], 1, -1));

                    if (!in_array($params['data']['category_id'], $profile['categories'])) {
                        $copyStatusCategories = false;
                    }
                }

                if ('' != $profile['templates']) {
                    $profile['templates'] = explode('|', substr($profile['templates'], 1, -1));

                    if (!in_array($params['data']['template_id'], $profile['templates'])) {
                        $copyStatusTemplates = false;
                    }
                }

                if (rex_addon::get('metainfo')->isAvailable()) {
                    // Start - get all metainfo-fields
                    $sql = rex_sql::factory();
                    $fields = array_column($sql->getArray('SHOW COLUMNS FROM `'.rex::getTablePrefix().'article` WHERE `Field` like "art_%"'), 'Field');
                    unset($sql);
                    // End - get all metainfo-fields

                    rex_article_service::copyMeta($profile['articlereference'], $params['id'], $params['clang'], $params['clang'], $fields);
                }

                if ($copyStatusCategories && $copyStatusTemplates) {
                    rex_content_service::copyContent($profile['articlereference'], $params['id'], $params['clang'], $params['clang']);
                }
            }
        });
    }

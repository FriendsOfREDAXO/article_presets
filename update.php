<?php

rex_sql_table::get(rex::getTable('articlepresets_profiles'))
    ->ensureColumn(new rex_sql_column('id', 'int(11) unsigned', false, null, 'auto_increment'))
    ->ensureColumn(new rex_sql_column('name', 'varchar(30)', false, ''))
    ->ensureColumn(new rex_sql_column('categories', 'mediumtext'))
    ->ensureColumn(new rex_sql_column('templates', 'varchar(255)'))
    ->ensureColumn(new rex_sql_column('articlereference', 'int(10) unsigned'))
    ->setPrimaryKey('id')
    ->ensure();

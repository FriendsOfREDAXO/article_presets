<?php
	$func = rex_request('func', 'string');
	
	if ($func == '') {
		$list = rex_list::factory("SELECT `id`, `name` FROM `".rex::getTablePrefix()."articlepresets_profiles` ORDER BY `name` ASC");
		$list->addTableAttribute('class', 'table-striped');
		$list->setNoRowsMessage($this->i18n('profiles_norowsmessage'));
		
		// icon column
		$thIcon = '<a href="'.$list->getUrl(['func' => 'add']).'"><i class="rex-icon rex-icon-add-action"></i></a>';
		$tdIcon = '<i class="rex-icon fa-file-text-o"></i>';
		$list->addColumn($thIcon, $tdIcon, 0, ['<th class="rex-table-icon">###VALUE###</th>', '<td class="rex-table-icon">###VALUE###</td>']);
		$list->setColumnParams($thIcon, ['func' => 'edit', 'id' => '###id###']);
		
		$list->setColumnLabel('name', $this->i18n('profiles_column_name'));
		
		$list->setColumnParams('name', ['id' => '###id###', 'func' => 'edit']);
		
		$list->removeColumn('id');
		
		$content = $list->get();
		
		$fragment = new rex_fragment();
		$fragment->setVar('content', $content, false);
		$content = $fragment->parse('core/page/section.php');
		
		echo $content;
	} else if ($func == 'add' || $func == 'edit') {
		$id = rex_request('id', 'int');
		
		if ($func == 'edit') {
			$formLabel = $this->i18n('profiles_formcaption_edit');
		} elseif ($func == 'add') {
			$formLabel = $this->i18n('profiles_formcaption_add');
		}
		
		$form = rex_form::factory(rex::getTablePrefix().'articlepresets_profiles', '', 'id='.$id);
		
		//Start - add name-field
			$field = $form->addTextField('name');
			$field->setLabel($this->i18n('profiles_label_name'));
		//End - add name-field
		
		//Start - add categories-field
			$field = $form->addSelectField('categories');
			$field->setLabel($this->i18n('profiles_label_categories'));
			$field->setSelect(new rex_category_select());
			
			$select = $field->getSelect();
			$select->setMultiple();
			$select->setSize(10);
		//End - add categories-field
		
		//Start - add templates-field
			$field = $form->addSelectField('templates');
			$field->setLabel($this->i18n('profiles_label_templates'));
			
			$select = $field->getSelect();
			$select->setMultiple();
			$select->setSize(10);
			$select->addSqlOptions('SELECT `name`, `id` FROM `'.rex::getTablePrefix().'template` ORDER BY `name` ASC');
		//End - add templates-field
		
		//Start - add article_reference-field
			$field = $form->addLinkmapField('articlereference');
			$field->setLabel($this->i18n('profiles_label_articlereference'));
		//End - add article_reference-field
		
		if ($func == 'edit') {
			$form->addParam('id', $id);
		}
		
		$content = $form->get();
		
		$fragment = new rex_fragment();
		$fragment->setVar('class', 'edit', false);
		$fragment->setVar('title', $formLabel, false);
		$fragment->setVar('body', $content, false);
		$content = $fragment->parse('core/page/section.php');
		
		echo $content;
	}
?>
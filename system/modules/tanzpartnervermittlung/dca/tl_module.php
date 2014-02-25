<?php

/*
Palette für das Modul tanzpartnervermittlung_list
*/

$GLOBALS['TL_DCA']['tl_module']['palettes']['tanzpartnervermittlung_list'] = '{title_legend},name,headline,type;{tanzpartnervermittlung_select_gender_legend},tl_tanzpartnervermittlung_selectGender;
{tanzpartnervermittlung_legend},tl_tanzpartnervermittlung_detail;
{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_module']['palettes']['tanzpartnervermittlung_neu'] = '{title_legend},name,headline,type;
{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

 /**
 * Add fields to tl_module
 */
 
/*
hier wird die tabelle tl_module um folgende felder erweitert um die Einstellungen des Moduls speichern zu können

*/ 

$GLOBALS['TL_DCA']['tl_module']['fields']['tl_tanzpartnervermittlung_selectGender'] = array(
       'label' => &$GLOBALS['TL_LANG']['tl_module']['tl_tanzpartnervermittlung_selectGender'],
       'default' => 'Alle',
       'inputType' => 'select',
       'options' => array('M','F'),
	   //reference = ersetzt die options 'A' 'B' ... durch richtigen text
	   'reference' => &$GLOBALS['TL_LANG']['tl_module']['tl_tanzpartnervermittlung_selectGender_filteroptions'],
       'eval' => array('mandatory' => true),
       'sql' => "varchar(255) NOT NULL default ''"
);


//speichert die Weiterleitungsseite (Frontend) in er die Details des Turnierpaares angeschaut werden können
$GLOBALS['TL_DCA']['tl_module']['fields']['tl_tanzpartnervermittlung_detail'] = array(
       'label' => &$GLOBALS['TL_LANG']['tl_module']['tl_tanzpartnervermittlung_detail'],
       'inputType' => 'pageTree',
       'foreignKey' => 'tl_page.title',
        'eval' => array('fieldType'=>'radio', 'mandatory'=>true),
       'sql' => "varchar(255) NOT NULL default ''"
);

?>
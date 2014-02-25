<?php
 
 /*klasse tl_turnierpaare
 hier werden hauptsächlich callback Funktionen implementiert die wir im DCA von der tabelle tl_turnierpaare benötigen
 
 */
 class tl_turnierpaare extends Backend 
{ 
    /** 
     * Import the back end user object 
     */ 
    public function __construct() 
    { 
        parent::__construct(); 
        $this->import('BackendUser', 'User'); 
    } 
 
  public function password_save_callback($var, $dc) 
  { 
  if(strlen($var)==0){
	  if(strlen($dc->activeRecord->startbuchnummer)!=0){
	return  md5($dc->activeRecord->startbuchnummer);
	  }else{
		  
	return '';	  
		  }
	  }else{
	return $var;	  
		  }
  } 
  
  public function getKlassen(){
	  
	  $klassen = array('','Kin I D','Kin I C','Kin II D','Kin II C','Jun I D','Jun I C','Jun I B','Jun II D','Jun II C','Jun II B','Jug D','Jug C','Jug B','Jug A','Hgr D','Hgr C','Hgr B','Hgr A','Hgr S','Hgr II D','Hgr II C','Hgr II B','Hgr II A','Hgr II S','Sen I D','Sen I C','Sen I B','Sen I A','Sen I S','Sen II D','Sen II C','Sen II B','Sen II A','Sen II S','Sen III D','Sen III C','Sen III B','Sen III A','Sen III S','Sen IV A','Sen IV S','Beginners LWD 1 Combi','Beginners LWD 2 Combi','Beginners LWD 1 Duo','Beginners LWD 2 Duo','Fortgeschrittene LWD 1 Combi','Fortgeschrittene LWD 2 Combi','Fortgeschrittene LWD 1 Duo','Fortgeschrittene LWD 2 Duo','Leistungsklasse LWD 1 Combi','Leistungsklasse LWD 2 Combi','Leistungsklasse LWD 1 Duo','Leistungsklasse LWD 2 Duo','Breitensport');
	  
	  return $klassen;
	  }
  
  public function password_reset_callback($var, $dc) 
  { 
  if(strlen($var)==1){
	  if(strlen($dc->activeRecord->startbuchnummer)!=0){
	$row = $this->Database->prepare("SELECT * FROM tl_turnierpaare WHERE id=?") 
                              ->execute($dc->id);
	$pw = 	md5($row->startbuchnummer);					  
							  
	$this->Database->prepare("UPDATE tl_turnierpaare SET password='".$pw."' WHERE id=?") 
                              ->executeUncached($dc->id); 						  
	  }  
  }
  return 0;
  } 
  
	public function buttonTurnierpaarbilder($row, $href, $label, $title, $icon, $attributes)
    {
        return '<a href="' . $this->addToUrl($href . '&id=' . $row['id'], 1) . '" title="' . specialchars($title) . '"' . $attributes . '>' . $this->generateImage($icon, $label) . '</a> ';
    }
	
	public function buttonTurnierergebnisse($row, $href, $label, $title, $icon, $attributes)
    {
        return '<a href="' . $this->addToUrl($href . '&id=' . $row['id'], 1) . '" title="' . specialchars($title) . '"' . $attributes . '>' . $this->generateImage($icon, $label) . '</a> ';
    }	
} 
 
/**
 * Table tl_turnierpaare
 */
 
 /*
 Hier wird die eigentliche MySQL Tabelle angelegt und konfiguriert, sowie festgelegt in welcher Form die einzelnen Felder im Backend ausgefüllt werden können
 
 nähere infos zu den einzelnen Felder:
 https://contao.org/de/manual/3.2/data-container-arrays.html
 
 */
$GLOBALS['TL_DCA']['tl_turnierpaare'] = array
(
 
	// Config
	'config'   => array
	(
		'dataContainer'    => 'Table',
		'enableVersioning' => true,
		'doNotCopyRecords' => true,
		/*ctable = Kind-Tabellen
			hierbei gilt zum Beispiel tl_turnierpaare.id = tl_turnierergebnisse.pid
			Dies ist besonders praktisch da hier contao für uns vorselektiert wenn wir später im Backend unter Turnierpaare in Paar auswählen und in einem unter Menu die Ergebnisse anschauen wollen
			Entsprechend muss in den DCA's im Bereich config der Kindertabellen der Eintrag 'ptable' = 'tl_turnierpaare' gesetzt werden
			
		*/
		'ctable'			=> array('tl_turnierpaarbilder', 'tl_turnierergebnisse', 'tl_turniermeldungen'),
		'sql'              => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		),
	),
	
	
	// List
	'list'     => array
	(
		/*
		Auswahl der felder nach denen der Reihe nach sortert werden soll
		*/
		'sorting'           => array
		(
			'mode'        => 2,
			'fields'      => array('Hvorname', 'Hnachname', 'Dvorname', 'Dnachname'),
			'flag'        => 1,
			/*
			Hier wird dem PanelLayout mitgeteilt, dass wir gerne filtern, sortieren und suchen wollen können. Nach was im einzelnen gefiltert, sortiert bzw gesucht werden kann wir in den einzelnen Feldern bekannt gemacht
			*/
			'panelLayout' => 'filter,sort,search'
		),
		
		/*
		hier wird die Darstellung der einzelnen Reihe im Backend formatiert
		fields = diese Tabellenfelder werden benötigt
		format = eingetliche formatierung der Reihe, HTML tags können verwendet werden
		*/
		
		'label'             => array
		(
			'fields' => array('Hvorname', 'Hnachname', 'Dvorname', 'Dnachname'),
			'format' => '%s %s - %s %s',
		),
		
		//Globale Operationen
		'global_operations' => array
		(
			'all' => array
			(
				'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'       => 'act=select',
				'class'      => 'header_edit_all',
				'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		
		
		//Operationen pro Reihe
		'operations'        => array
		(
		//bearbeiten
			'edit'   => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_turnierpaare']['edit'],
				'href'  => 'act=edit&mode=0',
				'icon'  => 'edit.gif'
			),
		//weiterleitung auf die turnierpaarbilder des entsprechenden Turnierpaares	
			'turniererpaarbilder' => array(
                'label' => &$GLOBALS['TL_LANG']['tl_turnierpaare']['turnierpaarbilder'],
                'icon' => 'system/modules/turnierpaare/assets/images/photo.png',
				'attributes' => 'class="contextmenu"',
				//hier wird im link die tabelle festgelegt in der die turnierpaarbilder sind
				'href'       => 'table=tl_turnierpaarbilder',
				//button_callback erstellt den eigentlichen link in der klasse 'tl_turnierpaare'  und der funktion buttonTurnierpaarbilder()
				'button_callback' => array(
                    'tl_turnierpaare',
                    'buttonTurnierpaarbilder'
                )
            ),
			'turnierergebnisse' => array(
                'label' => &$GLOBALS['TL_LANG']['tl_turnierpaare']['turnierergebnisse'],
                'icon' => 'system/modules/turnierpaare/assets/images/ergebnisse.png',
				'attributes' => 'class="contextmenu"',
				'href'       => 'table=tl_turnierergebnisse',
				'button_callback' => array(
                    'tl_turnierpaare',
                    'buttonTurnierergebnisse'
                )
            ),
			'delete' => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_turnierpaare']['delete'],
				'href'       => 'act=delete&mode=0',
				'icon'       => 'delete.gif',
				'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show'   => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_turnierpaare']['show'],
				'href'       => 'act=show&mode=0',
				'icon'       => 'show.gif',
				'attributes' => 'style="margin-right:3px"'
			),
			
		)
	),
	
	// Palettes
	/*
	Palette = Layout im Bearbeitungsbereich eines Turnierpaares
	
	Formatierung: {...} = Bereichsüberschift Platzhalter
	Danch die eingentliche Felder die bearbeitet werden sollen die durch ',' getrennt werden und ein neuer Bereich durch ';' angelegt
	
	
	*/
	'palettes' => array
	(
		'default'       => '{startbuchnummer_legend},startbuchnummer,aktiv;{password_legend:hide}, password_reset;{herr_legend},Hvorname,Hnachname,Hemail,Htelefon;{dame_legend},Dvorname,Dnachname,Demail,Dtelefon;{startklasse_legend}, classSTD, classLAT, classSTD2, classLAT2;{info_legend:hide}, beginn, ende, www;{bilder_legend:hide}'
),


// Fields
/*
Hier werden die eigentlichen felder der tabelle tl_turnierpaare bekannt gemacht.

Änderungen die hier durchgeführt werden, müssen im Contao Backend unter 'Erweiterungsverwaltung'-> 'Datenbank aktualisiern' aktualisiert werden
*/
	'fields'   => array
	(
	//Pflichtfeld
		'id'     => array
		(
			'sql' => "int(10) unsigned NOT NULL auto_increment"
		),
	//Pflichtfeld	
		'tstamp' => array
		(
			'sql' => "int(10) unsigned NOT NULL default '0'"
		),
		'startbuchnummer'  => array
		(
			//Platzhalter für das Backend
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierpaare']['startbuchnummer'],
			//Wie soll die eingabe erfolgen, in diesem Fall als Textfeld
			'inputType' => 'text',
			//Soll der Zugriff auf dieses Feld durch andere Benutzern im Backend geregelt werden können
			'exclude'   => false,
			//hier wird bekannt gemacht, dass nach diesem Feld sortiert werden kann, es erscheint automatisch im Panellayout im bereich sortierung
			'sorting'   => true,
			'flag'      => 1,
			//hier wird bekannt gemacht, dass nach diesem Feld gesucht werden kann, es erscheint automatisch im Panellayout im bereich suchen
            'search'    => true,
			//Gültigkeitscheck
			'eval'      => array(
			//Pflichtfeld?
				'mandatory'   => true,
				//einzigartig in der Tabelle?
                 'unique'         => true,
				 //maximale Länge
                 'maxlength'   => 255,
				 //css class für das Backend 
				'tl_class'        => 'w50',
 
			),
			//SQL definition des Feldes
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'Hvorname'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierpaare']['Hvorname'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => true,
			'flag'      => 1,
                        'search'    => true,
			'eval'      => array(
				'mandatory'   => true,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'Hnachname'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierpaare']['Hnachname'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => true,
			'flag'      => 1,
                        'search'    => true,
			'eval'      => array(
				'mandatory'   => true,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'Hemail'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierpaare']['Hemail'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
                        'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'Htelefon'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierpaare']['Htelefon'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
                        'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'Dvorname'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierpaare']['Dvorname'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => true,
			'flag'      => 1,
                        'search'    => true,
			'eval'      => array(
				'mandatory'   => true,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'Dnachname'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierpaare']['Dnachname'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => true,
			'flag'      => 1,
                        'search'    => true,
			'eval'      => array(
				'mandatory'   => true,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'Demail'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierpaare']['Demail'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
            'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'Dtelefon'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierpaare']['Dtelefon'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
            'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		
		'classSTD'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierpaare']['classSTD'],
			'inputType' => 'select',
			'options_callback' => array('tl_turnierpaare','getKlassen'),
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
                        'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'classSTD2'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierpaare']['classSTD2'],
			'inputType' => 'select',
			'options_callback' => array('tl_turnierpaare','getKlassen'),
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
                        'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'classLAT'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierpaare']['classLAT'],
			'inputType' => 'select',
			'options_callback' => array('tl_turnierpaare','getKlassen'),
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
                        'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'classLAT2'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierpaare']['classLAT2'],
			'inputType' => 'select',
			'options_callback' => array('tl_turnierpaare','getKlassen'),
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
                        'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'aktiv'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierpaare']['aktiv'],
			'inputType' => 'checkbox',
			'filter'	=> true,
			'exclude'   => false,
			'sql'       => "char(1) NOT NULL default ''"
		),
		'beginn'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierpaare']['beginn'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
                        'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'ende'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierpaare']['ende'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
                        'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'www'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierpaare']['www'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
                        'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'password'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierpaare']['password'],
			'inputType' => 'text',
			'exclude'   => true,
			'sorting'   => false,
			'flag'      => 1,
			'save_callback'  => array(array('tl_turnierpaare','password_save_callback')),
                        'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL"
		),
		'password_reset'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierpaare']['password_reset'],
			'inputType' => 'checkbox',
			'exclude'   => true,
			'save_callback'  => array(array('tl_turnierpaare','password_reset_callback')),
                        'search'    => false,
			'sql'       => "int(10) unsigned NOT NULL default '0'"
		)
		
       )
);
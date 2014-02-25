<?php
class tl_turnierergebnisse extends Backend 
{ 
    /** 
     * Import the back end user object 
     */ 
    public function __construct() 
    { 
        parent::__construct(); 
        $this->import('BackendUser', 'User'); 
    } 
 
  public function getCouples() 
    { 
        $couples = array(); 
        // Get all the active couples 		  
        $objCouples = $this->Database->prepare("SELECT * 
                                                FROM tl_turnierpaare 
                                                WHERE 1 
                                                ORDER by Hnachname, Hvorname, Dnachname, Dvorname") 
                                      ->execute(); 
        while ($objCouples->next()) 
        { 
            $k = $objCouples->id; 
            $v = $objCouples->Hnachname; 
 
            if($objCouples->Hvorname) 
            { 
                $v .= ', '.$objCouples->Hvorname; 
            }
 
            if($objCouples->Dnachname) 
            { 
                $v .= ' - '.$objCouples->Dnachname; 
 
                if($objCouples->Dvorname) 
                { 
                    $v .= ', '.$objCouples->Dvorname; 
                } 
            } 
 
            $couples[$k] =$v; 
        } 
 
        return $couples; 
    }
	
} 
/**
 * Table tl_turnierergebnisse
 */
$GLOBALS['TL_DCA']['tl_turnierergebnisse'] = array
(
 
	// Config
	'config'   => array
	(
		'dataContainer'    => 'Table',
		'ptable' => 'tl_turnierpaare',
		'enableVersioning' => true,
		'sql'              => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid'=>'index'
			)
		),
	),
	
	
	// List
	'list'     => array
	(
		'sorting'           => array
		(
			'mode'        => 2,
			'fields'      => array('datum DESC', 'ort', 'pid'),
			'panelLayout' => 'filter,search,limit'
		),
		
		
		
		'label'             => array
		(
			'fields' => array('ort','pid:tl_turnierpaare.Hvorname','pid:tl_turnierpaare.Hnachname','pid:tl_turnierpaare.Dvorname','pid:tl_turnierpaare.Dnachname', 'platz', 'paare', 'klasse', 'kommentar'),
			'format' => '<strong>%s</strong><br><i>%s %s - %s %s</i> <strong>(%s/%s %s)</strong> %s'
		),
		
		
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
		
		
		
		'operations'        => array
		(
			'edit'   => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_turnierergebnisse']['edit'],
				'href'  => 'act=edit',
				'icon'  => 'edit.gif'
			),
			'delete' => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_turnierergebnisse']['delete'],
				'href'       => 'act=delete',
				'icon'       => 'delete.gif',
				'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show'   => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_turnierergebnisse']['show'],
				'href'       => 'act=show',
				'icon'       => 'show.gif',
				'attributes' => 'style="margin-right:3px"'
			),
		)
	),
	
	// Palettes
	'palettes' => array
	(
		'default'       => '{turnierergebnisse_plaar_legend},pid;{turnierergebnisse_platzierung_legend},platz,paare;{turnierergebnisse_datum_ort_klasse_legend}, datum,ort,klasse;{turnierergebnisse_kommentar_legend},kommentar'
),


// Fields
	'fields'   => array
	(
		'id'     => array
		(
			'sql' => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql' => "int(10) unsigned NOT NULL default '0'"
		),
		'pid' => array(
            'label' => &$GLOBALS['TL_LANG']['tl_turnierergebnisse']['pid'],
            'foreignKey' => 'tl_turnierpaare.id',
			'inputType' => 'select',
			'options_callback'  => array('tl_turnierergebnisse', 'getCouples'),
			'search'                  => false, 
            'sorting'                 => true,
			'filter'				=>true, 
            'sql' => "int(10) unsigned NOT NULL default '0'",
            'relation' => array(
                'type' => 'belongsTo',
                'load' => 'lazy'
            ),
            'eval' => array(
                'doNotShow' => true
            ),
        ),
		'platz'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierergebnisse']['platz'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
            'search'    => false,
			'eval'      => array(
				'mandatory'   => true,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'paare'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierergebnisse']['paare'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
            'search'    => false,
			'eval'      => array(
				'mandatory'   => true,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'ort'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierergebnisse']['ort'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => true,
			'flag'      => 11,
            'search'    => true,
			'eval'      => array(
				'mandatory'   => true,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'klasse'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierergebnisse']['klasse'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
            'search'    => false,
			'eval'      => array(
				'mandatory'   => true,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'kommentar'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierergebnisse']['kommentar'],
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
		/*'pid'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierergebnisse']['pid'],
			'inputType' => 'select',
			'foreignKey'=> 'tl_turnierpaare.id',
			'options_callback'  => array('tl_turnierergebnisse', 'getCouples'),
			'search'                  => false, 
            'sorting'                 => true,
			'filter'				=>true, 
            'eval'                    => array('mandatory'=>true) ,
			'sql'       => "varchar(255) NOT NULL default ''"
		),*/
		'datum'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierergebnisse']['datum'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => true,
			'flag'      => 6,
            'search'    => false,
			'eval'                    => array('mandatory'=>true, 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard', 'minlength' => 1, 'maxlength'=>64, 'rgxp' => 'date'),
			'sql'       => "int(10) unsigned NOT NULL default '0'"
		)
		
       )
);

?>
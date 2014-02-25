<?php
 
 class tl_turnierpaarbilder extends Backend 
{ 
    /** 
     * Import the back end user object 
     */ 
    public function __construct() 
    { 
        parent::__construct(); 
        $this->import('BackendUser', 'User'); 
    } 
 
	

} 
 
/**
 * Table tl_turnierpaarbilder
 */
$GLOBALS['TL_DCA']['tl_turnierpaarbilder'] = array
(
 
	// Config
	'config'   => array
	(
		'dataContainer'    => 'Table',
		'enableVersioning' => true,
		'ptable'			=> 'tl_turnierpaare',
		'sql'              => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid' => 'index'
			)
		),
	),
	
	
	// List
	'list'     => array
	(
		'sorting'           => array
		(
			'mode'        => 2,
			'fields'      => array(),
			'flag'        => 1,
			'panelLayout' => 'filter,sort,search'
		),
		
		
		
		'label'             => array
		(
			//
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
				'label' => &$GLOBALS['TL_LANG']['tl_turnierpaarbilder']['edit'],
				'href'  => 'act=edit',
				'icon'  => 'edit.gif'
			),
			/*'turnierergebnisse' => array(
                'label' => &$GLOBALS['TL_LANG']['tl_turnierpaarbilder']['turnierergebnisse'],
                'icon' => 'system/modules/turnierpaare/assets/images/ergebnisse.png',
                //'button_callback' => array(
                //    'tl_turnierpaarbilder',
                //    'buttonShowTurnierergebnisse'
                //)
				'href'       => 'act=show_ergebnisse',
            ),*/
			'delete' => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_turnierpaarbilder']['delete'],
				'href'       => 'act=delete',
				'icon'       => 'delete.gif',
				'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show'   => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_turnierpaarbilder']['show'],
				'href'       => 'act=show',
				'icon'       => 'show.gif',
				'attributes' => 'style="margin-right:3px"'
			),
			
		)
	),
	
	// Palettes
	'palettes' => array
	(
		'default'       => '{startbuchnummer_legend},startbuchnummer,aktiv;{password_legend}, password_reset;{herr_legend},Hvorname,Hnachname,Hemail,Htelefon;{dame_legend},Dvorname,Dnachname,Demail,Dtelefon;{startklasse_legend}, classSTD, classLAT, classSTD2, classLAT2;{info_legend}, beginn, ende, www'
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
            'label' => &$GLOBALS['TL_LANG']['tl_turnierpaarbilder']['pid'],
            'foreignKey' => 'tl_turnierpaare.Hname',
            'sql' => "int(10) unsigned NOT NULL default '0'",
            'relation' => array(
                'type' => 'belongsTo',
                'load' => 'lazy'
            ),
            'eval' => array(
                'doNotShow' => true
            ),
        ),
		'published' => array(
            'label' => &$GLOBALS['TL_LANG']['tl_turnierpaarbilder']['published'],
            'inputType' => 'checkbox',
            'filter' => true,
            'eval' => array(
                'isBoolean' => true,
                'submitOnChange' => true,
                'tl_class' => 'long'
            ),
            'sql' => "char(1) NOT NULL default '1'"
        ),
		//filename
        'name' => array(
            'sql' => "varchar(255) NOT NULL default ''",
            'search' => true,
        ),

        //path
        'path' => array('sql' => "varchar(255) NOT NULL default ''"),
	)
);
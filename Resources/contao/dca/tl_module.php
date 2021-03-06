<?php
/**
 * This file is part of con4gis,
 * the gis-kit for Contao CMS.
 *
 * @package    con4gis
 * @version    7
 * @author     con4gis contributors (see "authors.txt")
 * @license    LGPL-3.0-or-later
 * @copyright  Küstenschmiede GmbH Software & Design
 * @link       https://www.con4gis.org
 */

/**
 * Table tl_module
 */
//ToDo showFreeSeats, additionalDuration
$GLOBALS['TL_DCA']['tl_module']['palettes']['C4gReservation']   = '{title_legend},name,headline,type;{reservation_legend},reservation_types,withCapacity,showEndTime,showPrices,hide_selection; {reservation_notification_center_legend},  notification_type; {reservation_redirect_legend}, reservation_redirect_site, privacy_policy_text, privacy_policy_site';

$GLOBALS['TL_DCA']['tl_module']['palettes']['C4gReservationCancellation'] = '{title_legend},name,headline,type;{reservation_legend},reservation_types; {reservation_notification_center_legend}, notification_type_contact_request; {reservation_redirect_legend}, reservation_redirect_site;'; //{caption_legend}, captionReservationType, captionBeginDate, captionReservationObject, captionAdditionalParams, captionComment, captionReservationId';

$GLOBALS['TL_DCA']['tl_module']['fields']['reservation_addition_booking_params'] = array();

$GLOBALS['TL_DCA']['tl_module']['fields']['reservation_types'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['c4g_reservation']['fields']['reservation_types'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'options_callback'        => array('tl_module_c4g_reservation','getAllTypes'),
    'eval'                    => array('mandatory'=>false, 'multiple'=>true),
    'sql'                     => "blob NULL"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['withCapacity'] = array
(   'label'             => &$GLOBALS['TL_LANG']['tl_module']['c4g_reservation']['fields']['withCapacity'],
    'exclude'           => true,
    'filter'            => true,
    'inputType'         => 'checkbox',
    'sql'               => "int(1) unsigned NULL default 0"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['showFreeSeats'] = array
(   'label'             => &$GLOBALS['TL_LANG']['tl_module']['c4g_reservation']['fields']['showFreeSeats'],
    'exclude'           => true,
    'filter'            => true,
    'inputType'         => 'checkbox',
    'sql'               => "int(1) unsigned NULL default 0"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['showEndTime'] = array
(   'label'             => &$GLOBALS['TL_LANG']['tl_module']['c4g_reservation']['fields']['showEndTime'],
    'exclude'           => true,
    'filter'            => true,
    'inputType'         => 'checkbox',
    'sql'               => "int(1) unsigned NULL default 0"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['showPrices'] = array
(   'label'             => &$GLOBALS['TL_LANG']['tl_module']['c4g_reservation']['fields']['showPrices'],
    'exclude'           => true,
    'filter'            => true,
    'inputType'         => 'checkbox',
    'sql'               => "int(1) unsigned NULL default 0"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['additionalDuration'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['c4g_reservation']['fields']['additionalDuration'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('multiple' => false,'mandatory'=>false,'includeBlankOption'=>true),
    'sql'                     => "blob NULL"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['hide_selection'] = array
(
    'label'			=> &$GLOBALS['TL_LANG']['tl_module']['c4g_reservation']['fields']['hide_selection'],
    'exclude' 		=> true,
    'inputType'     => 'multiColumnWizard',
    'eval' 			=> array
    (
        'columnFields' => array
        (
            'additionaldatas' => array
            (
                'label'                   => &$GLOBALS['TL_LANG']['tl_module']['c4g_reservation']['additionaldatas'],
                'exclude'                 => true,
                'default'                 =>'',
                'inputType'               => 'select',
                'options_callback'        => array('tl_module_c4g_reservation','getOptional'),
                'eval'                    => array('multiple' => false,'mandatory'=>false,'includeBlankOption'=>true),


            ),
            'binding' => array
            (
                'label'                   => &$GLOBALS['TL_LANG']['tl_module']['c4g_reservation']['binding'],
                'exclude'                 => true,
                'inputType'               => 'checkbox',
                'eval'                    => array('multiple' => false,'mandatory'=>false,'alwaysSave'=>true),

            )
        ),
    ),
    'sql' => "blob NULL"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['notification_type'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['c4g_reservation']['fields']['notification_type'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'foreignKey'              => 'tl_nc_notification.title',
    'eval'                    => array('multiple' => true),
    'sql'                     => "varchar(255) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['notification_type_contact_request'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['c4g_reservation']['fields']['notification_type_contact_request'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'foreignKey'              => 'tl_nc_notification.title',
    'eval'                    => array('multiple' => true),
    'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['appearance_themeroller_css'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['c4g_reservation']['fields']['appearance_themeroller_css'],
    'exclude'                 => true,
    'inputType'               => 'fileTree',
    'eval'                    => array('tl_class'=>'w50 wizard', 'fieldType'=>'radio', 'files'=>true, 'extensions'=>'css'),
    'sql'                     => "binary(16) NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['reservation_redirect_site'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['c4g_reservation']['fields']['redirect_site'],
    'exclude'                 => true,
    'inputType'               => 'pageTree',
    'foreignKey'              => 'tl_page.title',
    'eval'                    => array('mandatory'=>true, 'fieldType'=>'radio'),
    'sql'                     => "int(10) unsigned NOT NULL default '0'",
    'relation'                => array('type'=>'hasOne', 'load'=>'eager')
);
$GLOBALS['TL_DCA']['tl_module']['fields']['privacy_policy_text'] =  array (
    'label'                   => &$GLOBALS['TL_LANG']['tl_c4g_reservation']['privacy_policy_text'],
    'exclude'                 => true,
    'filter'                  => false,
    'search'                  => false,
    'sorting'                 => false,
    'inputType'               => 'textarea',
    'default'                 => '',
    'eval'                    => array('mandatory'=>true, 'feEditable'=>true, 'feViewable'=>true, 'tl_class'=>'long'),
    'sql'                     => "text NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['privacy_policy_site'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['c4g_reservation']['fields']['privacy_policy_site'],
    'exclude'                 => true,
    'inputType'               => 'pageTree',
    'foreignKey'              => 'tl_page.title',
    'eval'                    => array('mandatory'=>true, 'fieldType'=>'radio'),
    'sql'                     => "int(10) unsigned NOT NULL default '0'",
    'relation'                => array('type'=>'hasOne', 'load'=>'eager')
);

class tl_module_c4g_reservation extends Backend {

    /**
     * @return mixed
     */
    public function getAllTypes()
    {
        $types = $this->Database->prepare("SELECT id,caption FROM tl_c4g_reservation_type ORDER BY caption")
            ->execute();
        while ($types->next()) {
            $return[$types->id] = $types->caption;
        }
        return $return;
    }

    public function getOptional($dc)
    {
        System::loadLanguageFile('tl_c4g_reservation');
        $columnsFormatted=[];
        $columnsFormatted['organisation'] = $GLOBALS['TL_LANG']['tl_c4g_reservation']['organisation'][0];
        $columnsFormatted['phone'] = $GLOBALS['TL_LANG']['tl_c4g_reservation']['phone'][0];
        $columnsFormatted['address'] = $GLOBALS['TL_LANG']['tl_c4g_reservation']['address'][0];
        $columnsFormatted['postal'] = $GLOBALS['TL_LANG']['tl_c4g_reservation']['postal'][0];
        $columnsFormatted['city'] = $GLOBALS['TL_LANG']['tl_c4g_reservation']['city'][0];
        $columnsFormatted['comment'] = $GLOBALS['TL_LANG']['tl_c4g_reservation']['comment'][0];

        return $columnsFormatted;

    }
}

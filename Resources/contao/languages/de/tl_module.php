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
 * Fields
 */
$GLOBALS['TL_LANG']['tl_module']['reservation_legend']         = 'Reservierungsobjekte';
$GLOBALS['TL_LANG']['tl_module']['reservation_notification_center_legend'] = 'Notification Center';
$GLOBALS['TL_LANG']['tl_module']['reservation_jquery_theme_legend']        = 'jQuery UI-Theme';
$GLOBALS['TL_LANG']['tl_module']['reservation_redirect_legend']            = 'Weiterleitung';
$GLOBALS['TL_LANG']['tl_module']['c4g_reservation']['fields']['reservation_types'] = array('Reservierungsarten', 'Wählen Sie die bei der Reservierung im Frontend zu berücksichigenden Reservierungsarten (Räume, Tische, ...). Bei keiner Auswahl werden alle Reservierungsobjekte geladen.');
$GLOBALS['TL_LANG']['tl_module']['c4g_reservation']['fields']['appearance_themeroller_css'] = array('jQuery UI ThemeRoller CSS Datei', 'Optional: wählen Sie eine, mit dem jQuery UI ThemeRoller erstellte, CSS-Datei aus, um den Stil des Moduls entsprechend anzupassen.');
$GLOBALS['TL_LANG']['tl_module']['c4g_reservation']['fields']['redirect_site']              = array('Weiterleitungsseite', 'Nach der Buchung wird hierhin weitergeleitet.');
$GLOBALS['TL_LANG']['tl_module']['c4g_reservation']['fields']['privacy_policy_site']        = array('Link zur Datenschutzerklärung', 'Diese Seite wird für die Bestätigung der Datenschutzerklärung verlinkt.');
$GLOBALS['TL_LANG']['tl_module']['c4g_reservation']['fields']['privacy_policy_text']        = array('Datenschutzkommentar', 'Dieser Datenschutzkommentar taucht vor der Checkbox zur Einwilligung auf.');
$GLOBALS['TL_LANG']['tl_module']['c4g_reservation']['fields']['notification_type']          = array('Benachrichtigung', 'Wählen Sie die Benachrichtigung aus');
$GLOBALS['TL_LANG']['tl_module']['c4g_reservation']['fields']['notification_type_contact_request']  = array('Benachrichtigung der Kontaktanfrage', 'Wählen Sie die Benachrichtigung für das Versenden der Kontaktanfrage aus');
$GLOBALS['TL_LANG']['tl_module']['c4g_reservation']['additionaldatas']           = array("Optionale Datenfelder.","Reihenfolge hier entspricht der Anzeige im Frontend");
$GLOBALS['TL_LANG']['tl_module']['c4g_reservation']['mandatory']           = array("Pflichtfeld?","");
$GLOBALS['TL_LANG']['tl_module']['c4g_reservation']['binding']           = array("Pflichtfeld?","Soll dieses Datenfeld als Pflichtfeld im Frontend angezeigt werden");
$GLOBALS['TL_LANG']['tl_module']['c4g_reservation']['fields']['hide_selection'] = array("Datenfelder Hinzufügen","");
$GLOBALS['TL_LANG']['tl_module']['c4g_reservation']['fields']['additionalDuration'] = array("Kunde kann Verweildauer selber angeben (BETA)","Mit anhaken erscheint im Frontend ein neues Feld in welchem der Kunde seine verweildauer angibt");
$GLOBALS['TL_LANG']['tl_module']['c4g_reservation']['fields']['withCapacity'] = array("Kunde kann Personenanzahl angeben","Der Kunde kann die Personenanzahl angeben. Dieses wird bspw. für eine Tischreservierung im Restaurant benötigt.");
$GLOBALS['TL_LANG']['tl_module']['c4g_reservation']['fields']['showFreeSeats'] = array("Freie Plätze anzeigen","Offene Plätze werden dargestellt.");
$GLOBALS['TL_LANG']['tl_module']['c4g_reservation']['fields']['showEndTime'] = array("Die Endzeiten werden mit ausgegeben","Die Endzeiten werden mit dargestellt (abhängig von der Konfiguration).");
$GLOBALS['TL_LANG']['tl_module']['c4g_reservation']['fields']['showPrices'] = array("Preise anzeigen","Preise werden dargestellt.");

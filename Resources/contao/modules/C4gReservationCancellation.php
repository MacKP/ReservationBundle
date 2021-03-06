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

namespace con4gis\ReservationBundle\Resources\contao\modules;

use con4gis\ProjectsBundle\Classes\Actions\C4GSaveAndRedirectDialogAction;
use con4gis\ProjectsBundle\Classes\Actions\C4GSendEmailNotificationAction;
use con4gis\ProjectsBundle\Classes\Buttons\C4GBrickButton;
use con4gis\ProjectsBundle\Classes\Common\C4GBrickConst;
use con4gis\ProjectsBundle\Classes\Dialogs\C4GBrickDialog;
use con4gis\ProjectsBundle\Classes\Fieldtypes\C4GButtonField;
use con4gis\ProjectsBundle\Classes\Fieldtypes\C4GHeadlineField;
use con4gis\ProjectsBundle\Classes\Fieldtypes\C4GKeyField;
use con4gis\ProjectsBundle\Classes\Fieldtypes\C4GTextField;
use con4gis\ProjectsBundle\Classes\Framework\C4GBrickModuleParent;
use con4gis\ProjectsBundle\Classes\Views\C4GBrickViewType;
use con4gis\ReservationBundle\Classes\C4gReservationBrickTypes;
use con4gis\ReservationBundle\Resources\contao\models\C4gReservationCancellationModel;
use con4gis\ReservationBundle\Resources\contao\models\C4gReservationModel;

class C4gReservationCancellation extends C4GBrickModuleParent
{
    protected $tableName    = 'tl_c4g_reservation';
    protected $modelClass   = C4gReservationModel::class;
    protected $languageFile = 'fe_c4g_reservation_cancellation';
    protected $brickKey     = C4gReservationBrickTypes::BRICK_RESERVATION_CANCELLATION;
    protected $viewType     = C4GBrickViewType::PUBLICFORM;
    protected $brickScript  = 'bundles/con4gisreservation/js/c4g_brick_reservation.js';
    protected $brickStyle   = 'bundles/con4gisreservation/css/c4g_brick_reservation.css';
    protected $withNotification = true;


    public function initBrickModule($id)
    {
        parent::initBrickModule($id);

        $this->dialogParams->setWithoutGuiHeader(true);

        $this->dialogParams->deleteButton(C4GBrickConst::BUTTON_SAVE);
        $this->dialogParams->deleteButton(C4GBrickConst::BUTTON_SAVE_AND_NEW);
        $this->dialogParams->deleteButton(C4GBrickConst::BUTTON_DELETE);
        $this->dialogParams->setWithoutGuiHeader(true);
        $this->dialogParams->setRedirectSite($this->reservation_redirect_site);
        $this->brickCaption = $GLOBALS['TL_LANG']['fe_c4g_reservation_cancellation']['brick_caption'];
        $this->brickCaptionPlural = $GLOBALS['TL_LANG']['fe_c4g_reservation_cancellation']['brick_caption_plural'];
    }

    public function addFields()
    {
        $fieldList = array();

        $idField = new C4GKeyField();
        $idField->setFieldName('id');
        $idField->setEditable(false);
        $idField->setFormField(false);
        $idField->setSortColumn(false);
        $fieldList[] = $idField;

        $lastnameField = new C4GTextField();
        $lastnameField->setFieldName('lastname');
        $lastnameField->setTitle($GLOBALS['TL_LANG']['fe_c4g_reservation_cancellation']['lastname']);
        $lastnameField->setColumnWidth(10);
        $lastnameField->setSortColumn(false);
        $lastnameField->setTableColumn(false);
        $lastnameField->setMandatory(true);
        $lastnameField->setNotificationField(true);
        $fieldList[] = $lastnameField;

        $reservationIdField = new C4GTextField();
        $reservationIdField->setFieldName('reservation_id');
        $reservationIdField->setTitle($GLOBALS['TL_LANG']['fe_c4g_reservation_cancellation']['reservation_id']);
        $reservationIdField->setColumnWidth(10);
        $reservationIdField->setSortColumn(true);
        $reservationIdField->setTableColumn(true);
        $reservationIdField->setMandatory(true);
        $reservationIdField->setSize(13);
        $reservationIdField->setMaxLength(13);
        $reservationIdField->setUnique(true);
        $reservationIdField->setNotificationField(true);
        $fieldList[] = $reservationIdField;

        $clickButton = new C4GBrickButton(C4GBrickConst::BUTTON_CLICK, $GLOBALS['TL_LANG']['fe_c4g_reservation_cancellation']['button_cancellation'], $visible=true, $enabled=true, $action = '', $accesskey = '', $defaultByEnter = true);
        $buttonField = new C4GButtonField($clickButton);
        $buttonField->setOnClickType(C4GBrickConst::ONCLICK_TYPE_SERVER);
        $buttonField->setOnClick('clickCancellation');
        $buttonField->setWithoutLabel(true);
        $fieldList[] = $buttonField;

        $this->fieldList = $fieldList;
    }


    public function clickCancellation($values, $putVars) {
        $lastname = $putVars['lastname'];
        $key  = $putVars['reservation_id'];

        if (!C4GBrickDialog::checkMandatoryFields($this->fieldList, $putVars)) {
            return array('usermessage' => $GLOBALS['TL_LANG']['FE_C4G_DIALOG']['USERMESSAGE_MANDATORY']);
        }

        $reservation = C4gReservationModel::findOneBy('reservation_id',$key);
        if ($reservation) {
            $putVars['email'] = $reservation->email;
        }

        if (C4gReservationCancellationModel::cancellation($lastname, $key)) {
            $action = new C4GSendEmailNotificationAction($this->getDialogParams(), $this->getListParams(), $this->getFieldList(), $putVars, $this->getBrickDatabase());
            $action->setModule($this);
            $action->setCloseDialog(false);
            $result = $action->run();

            if ($this->dialogParams->getRedirectSite() && (($jumpTo = \PageModel::findByPk($this->dialogParams->getRedirectSite())) !== null)) {
                $result['jump_to_url'] = $jumpTo->getFrontendUrl();
                return $result;
            }
        } else {
            return array('usermessage' => $GLOBALS['TL_LANG']['fe_c4g_reservation_cancellation']['cancellation_failed']);
        }
    }
}


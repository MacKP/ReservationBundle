function getWeekdate(date) {

    //ToDo internationalize
    if (date.indexOf(".") > 0) {
        var arrDate = date.split(".")
        var y = arrDate[2];
        var m = arrDate[1];
        var d = arrDate[0];
        //important for safari browser
        m = m<10?"0"+m:m;
        d = d<10?"0"+d:d;

        date = y + "/" + m + "/" + d;
    } else if (date.indexOf("/") > 0) {
        var arrDate = date.split("/")
        var y = arrDate[2];
        var m = arrDate[1];
        var d = arrDate[0];
        //important for safari browser
        m = m<10?"0"+m:m;
        d = d<10?"0"+d:d;

        date = y + "/" + m + "/" + d;
    }

    var jsdate = new Date(date);
    return jsdate.getDay();
}

function isSunday(date, fieldName) {
    if (getWeekdate(date) === 0) {
        return true;
    } else {
        return false;
    }
}

function isMonday(date, fieldName) {
    if (getWeekdate(date) === 1) {
        return true;
    } else {
        return false;
    }
}

function isTuesday(date, fieldName) {
    if (getWeekdate(date) === 2) {
        return true;
    } else {
        return false;
    }
}

function isWednesday(date, fieldName) {
    if (getWeekdate(date) === 3) {
        return true;
    } else {
        return false;
    }
}

function isThursday(date, fieldName) {
    if (getWeekdate(date) === 4) {
        return true;
    } else {
        return false;
    }
}

function isFriday(date, fieldName) {
    if (getWeekdate(date) === 5) {
        return true;
    } else {
        return false;
    }
}

function isSaturday(date, fieldName) {
    if (getWeekdate(date) === 6) {
        return true;
    } else {
        return false;
    }
}

function setObjectId(object, typeid) {
    var className = object.className;
    var typeId = typeid;
    var selectField = document.getElementById("c4g_reservation_object_"+typeId);
    var reservationObjects = jQuery(document.getElementsByClassName("displayReservationObjects"));
    var emptyOption = null;
    var val = -1;

    if (selectField) {
        jQuery(selectField).show();
        reservationObjects ? reservationObjects.show() : false;
        if (className) {
            val = className.split("_")[2];
            var objects = val.split('-');
            jQuery(selectField).val(objects[0]).change();
        }
    }
    hideOptions(reservationObjects,typeId, objects ? objects : val);
    return true;
}

function hideOptions(reservationObjects,typeId,values) {
    if (reservationObjects) {
        if (typeId == -1) {
            var typeField = document.getElementById("c4g_reservation_type");
            typeId = typeField ? typeField.value : -1;
        }
        var selectField = document.getElementById("c4g_reservation_object_"+typeId);
        var first = jQuery.isArray(values) ? values[0] : values;
        if (selectField) {
            for (i = 0; i < selectField.options.length; i++) {
                var option = selectField.options[i];
                var min = option.getAttribute('min') ? parseInt(option.getAttribute('min')) : 1;
                var max = option.getAttribute('max') ? parseInt(option.getAttribute('max')) : 1;
                var desiredCapacity = document.getElementById("c4g_desiredCapacity_"+typeId);
                var capacity = desiredCapacity ? desiredCapacity.value : 1;

                //not in values
                var foundValue = false;
                if (jQuery.isArray(values)) {
                    for (j = 0; j < values.length; j++) {
                        if (values[j] == option.value) {
                            foundValue = true;
                        }
                    }
                }

                if (!foundValue) {
                    jQuery(selectField).children('option[value="'+option.value+'"]').attr('disabled','disabled');
                } else {
                    jQuery(selectField).children('option[value="'+option.value+'"]').removeAttr('disabled');
                    if (min && max && capacity && capacity > 0) {
                        if ((capacity < min) || (capacity > max)) {
                            jQuery(selectField).children('option[value="'+option.value+'"]').attr('disabled','disabled');
                        } else {
                            jQuery(selectField).children('option[value="'+option.value+'"]').removeAttr('disabled');
                            if ((first == -1) && (option.value != -1)) {
                                first = option.value;
                            }
                        }
                    }
                }
            }

            if (parseInt(first) >= 0) {
                jQuery(selectField).val(first).change();
                jQuery(selectField).children('option[value="-1"]').attr('disabled','disabled');

                jQuery(selectField).removeAttr('disabled');
            } else {
                jQuery(selectField).children('option[value="-1"]').removeAttr('disabled');
                jQuery(selectField).val("-1").change();
                jQuery(selectField).prop("disabled", true);
            }
        }
    }
}

function setTimeset(object, id, additionalId, callFunction) {
    var brick_api = apiBaseUrl+"/c4g_brick_ajax";
    var elementId = 0;
    var date = 0;
    var val = -1;
    var nameField = '';

    if (additionalId == -1) {
        jQuery(document.getElementsByClassName('reservation_time_button')) ? jQuery(document.getElementsByClassName('reservation_time_button')).hide() : false;
        jQuery(document.getElementsByClassName('displayReservationObjects')) ? jQuery(document.getElementsByClassName('displayReservationObjects')).hide() : false;
    } else {
        elementId = "c4g_beginDate_"+additionalId;
        date = document.getElementById(elementId).value;
    }
    var durationNode = document.getElementById("c4g_duration");
    if (durationNode) {
        var duration = durationNode.value;
    }

    C4GCallOnChangeMethodswitchFunction(object);
    C4GCallOnChange(object);

    //hotfix dates with slashes
    if (date && date.indexOf("/")) {
        date = date.replace("/", "~");
        date = date.replace("/", "~");
    }

    if (id && callFunction && date && additionalId) {
        jQuery.ajax({
            dataType: "json",
            url: brick_api + "/"+id+"/" + "buttonclick:" + callFunction + ":"+ date +":"+additionalId+ ":"+ duration +  "?id=0",
            success: function (data) {
                var timeGroup = document.getElementById("c4g_beginTime_"+additionalId+"00"+getWeekdate(date));
                var radioGroups = timeGroup.parentElement.getElementsByClassName("c4g_brick_radio_group");
                var timeList = [];
                var objectList = [];
                var times = data['times'];
                var size = times.length;

                jQuery(document.getElementsByClassName('reservation_time_button_'+additionalId)) ? jQuery(document.getElementsByClassName('reservation_time_button_'+additionalId)).show() : false;
                var iterator = 0;
                for (let key in times) {
                    var dataTime = times[key]['id'];
                    var dataObjects = times[key]['objects'];

                    timeList[iterator] = dataTime;
                    objectList[iterator] = dataObjects;
                    iterator++;
                }

                var selectField = document.getElementById("c4g_reservation_object_"+additionalId);
                var capMin = 1;
                var capMax = 1;
                if (selectField) {
                    for (i = 0; i < selectField.options.length; i++) {
                        var option = selectField.options[i];
                        var min = option.getAttribute('min') ? parseInt(option.getAttribute('min')) : 1;
                        if ((min == -1) || (min < capMin)) {
                            capMin = min;
                        }
                        var max = option.getAttribute('max') ? parseInt(option.getAttribute('max')) : 1;
                        if ((max == -1) || (max > capMax)) {
                            capMax = max;
                        }
                    }
                }

                var desiredCapacity = document.getElementById("c4g_desiredCapacity_"+additionalId);
                var capacity = desiredCapacity ? desiredCapacity.value : 1;

                if (radioGroups) {
                    for (i = 0; i < radioGroups.length; i++) {
                        //try {
                        for (j = 0; j < radioGroups[i].children.length; j++) {
                            if (radioGroups[i].children[j].style && radioGroups[i].children[j].style == "display:none") {
                                continue;
                            }

                            for (k = 0; k < radioGroups[i].children[j].children.length; k++) {
                                var value = jQuery(radioGroups[i].children[j].children[k]).val();
                                if (value && parseInt(value)) {
                                    namefield = radioGroups[i].children[j].children[k].getAttribute('name').substr(1);
                                    var arrindex = jQuery.inArray(parseInt(value), timeList);
                                    var activateTimeButton = -1;
                                    if (arrindex !== -1) {
                                        for (l = 0; l < objectList[arrindex].length; l++) {
                                            if (objectList[arrindex][l]['id'] != -1) {
                                                if ((objectList[arrindex][l]['act'] < objectList[arrindex][l]['max'] )) {
                                                    activateTimeButton = (activateTimeButton < objectList[arrindex][l]['act']) ? objectList[arrindex][l]['act'] : activateTimeButton;
                                                }
                                            }
                                        }
                                    }

                                    if ((activateTimeButton >= 0) && (activateTimeButton < capMax) && (capacity >= capMin) && (capacity <= capMax)) {
                                        let objstr = '';
                                        for (l = 0; l < objectList[arrindex].length; l++) {
                                            let listObj = objectList[arrindex][l];
                                            if (l == 0) {
                                                objstr = objstr + listObj['id'];
                                            } else {
                                                objstr = objstr + '-' + listObj['id'];
                                            }

                                            var optionidx = -1;
                                            for (var m = 0; m < jQuery(selectField).length; m++) {
                                                if (selectField[m].value == listObj['id']) {
                                                    optionidx = m;
                                                    break;
                                                }
                                            }

                                            //ToDo wrong position move to setObjectId
                                            // if (optionidx !== -1) {
                                            //     if (listObj['showSeats']) {
                                            //         var optionText = selectField[optionidx].text;
                                            //         var pos = optionText.lastIndexOf('[');
                                            //         if (pos != -1) {
                                            //             optionText = optionText.substr(0, pos-1);
                                            //         }
                                            //         selectField[optionidx].text = optionText + ' ['+listObj['act']+'/'+listObj['max']+']';
                                            //     }
                                            // }

                                        }

                                        if (objstr != 'undefined') {
                                            jQuery(radioGroups[i].children[j].children[k]).removeClass().addClass("radio_object_" + objstr);
                                            jQuery(radioGroups[i].children[j].children[k]).attr('disabled', false);
                                        }

                                        val = objectList[arrindex][0]['id']; //first valid option
                                    } else {
                                        jQuery(radioGroups[i].children[j].children[k]).removeClass().addClass("radio_object_disabled");
                                        jQuery(radioGroups[i].children[j].children[k]).attr('disabled', true);
                                    }
                                }
                            }
                        }
                        /*} catch (err) {
                            console.log(err);
                        }*/
                    }
                }

                if (nameField) {
                    var valueElement = document.getElementById(nameField);
                    if (valueElement) {
                        valueElement.value = '';
                    }

                    var reservation_time_button = jQuery('.reservation_time_button_'+additionalId+' input[type = "radio"]');
                    reservation_time_button.prop( "checked", false );
                }
            }
        })
    }

    var reservationObjects = document.getElementsByClassName("displayReservationObjects");
    hideOptions(reservationObjects,additionalId, val);
}
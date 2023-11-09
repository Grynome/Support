// Partner
// form
$('.btn-store-partner').on('click', function () {
    if ($('#partner-name').val() === "" || $('#contact-person').val() === "" || $('#adds-partner').val() === "" || $('#phone-partner').val() === "" || $('#mail-partner').val() === "") {
        if ($('#partner-name').val() === "" && $('#contact-person').val() === "" && $('#adds-partner').val() === "" && $('#phone-partner').val() === "" && $('#mail-partner').val() === "") {
            Swal.fire({
                title: "All Field's cannot be empty!",
                icon: "warning",
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK',
            });
        } else if ($('#partner-name').val() === "") {
            Swal.fire({
                title: "Partner name its empty!",
                icon: "warning",
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK',
            });
        } else if ($('#contact-person').val() === "") {
            Swal.fire({
                title: "Contact its empty!",
                icon: "warning",
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK',
            });
        } else if ($('#adds-partner').val() === "") {
            Swal.fire({
                title: "Address its empty!",
                icon: "warning",
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK',
            });
        } else if ($('#phone-partner').val() === "") {
            Swal.fire({
                title: "Phone its empty!",
                icon: "warning",
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK',
            });
        } else if ($('#mail-partner').val() === "") {
            Swal.fire({
                title: "Mail its empty!",
                icon: "warning",
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK',
            });
        }
    } else {
        Swal.fire({
            title: "Continue to Adding Partner?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Yes',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                jQuery("#form-partner").submit();
            }
        })
    }
    return false;
});
// view
for (let i = 0; i < 50; i++) {
    $('.destroy-ptn' + i + '').on('click', function () {

        Swal.fire({
            title: "Are u sure to delete this item?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Yes',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

                jQuery('#remove-ptn' + i + '').submit();
            }
        });
        return false;
    });
}
// Project
// form
$('.select-partner').click(function () {
    let partner_id = $(this).closest('tr').find('td:eq(1)').text().trim();
    let partner_name = $(this).closest('tr').find('td:eq(2)').text().trim();
    $('#partner-id').val(partner_id);
    $('#name-partner').val(partner_name);
    $('#find-partner').modal('hide');
});
// view
for (let i = 0; i < 50; i++) {
    $('.remove-prj' + i + '').on('click', function () {

        Swal.fire({
            title: "Are u Sure to delete this Item?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Save'
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

                jQuery('#remove-prj' + i + '').submit();
            }
        });
        return false;
    });
}
// Service Point
// form
$('.select-head').click(function () {
    let head_id = $(this).closest('tr').find('td:eq(1)').text();
    let name_head = $(this).closest('tr').find('td:eq(2)').text();
    $('#head-of-sp').val(head_id);
    $('#name-head').val(name_head);
    $('#find-head').modal('hide');
});
// view
for (let i = 0; i < 50; i++) {
    $('.delete-sp' + i + '').on('click', function () {
        Swal.fire({
            title: "Remove this Item?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#34a853',
            confirmButtonText: 'Sure!',
            cancelButtonColor: '#d33',
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                jQuery('#disappear-sp' + i + '').submit();
            }
        });
        return false;
    });
}
// Severity
// view
$('.store-sev').on('click', function () {

    if ($('#severity-name').val() === "") {
        swal.fire({
            title: "Plese insert Severity name!",
            icon: "info",
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK',
        });
    } else {

        jQuery("#form-sev").submit();
    }
    return false;
});
for (let i = 0; i < 50; i++) {
    $('.edit-sev' + i + '').on('click', function () {

        swal.fire({
            title: "Update this data!?",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: '#34a853',
            confirmButtonText: 'Sure!',
            cancelButtonColor: '#d33',
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {

                jQuery('#form-edit-sev' + i + '').submit();
            }
        });
    });
}
for (let i = 0; i < 50; i++) {
    $('.destroy-sev' + i + '').on('click', function () {

        swal.fire({
            title: "Data will be deleted!?",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: '#34a853',
            confirmButtonText: 'Next!',
            cancelButtonColor: '#d33',
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {

                jQuery('#destroy-sev' + i + '').submit();
            }
        });
    });
}
// SLA
// view
$('.add_sla').on('click', function () {
    if ($('#sla_name').val() === "" && $('#longer').val() === "" && $('#condition').val() === "") {
        Swal.fire({
            title: "All Field Cannot be Empty",
            icon: "warning",
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK',
        });
    } else if ($('#sla_name').val() === "") {
        Swal.fire({
            title: "Field SLA name cannot be Empty!",
            icon: "warning",
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK',
        });
    } else if ($('#longer').val() === "") {
        Swal.fire({
            title: "Field Time cannot be Empty!",
            icon: "warning",
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK',
        });
    } else if ($('#condition').val() === "") {
        Swal.fire({
            title: "Field Condition cannot be Empty!",
            icon: "warning",
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK',
        });
    } else {
        jQuery("#form_add_sla").submit();
    }
    return false;
});
for (let i = 0; i < 50; i++) {
    $('.edit-sla' + i + '').on('click', function () {
        Swal.fire({
            title: "Are u Sure Update this SLA?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#34a853',
            confirmButtonText: 'Next',
            cancelButtonColor: '#d33',
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {

                jQuery('#form_edit_sla' + i + '').submit();
            }
        });
        return false;
    });
    $('.remove-sla' + i + '').on('click', function () {
        Swal.fire({
            title: "Remove this item?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#34a853',
            confirmButtonText: 'Next',
            cancelButtonColor: '#d33',
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                jQuery('#remove_sla' + i + '').submit();
            }
        });
        return false;
    });
}
// Source
// view
$('.store-src').on('click', function () {

    if ($('#source-name').val() === "" && $('#source-detail').val() === "") {
        Swal.fire({
            title: "All Field Cannot be Empty",
            icon: "warning",
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK',
        });
    } else if ($('#source-name').val() === "") {
        Swal.fire({
            title: "Field Name Cannot be Empty",
            icon: "warning",
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK',
        });
    } else if ($('#source-detail').val() === "") {
        Swal.fire({
            title: "Field Detail Cannot be Empty",
            icon: "warning",
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK',
        });
    } else {

        jQuery("#store_src").submit();
    }
    return false;
});
$('.store-ktgr-pd').on('click', function () {

    if ($('#ktgrPD-name').val() === "") {
        Swal.fire({
            title: "Field still empty!",
            text: "Pls fill the field",
            icon: "warning",
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK',
        });
    } else {
        jQuery("#str-ktgrPD").submit();
    }
    return false;
});
for (let i = 0; i < 50; i++) {
    // Source
        $('.edit-src' + i + '').on('click', function () {
            Swal.fire({
                title: "Continues Edit?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#34a853',
                confirmButtonText: 'Yes',
                cancelButtonColor: '#d33',
                cancelButtonText: "No"
            }).then((result) => {
                if (result.isConfirmed) {

                    jQuery('#form_edit_src' + i + '').submit();
                }
            });

            return false;
        });
        $('.remove-src' + i + '').on('click', function () {
            Swal.fire({
                title: "Are u Sure to Remove this sourece?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#34a853',
                confirmButtonText: 'Next',
                cancelButtonColor: '#d33',
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    jQuery('#remove_src' + i + '').submit();
                }
            });

            return false;
        });
    // END Source
    // KTGR Pending
        $('.edit-ktgrPD' + i + '').on('click', function () {
            Swal.fire({
                title: "Continues Edit?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#34a853',
                confirmButtonText: 'Yes',
                cancelButtonColor: '#d33',
                cancelButtonText: "No"
            }).then((result) => {
                if (result.isConfirmed) {
                    jQuery('#fm-ktgrPD' + i + '').submit();
                }
            });

            return false;
        });
        $('.remove-ktgrPD' + i + '').on('click', function () {
            Swal.fire({
                title: "Are u Sure to Remove this Data?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#34a853',
                confirmButtonText: 'Next',
                cancelButtonColor: '#d33',
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    jQuery('#remove-ktgrPD' + i + '').submit();
                }
            });

            return false;
        });
    // END KTGR Pending
}
// Ticket
// Detil
$('.change-part-reqs').on('click', function () {

    let status = document.getElementById('status-part-reqs').dataset.statusrqs;
    if (status == 'Yes') {
        var title = "No need Parts?";
        var text = "Status of part Request will be change to No!";
    } else {
        var title = "Need Parts?";
        var text = "Status of part Request will be change to Yes!";
    }
    Swal.fire({
        title: title,
        text: text,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#34a853',
        confirmButtonText: 'Yes',
        cancelButtonColor: '#d33',
        cancelButtonText: "No"
    }).then((result) => {
        if (result.isConfirmed) {

            jQuery('#form-change-part-reqs').submit();
        }
    });
    return false;
});
$('.send-to-engineer').on('click', function () {

    Swal.fire({
        title: "Tickets Ready?",
        text: "Ticket will be sent to engineer!",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#34a853',
        confirmButtonText: 'Yes',
        cancelButtonColor: '#d33',
        cancelButtonText: "No"
    }).then((result) => {
        if (result.isConfirmed) {
            jQuery('#form-send-ticket-to-engineer').submit();
        }
    });
    return false;
});
for (let i = 0; i < 50; i++) {
    $('.btn-update-journey' + i + '').on('click', function () {
        $('#part-detail').modal('hide');
        if ($('#cek-journey-part' + i + '').val() === "0") {
            var text = "This part will be update to send!";
        } else {
            var text = "The part will be update to received!";
        }
        Swal.fire({
            title: "Update?",
            text: text,
            icon: 'question',
            showCancelButton: false,
            showDenyButton: true,
            confirmButtonColor: '#34a853',
            confirmButtonText: 'Yes',
            denyButtonColor: '#d33',
            denyButtonText: "No"
        }).then((result) => {
            if (result.isConfirmed) {
                jQuery('#form-update-journey' + i + '').submit();
            } else if (result.isDenied) {
                $('#part-detail').modal('show');
            }
        });
        return false;
    });
}
$('.save-updt-sch-en').on('click', function () {
    if ($('#dt-sch-en').val() === "" || $('#tm-sch-en').val() === "") {
        Swal.fire({
            title: "The field cannot be empty!",
            text: "Select date and time for updating schedule Engineer!",
            icon: "warning",
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK',
        });
    } else {
        jQuery('#form-updt-sch-en').submit();
    }
    return false;
});
$('.save-updt-sla').on('click', function () {
    Swal.fire({
        title: "Continue change SLA?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#34a853',
        confirmButtonText: 'Next',
        cancelButtonColor: '#d33',
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {
            jQuery('#form-updt-sla').submit();
        }
    });
    return false;
});
// form
$('.create').on('click', function () {

    // fungsi get value double function id unit
    function getTypeValue() {
        var unit_type_id = document.getElementById("unit-type-id").value;
        return unit_type_id;
    };

    function getProjectValue() {
        var project_id_val = document.getElementById("project-id").value;
        return project_id_val;
    };

    function getPartnerValue() {
        var partner_id_val = document.getElementById("partner-select").value;
        return partner_id_val;
    };

    function getProvinceValue() {
        var province_id_val = document.getElementById("provinces").value;
        return province_id_val;
    };

    function getCitiesValue() {
        var cities_id_val = document.getElementById("cities-select").value;
        return cities_id_val;
    };

    function getEngineerValue() {
        var engineer_id_val = document.getElementById("engineer").value;
        return engineer_id_val;
    };

    function getServPValue() {
        var sp_id_val = document.getElementById("servp").value;
        return sp_id_val;
    };
    // end funsi
    // Form Part Request
    var rqs_part_sts = document.getElementById("rqs-part-validate").getElementsByTagName('input');
    var checked_rqs_part_sts = false;
    let val_rqs_part_sts = "";
    for (var i = 0; i < rqs_part_sts.length; i++) {
        if (rqs_part_sts[i].checked) {
            checked_rqs_part_sts = true;
            val_rqs_part_sts = rqs_part_sts[i].value;
            break;
        }
    }
    // end form
    if ($('#type-ticket').val() === "" || $('.dt-incoming-tc').val() === "" ||
    $('#id-source').val() === "" || $('#id-sla').val() === "" || !checked_rqs_part_sts || getProjectValue() === "") {
        if ($('#type-ticket').val() === "") {
            Swal.fire({
                title: "Type ticket must be choosen!",
                icon: "warning",
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK',
            });
        } else if ($('.dt-incoming-tc').val() === "") {
            Swal.fire({
                title: "Pick Date Time Ticket Coming!",
                icon: "warning",
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK',
            });
        } else if ($('#id-source').val() === "") {
            Swal.fire({
                title: "Choose source ticket from!",
                icon: "warning",
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK',
            });
        } else if ($('#id-sla').val() === "") {
            Swal.fire({
                title: "Select SLA for the ticket!",
                icon: "warning",
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK',
            });
        } else if (!checked_rqs_part_sts) {
            Swal.fire({
                title: "Checked Part Request!",
                icon: "warning",
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK',
            });
        } else if (getProjectValue() === "") {
            if (getPartnerValue() === "") {
                Swal.fire({
                    title: "Select Partner for show Project!",
                    icon: "warning",
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK',
                });
            } else {
                Swal.fire({
                    title: "Find and Select the Project!",
                    icon: "warning",
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#find-project').modal('show');
                    }
                });
            }
        }
    } else {
        if (getTypeValue() !== "" && $('#type-unit-optional').val() !== "") {
            Swal.fire({
                title: "Select one of unit type name!!",
                icon: "warning",
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK',
            });
        } else if ($('#type-unit-optional').val() !== "" && ($('#ctgr-cu-id').val() === "" || $('#merk-u-id').val() === "")) {
            if ($('#ctgr-cu-id').val() === "" && $('#merk-u-id').val() === "") {
                Swal.fire({
                    title: "Name type is not initialized!!",
                    text: "Select Category and Merk for initialize!!",
                    icon: "warning",
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK'
                });
            } else if ($('#ctgr-cu-id').val() === "") {
                Swal.fire({
                    title: "Initialize Category is Null!!",
                    text: "Select Category for initialize!!",
                    icon: "warning",
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK'
                });
            } else if ($('#merk-u-id').val() === "") {
                Swal.fire({
                    title: "Initialize Merk is Null!!",
                    text: "Select Merk for initialize!!",
                    icon: "warning",
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK'
                });
            }
        } else if (($('#ctgr-cu-id').val() !== "" && $('#merk-u-id').val() !== "") && (getTypeValue() === "" && $('#type-unit-optional').val() === "")) {
            Swal.fire({
                title: "Type Unit is Null!!",
                text: "Select or type a new name unit!!",
                icon: "warning",
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK'
            });
        } else if (val_rqs_part_sts === '1' && ($('#part-status').val() === "" || $('#kat-part').val() === "" || $('#part-name-detail').val() === "")) {
            if ($('#part-status').val() === "") {
                Swal.fire({
                    title: "Status of Part its empty!!",
                    text: "Select Status for this part!!",
                    icon: "warning",
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#find-part').modal('show');
                    }
                });
            } else if ($('#kat-part').val() === "") {
                Swal.fire({
                    title: "Category Part must be choosen!!",
                    text: "Choose Category!!",
                    icon: "warning",
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#find-part').modal('show');
                    }
                });
            } else if ($('#part-name-detail').val() === "") {
                Swal.fire({
                    title: "Part name is Null!!",
                    text: "Initialize part name!!",
                    icon: "warning",
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#find-part').modal('show');
                    }
                });
            }
        } else {
            Swal.fire({
                title: 'Continue Create Ticket?',
                text: 'Put how much you want to create ticket!',
                icon: 'question',
                input: 'number',
                inputValue: 1,
                inputAttributes: {
                    autocapitalize: 'off',
                    max: 150,
                    name: "how_many",
                    required: true
                },
                showCancelButton: true,
                confirmButtonColor: '#34a853',
                confirmButtonText: 'Save',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancel',
                inputPlaceholder: "Many Tickets",
                allowOutsideClick: false, // Prevent closing the dialog by clicking outside
                inputValidator: (value) => {
                    if (!value || value > 150) {
                        return 'Please enter a number up to 150.';
                    }
                }
            }).then((result) => {
                if (result.value && result.value <= 150) {
                    jQuery('#many-tickets').val(result.value);
                    jQuery('#create_ticket').submit();
                }
            });
        }
    }
    return false;
});
$(document).on("click", ".select-project", function () {
    let prj_id = $(this).closest('tr').find('td:eq(1)').text();
    let prj_name = $(this).closest('tr').find('td:eq(2)').text();
    let prj_owner = $(this).closest('tr').find('td:eq(3)').text();
    let prj_pic = $(this).closest('tr').find('td:eq(4)').text();
    $('#project-id').val(prj_id);
    $('#project-name').val(prj_name);
    $('#find-project').modal('hide');
});
$('.clear-prj').click(function () {
    $('#project-id').val('');
    $('#project-name').val('');
});

function modalPart() {
    var selectedRadio = document.querySelector('input[name="part_reqs"]:checked');
    switch (selectedRadio.value) {
        case "1": {
            setTimeout(function () {
                $('#find-part').modal('show')
            }, 500);
        }
        break;
    }
};

function showClearButton() {
    document.querySelector('.file-clear').style.display = 'inline-block';
}

function clearFileInput() {
    document.querySelector('.file').value = '';
    document.querySelector('.file-clear').style.display = 'none';
}

setInterval(function () {
    const now = new Date();

    const selisihWaktuElems = document.querySelectorAll('.dif-selisih-waktu');

    selisihWaktuElems.forEach(function (elem) {
        const datetimeFromDB = elem.getAttribute('data-datetime');

        const [dateStr, timeStr] = datetimeFromDB.split(' ');
        const [year, month, day] = dateStr.split('-');
        const [hour, minute, second] = timeStr.split(':');

        const datetimeObj = new Date(year, month - 1, day, hour, minute, second);

        let diffInSeconds = Math.floor((now.getTime() - datetimeObj.getTime()) / 1000);

        if (diffInSeconds >= 86400) {
            const diffInDays = Math.floor(diffInSeconds / 86400);
            diffInSeconds -= diffInDays * 86400;
            const diffInHours = Math.floor(diffInSeconds / 3600);
            diffInSeconds -= diffInHours * 3600;
            const diffInMinutes = Math.floor(diffInSeconds / 60);
            diffInSeconds -= diffInMinutes * 60;
            elem.textContent =
                `${diffInDays} hari, ${diffInHours} jam, ${diffInMinutes} menit yang lalu`;
        } else if (diffInSeconds >=
            3600) {
            const diffInHours = Math.floor(diffInSeconds / 3600);
            diffInSeconds -= diffInHours * 3600;
            const diffInMinutes = Math.floor(diffInSeconds / 60);
            diffInSeconds -= diffInMinutes * 60;
            elem.textContent = `${diffInHours} jam, ${diffInMinutes} menit yang lalu`;
        } else if (diffInSeconds >=
            60) {
            const diffInMinutes = Math.floor(diffInSeconds / 60);
            diffInSeconds -= diffInMinutes * 60;
            elem.textContent = `${diffInMinutes} menit, ${diffInSeconds} detik yang lalu`;
        } else {
            elem.textContent = `${diffInSeconds} detik yang lalu`;
        }
    });
}, 1000);
// PIC
$('.store-pic-act').on('click', function () {
    if ($('#act-pic-desc').val() === "" && $('#select-val-tap').val() === "" && $('.date-time-tap').val() === "") {
        Swal.fire({
            title: "Field Cannot be Empty",
            icon: "warning",
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK',
        });
    } else if ($('.date-time-tap').val() === "") {
        Swal.fire({
            title: "Choose the date & time!!",
            icon: "warning",
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK',
    });
    } else if ($('#select-val-tap').val() === "") {
        Swal.fire({
            title: "Select type of Activity!",
            icon: "warning",
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK',
        });
    } else if ($('#act-pic-desc').val() === "") {
        Swal.fire({
            title: "Type your description!",
            icon: "warning",
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK',
        });
    } else {
        jQuery("#store-pic-act").submit();
    }
    return false;
});
$('.btn-store-tap').on('click', function () {
    if ($('#val-tap').val() === "") {
        Swal.fire({
            title: "Type Cannot be Empty",
            icon: "warning",
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK',
        });
    } else {
        jQuery("#fm-store-tap").submit();
    }
    return false;
});
// END PIC
for (let i = 0; i < 999; i++) {
    // CRUD Add Activity
    $('.fm-dt-desc' + i + '').on('click', function () {
        Swal.fire({
            title: "Continues Edit?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#34a853',
            confirmButtonText: 'Yes',
            cancelButtonColor: '#d33',
            cancelButtonText: "No"
        }).then((result) => {
            if (result.isConfirmed) {
                jQuery('#fm-dt-desc' + i + '').submit();
            }
        });

        return false;
    });
    $('.remove-act-desc' + i + '').on('click', function () {
        Swal.fire({
            title: "Continues Delete?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#34a853',
            confirmButtonText: 'Yes',
            cancelButtonColor: '#d33',
            cancelButtonText: "No"
        }).then((result) => {
            if (result.isConfirmed) {
                jQuery('#remove-act-desc' + i + '').submit();
            }
        });
        return false;
    });
    // CRUD Add Type Activity
    $('.btn-edt-tap' + i + '').on('click', function () {
        Swal.fire({
            title: "Continues Edit?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#34a853',
            confirmButtonText: 'Yes',
            cancelButtonColor: '#d33',
            cancelButtonText: "No"
        }).then((result) => {
            if (result.isConfirmed) {
                jQuery('#fm-edt-tap' + i + '').submit();
            }
        });

        return false;
    });
    $('.btn-destroy-dt-tap' + i + '').on('click', function () {
        Swal.fire({
            title: "Continues Delete?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#34a853',
            confirmButtonText: 'Yes',
            cancelButtonColor: '#d33',
            cancelButtonText: "No"
        }).then((result) => {
            if (result.isConfirmed) {
                jQuery('#fm-destroy-dt-tap' + i + '').submit();
            }
        });
        return false;
    });
}
// document.addEventListener("keydown", function (event) {
//     if (event.key === "Enter") {
//         if ($('.modal').is(':visible')) {
//             document.getElementById("saveButton").click();
//         }
//     }
// });
// ICONS CALLBACK
feather.replace();

// SVGs
$('#svgDribbble').load('https://s3-us-west-2.amazonaws.com/s.cdpn.io/373860/references.html #dribbble');
$('#svgTwitter').load('https://s3-us-west-2.amazonaws.com/s.cdpn.io/373860/references.html #twitter');

/*

ADD NEW ICONS
Take it from
https://feathericons.com/

And then replace the icon name in data-father.
<i data-feather="circle"></i>

*/

// NEW CODE HERE

// Focus
$('.text-field').focus(function () {
    if (true) {

        // Expand resoluts bar
        setTimeout(function () {
            $('.resoult-tab').addClass('resoult-tab-active');
        }, 199);

        // Ul title
        setTimeout(function () {
            $('.ul-title').animate({
                opacity: 1
            }, 299);
        }, 299);
        // List fade in
        setTimeout(function () {
            $('.li').addClass('li-active');
        }, 0);

        // Icon
        $('.search-icon').animate({
            opacity: .3
        }, 69, 'linear', function () {
            // Icon
            $('.text-field').focusout(function () {
                $('.search-icon').animate({
                    opacity: 1
                }, 69, 'linear', function () {

                    // Shrink resoluts bar
                    setTimeout(function () {
                        $('.resoult-tab').removeClass('resoult-tab-active');
                    }, 329);

                    // Ul title
                    $('.ul-title').animate({
                        opacity: 0
                    }, 299);

                    // List fade out
                    setTimeout(function () {
                        $('.li').removeClass('li-active');
                    }, 99);
                    $('.li').animate({
                        opacity: 0
                    }, 299);
                });
            });
        });

        // Text
        $('.search-placeholder').animate({
            opacity: 0
        }, 69, 'linear', function () {

            // NO FOCUS
            $('.text-field').focusout(function () {
                // if filled
                if (true && $('.text-field').val().length >= 1) {
                    $('.search-placeholder').css('opacity', '0');
                    console.log('very valid');
                }
                // if empty
                else if (true && $('.text-field').val().length == 0) {
                    $('.search-placeholder').animate({
                        opacity: 1
                    }, 99);
                    console.log('non valid');
                }
            });
        });
        console.log('Focus');
    }
});
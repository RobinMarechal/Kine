import Doctor from "../models/Doctor";

function showDoctorDialog(el) {
    const doctorId = el.data('id');

    Doctor.get(doctorId, "with=contacts")
        .then(doctor => {
            console.log(doctor);
        })
        .catch(() => {

        });
}

export default function footerDoctors() {
    const el = ".footer-doctor-name";

    $(el).click(function () {
        showDoctorDialog($(this));
    });
}
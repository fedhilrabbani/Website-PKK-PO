function checkNotempty () {
    const username = document.getElementById('username');
    const password =  document.getElementById('password');

    if (username.value == "" || password.value == "") {
        event.preventDefault();

        Swal.fire({
            icon: "error",
            title: "Masukkan semua data!",
            showConfirmButton: false,
            timer: 1500
        });
    }
}

function checkPassword () {
    const password =  document.getElementById('password');

    if (password.value.length < 8) {
        Swal.fire({
            icon: "error",
            title: "Password tidak boleh kurang dari 8!",
            showConfirmButton: true,
        });
    }

    if (password.value == "") {
        Swal.fire({
            icon: "error",
            title: "Isi dulu kocak passwordnya !",
            showConfirmButton: true,
        });
    }
}

function confirmPassword () {
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('checkpassword');


    if (confirmPassword.value !== password.value) {
        event.preventDefault();

        Swal.fire({
            icon: "error",
            title: "Password tidak sesuai!",
            showConfirmButton: false,
            timer: 1500
          });
    }
    if (password.value.length <8 || confirmPassword.value.length <9) {
        Swal.fire({
            icon: "error",
            title: "Password tidak boleh kurang dari 8!",
            showConfirmButton: true,
        });
    }
}
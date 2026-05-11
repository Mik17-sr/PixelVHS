window.alertaRetro = ({
    titulo,
    texto,
    icono = 'success',
    boton = 'CONTINUAR'
}) => {

    Swal.fire({
        title: titulo,

        html: `
            <div class="retro-alert-content">
                ${texto}
            </div>
        `,
        icon: icono,
        confirmButtonText: boton,
        background: '#09040f',
        color: '#d8d2ff',
        customClass: {
            popup: 'retro-popup',
            title: 'retro-title',
            htmlContainer: 'retro-html',
            confirmButton: 'retro-confirm',
            icon: 'retro-icon'
        },
        buttonsStyling: false,
        showClass: {
            popup: `
                animate__animated
                animate__fadeInDown
                animate__faster
            `
        },
        hideClass: {
            popup: `
                animate__animated
                animate__fadeOutUp
                animate__faster
            `
        }
    });
};
const toggleButtons = document.querySelectorAll('.toggle-details');

toggleButtons.forEach(button => {
  button.addEventListener('click', () => {
    const details = button.nextElementSibling;

    if (details.style.display === 'none' || details.style.display === '') {
      details.style.display = 'block';
      button.textContent = 'Ocultar Detalles';
    } else {
      details.style.display = 'none';
      button.textContent = 'Mostrar Detalles';
    }
  });
});

function confirmacion(aptoId) {
    Swal.fire({
      title: '¿Estás seguro de eliminar a este usuario?',
      text: 'Esta acción no se puede deshacer',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "files_php/delete_user.php?deleteid=" + aptoId;
      }
    });
  }
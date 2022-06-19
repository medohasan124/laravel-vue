// ES6 Modules or TypeScript
import Swal from 'sweetalert2'

// CommonJS
window.Swal = Swal ;

  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  });

window.Toast = Toast ;

export default Toast  ;

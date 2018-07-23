<script language="JavaScript">
function confirmar($option){
  switch ($option) {
    case 'bloqueo':
        return confirm('¿Está seguro que quiere bloquear este usuario?');
      break;
    case 'activa':
        return confirm('¿Quiere activar este usuario?');
      break;
    case 'new_config':
        return confirm('Se cabiará la configuracion del sistema. ¿Desea Continuar?');
      break;
    case 'elimina_usr':
        return confirm('Se eliminará el usuario del sistema, ¿Desea Continuar?');
      break;
    case 'elimina_revision':
        return confirm('Se eliminará la visita del sistema, ¿Desea Continuar?');
      break;
    case 'new_paciente':
        return confirm('¿Quiere agregar al sistema el paciente con sus datos demograficos?')
      break;
    case 'elimina_paciente':
      return confirm('Se eliminará el paciente del sistema, ¿Desea Continuar?');
      break;
    case 'update_paciente':
      return confirm('¿Seguro que quiere editar el paciente?');
      break;
    case 'update_usuario':
      return confirm('¿Seguro que quiere editar este usuario?');
      break;
    case 'new_usuario':
      return confirm('¿Seguro que quiere agregar este nuevo usuario?');
      break;
  }
}

function aviso($mensaje) {
  alert('$mensaje');
}

</script>

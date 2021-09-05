function removeModal(id){
 $(id).modal('hide');
 $('.modal-backdrop').removeClass('show');
 $('.modal-backdrop').addClass('hide');
 $('.modal').removeClass('show');
 $('.modal').addClass('hide');
}

// Get the modal
var modalVid = document.getElementById('modal-video');

function launchModal(filename, cheminDossier){
    var tableauFic = filename.split('.');
    console.log(cheminDossier);

    switch (tableauFic[1]){
        case 'mp4':
            document.getElementById("myVid").src = cheminDossier;
            $('#modal-video').modal('show');
            break;
        case 'jpg':
            document.getElementById("myImg").src = cheminDossier;
            $('#modal-image').modal('show');
            break;
    }
}

function closeModal(){
    var vid = document.getElementById("myVid");
    vid.pause();
}

$(MyVidModal).keyup(function(e) {
    if (e.keyCode = 27) {

    }
});

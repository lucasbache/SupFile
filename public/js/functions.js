// Get the modal
var modalVid = document.getElementById('modal-video');

function launchModal(filename, cheminDossier){
    var tableauFic = filename.split('.');

    switch (tableauFic[1]){
        case 'mp4':
            document.getElementById("myVid").src = cheminDossier;
            $('#modal-video').modal('show');
            break;
        case 'jpg':
            document.getElementById("myImg").src = cheminDossier;
            $('#modal-image').modal('show');
            break;
        case 'jpeg':
            document.getElementById("myImg").src = cheminDossier;
            $('#modal-image').modal('show');
            break;
        case 'png':
            document.getElementById("myImg").src = cheminDossier;
            $('#modal-image').modal('show');
            break;
        case 'txt':
            document.getElementById("myDoc").src = cheminDossier;
            $('#modal-doc').modal('show');
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

$(document).on("click", ".open-modal-publicLink", function () {
    var publickLink = $(this).data('id');
    $(".modal-body #publicLinkButton").val( publickLink );
});

function copyClipboard() {
    var copyText = document.getElementById("publicLinkButton");
    copyText.select();
    document.execCommand("copy");
}

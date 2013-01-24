function enableEdit(id){
    var trId = document.getElementById(id);
    var array = trId.getElementsByTagName("input")
    var arrayLength = array.length;
    var coverId = document.getElementsById("cover"+id);
    
    for(i=0;i<arrayLength;i++){
        array[i].disabled = false;
    }
    
    coverId.onclick="uploadCover(coverId)";
}

function uploadCover(coverId){
    coverId.innerHTML="<input type='file' name='image$id'>";
}
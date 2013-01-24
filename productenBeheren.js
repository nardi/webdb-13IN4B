function enableEdit(id){
    var trId = document.getElementById(id);
    var array = trId.getElementsByTagName("input")
    var arrayLength = array.length;
    var coverId = document.getElementById("cover"+id);
    
    for(i=0;i<arrayLength;i++){
        array[i].disabled = false;
    }
    
    coverId.onclick=function(){uploadCover(coverId, id)};
}

function uploadCover(coverId, id){
    coverId.innerHTML="<input type='file' name='image'"+id">";
}
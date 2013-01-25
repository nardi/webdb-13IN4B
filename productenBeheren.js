function enableEdit(id){
    var trId = document.getElementById(id);
    var array = trId.getElementsByTagName("input");
    var txtAreaArray = trId.getElementsByTagName("textarea");
    var selectArray = trId.getElementsByTagName("select");
    var arrayLength = array.length;
    var txtAreaArrayLength = txtAreaArray.length;
    var selectArrayLength = selectArray.length;
    var coverId = document.getElementById("cover"+id);
    
    for(i=0;i<arrayLength;i++){
        array[i].disabled = false;
    }
    
    for(i=0;i<txtAreaArrayLength;i++){
        txtAreaArray[i].disabled = false;
    }
    
    for(i=0;i<selectArrayLength;i++){
        selectArray[i].disabled = false;
    }
    
    coverId.onclick=function(){uploadCover(coverId, id);};
}

function uploadCover(coverId, id){
    coverId.innerHTML="<input class='fileupload' type='file' name='image'"+id+">";
    coverId.onclick="";
}

function expand(id, beschrijvingSize){
    id.rows=beschrijvingSize;
}

function shrink(id){
    id.rows='1';
}

function showImage(id){
    id.innerHTML="$cover_var";
}
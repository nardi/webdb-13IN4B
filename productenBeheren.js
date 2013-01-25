function enableEdit(id){
    var trId = document.getElementById(id);
    var array = trId.getElementsByTagName("input");
    var txtAreaArray = trId.getElementsByTagName("textarea");
    var txtAreaArrayLength = txtAreaArray.length;
    var arrayLength = array.length;
    var coverId = document.getElementById("cover"+id);
    
    for(i=0;i<arrayLength;i++){
        array[i].disabled = false;
    }
    
    for(i=0;i<txtAreaArrayLength;i++){
        txtAreaArray[i].disabled = false;
    }
    
    coverId.onclick=function(){uploadCover(coverId, id);};
}

function uploadCover(coverId, id){
    coverId.innerHTML="<input class='fileupload' type='file' name='image'"+id+">";
    coverId.onclick="";
}

function expand(id, beschrijvingSize){
    document.getElementById(id).rows=beschrijvingSize;
}

function shrink(id){
    document.getElementById(id).rows='1';
}
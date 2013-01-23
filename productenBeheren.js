function enableEdit(id){
    var trId = document.getElementById(id);
    var array = trId.getElementsByTagName("input")
    var arrayLength = array.length;
    
    for(i=0;i<arrayLength;i++){
        array[i].disabled = false;
    }
}
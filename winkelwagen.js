function changeAmount(id)
{
    var xhr = new XMLHttpRequest();
    var amountElem = document.getElementById('amount-' + id);
    var amount = amountElem.value;
    var url = 'backend/hoeveelheden.php';
    var params = 'amount-' + id + '=' + amount;
    xhr.open('POST', url);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.setRequestHeader("Content-length", params.length);
    xhr.setRequestHeader("Connection", "close");
    xhr.onreadystatechange = function()
    {
        if (xhr.readyState == 4 && xhr.responseText == 'success')
        {
            recalculateTotalPrice();
        }
    };
    xhr.send(params);
}

function recalculateTotalPrice()
{
    var ids = document.getElementsByName('product-id');
    var totalPrice = 0.0;
    for (var id in ids)
    {
        id = id.innerHTML;
        var amount = parseFloat(document.getElementById('amount-' + id).innerHTML);
        var price = parseFloat(document.getElementById('price-' + id).innerHTML);
        totalPrice += amount * price;
    }
    document.getElementById('total-price').innerHTML = totalPrice.toString();
} 
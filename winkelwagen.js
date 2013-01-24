function changeAmount(id)
{
    var xhr = new XMLHttpRequest();
    var amountElem = document.getElementById('amount-' + id);
    var amount = parseInt(amountElem.value);
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
    var totalPrice = parseFloat(document.getElementById('shipping').innerHTML);
    for (var i = 0; i < ids.length; i++)
    {
        var id = ids[i].innerHTML;
        var amount = parseInt(document.getElementById('amount-' + id).value);
        var price = parseFloat(document.getElementById('price-' + id).innerHTML.replace(',', '.'));
        var productPrice = Math.round(amount * price * 100) / 100;
        document.getElementById('productprice-' + id).innerHTML = productPrice.toString().replace('.', ',');
        totalPrice += productPrice;
    }
    document.getElementById('total-price').innerHTML = totalPrice.toString().replace('.', ',');
} 
function changeAmount(id)
{
    var xhr = new XMLHttpRequest();
    var amountElem = document.getElementById('amount-' + id);
    var amount = parseInt(amountElem.value);
    if (!isNaN(amount))
    {
        var url = 'backend/hoeveelheden.php';
        var params = 'amount-' + id + '=' + amount;
        xhr.open('POST', url);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.setRequestHeader("Content-length", params.length);
        xhr.setRequestHeader("Connection", "close");
        xhr.onreadystatechange = function()
        {
            if (xhr.readyState == 4)
            {
                recalculateTotalPrice(JSON.parse(xhr.responseText));
            }
        };
        xhr.send(params);
    }
}

function recalculateTotalPrice(json)
{
    document.getElementsByTagName('h1')[0].innerHtml = JSON.stringify(json);
}

/* function recalculateTotalPrice()
{
    var ids = document.getElementsByName('product-id');
    var totalPrice = parseFloat(document.getElementById('shipping').innerHTML.replace(',', '.'));
    for (var i = 0; i < ids.length; i++)
    {
        var id = ids[i].innerHTML;
        var amount = parseInt(document.getElementById('amount-' + id).value);
        var price = parseFloat(document.getElementById('price-' + id).innerHTML.replace(',', '.'));
        var productPrice = Math.round(amount * price * 100) / 100;
        document.getElementById('productprice-' + id).innerHTML = productPrice.toFixed(2).replace('.', ',');
        totalPrice += productPrice;
    }
    totalPrice = Math.round(totalPrice * 100) / 100;
    document.getElementById('total-price').innerHTML = totalPrice.toFixed(2).replace('.', ',');
} */
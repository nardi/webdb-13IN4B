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
    xhr.onreadystatechange = function()
    {
        if (xhr.readyState == 4)
        {
            recalculateTotalPrice(JSON.parse(xhr.responseText));
        }
    };
    xhr.send(params);
}

function recalculateTotalPrice(ww)
{
    var totalPrice = parseFloat(document.getElementById('shipping').innerHTML.replace(',', '.'));
    for (id in ww)
    {
        var amount = parseInt(ww[id]);
        document.getElementById('amount-' + id).value = amount;
        var price = parseFloat(document.getElementById('price-' + id).innerHTML.replace(',', '.'));
        var productPrice = Math.round(amount * price * 100) / 100;
        document.getElementById('productprice-' + id).innerHTML = formatPrice(productPrice);
        totalPrice += productPrice;
    }
    totalPrice = Math.round(totalPrice * 100) / 100;
    document.getElementById('total-price').innerHTML = formatPrice(totalPrice);
}

function formatPrice(prijs)
{
    if (Math.round(prijs) == prijs)
        return prijs.toFixed() + ',-';
    return prijs.toFixed(2).replace('.', ',');
}
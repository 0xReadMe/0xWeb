function Donfromsw() {
var sum = $("#sum").val();
if (sum < 10) {
} else {
location.href="https://unitpay.ru/pay/22892-286bb?sum=" + sum + "&account=donate&desc=Пожертвование+на+развитие+проекта+Agro+World";
    }
}